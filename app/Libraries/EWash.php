<?php

namespace App\Libraries;
use GuzzleHttp\Client;
use App\Events\NewPhonenumEvent;
use App\Events\RegOk;

class EWash {

    public $phonenum;
    private $token;
    private $client;

    function __construct() {
        $client = new Client();
        $res = $client->get("http://api.fxhyd.cn/UserInterface.aspx?action=login&username=tiredoy&password=91tiredoygo");
        $this->token = explode("|", $res->getBody())[1];
        echo "System Init: 获取token:{$this->token}".PHP_EOL;
    }


    function run() {
        while(true) {
            $this->getPhonenum();
            $this->readCookie();
            $this->sendCode();
            try {
                $this->readCode();
            } catch (\Exception $e) {
                echo PHP_EOL."读取验证码时间过长，将抛弃当前一条号码后重试".PHP_EOL;
                $this->release();
                continue;
            }
            $this->do_reg();
        }
    }

    private function release() {
        $url1 = "http://api.fxhyd.cn/UserInterface.aspx?action=release&token={$this->token}&itemid=12695&mobile={$this->phonenum}";
        $url2 = "http://api.fxhyd.cn/UserInterface.aspx?action=addignore&token={$this->token}&itemid=12695&mobile={$this->phonenum}";
        $client = new Client();
        $client->get($url1);
        $client->get($url2);
    }

    private function getPhonenum() {
        $client = new Client();
        $res = $client->get("http://api.fxhyd.cn/UserInterface.aspx?action=getmobile&token={$this->token}&itemid=12695&province=420000&city=420100");
        $this->phonenum = explode("|", $res->getBody())[1];
        echo "step 1/4 申请到号码:{$this->phonenum}".PHP_EOL;
        event(new NewPhonenumEvent($this->phonenum));
    }

    private function readCookie() {
        $this->client = new Client(['cookies'=>true]);
        $res = $this->client->get('http://www.whewash.com/ewashwx/regedit/regeditPage');
        preg_match('/yxlToken=[a-zA-Z0-9]{32}/', $res->getBody(), $output);
        $this->yxlToken = explode('=', $output[0])[1];
    }

    private function sendCode() {
        $res = $this->client->get("http://www.whewash.com/ewashwx/regedit/getYzm123?yxlToken={$this->yxlToken}&msgType=register&phoneNumber={$this->phonenum}");
        $json_content = $res->getBody();
        $data = json_decode($json_content, true);
        echo "step 2/4 发送验证码成功".PHP_EOL;
    }

    private function readCode() {
        $count = 1;
        $data = "";
        $client = new Client();
        while(true) {
            echo "[{$count}]尝试读取验证码, 5s后重试...".PHP_EOL;
            sleep(5);
            $url = "http://api.fxhyd.cn/UserInterface.aspx?action=getsms&token={$this->token}&itemid=12695&mobile={$this->phonenum}&release=1";
            $data = file_get_contents($url);
            if($data != "3001")
                break;
            ++$count;
            if($count >10) {
                throw new \Exception('account down');
            }
        }
        $sms = explode("|", $data)[1];
        preg_match('/\d{4}/', $sms, $output);
        $this->sms_code = $output[0];
        echo "step 3/4 获取到验证码 {$this->sms_code}" . PHP_EOL;
        
    }

    private function do_reg() {
        $passwd = 1234;
        $res = $this->client->post("http://www.whewash.com/ewashwx/regedit/submitRegedit",[
            'form_params' => [
                'headimgurl' => '',
                'openid' => '',
                'id' =>'',
                'pvalue' => 10,
                'tjr' => '',
                'account' => $this->phonenum,
                'nickname' => '',
                'yzm' => $this->sms_code,
                'pswd' => $passwd,
                'password' => $passwd,
                'car_num' => '',
                'orgcode' => 100000100001,
                'ck_clause' => ''
            ]
        ]);
        $data = $res->getBody();
        $json_data = json_decode($data, true);
        if($json_data['message'] == 'success') {
            event(new RegOk($this->phonenum, $passwd));
        }
        echo "step 4/4 注册成功" . PHP_EOL;
        echo "账号 {$this->phonenum} 密码 {$passwd}" . PHP_EOL;
        echo PHP_EOL.$data.PHP_EOL.PHP_EOL;
        echo "-----------------------------------------" . PHP_EOL;
    }

}