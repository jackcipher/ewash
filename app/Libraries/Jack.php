<?php

namespace App\Libraries;
use GuzzleHttp\Client;

class Jack {

    private $token;
    private $client;

    function test() {
        echo 'run ok';
    }

    function run() {
        $this->client = new Client(['cookies'=>true]);
        $this->parseToken();
        $this->sendCode();
    }

    private function parseToken() {
        $res = $this->client->request('GET', 'http://www.whewash.com/ewashwx/regedit/regeditPage');
        echo $res->getStatusCode().PHP_EOL;
        $html = $res->getBody();
        preg_match('/yxlToken=[a-zA-Z0-9]{32}/', $html, $output);
        $this->token = explode('=', $output[0])[1];
    }

    private function sendCode() {
        $res = $this->client->request('GET', "http://www.whewash.com/ewashwx/regedit/getYzm123?yxlToken={$this->token}&msgType=register&phoneNumber=15071445382");
        echo $res->getStatusCode().PHP_EOL;
        $html = $res->getBody();
        echo $html;
        //{"message":"success","msgType":"register","phoneNumber":"15071445382","yxlToken":"ce44d2406abd11e8b98ce7244e01f37c"}
    }
}