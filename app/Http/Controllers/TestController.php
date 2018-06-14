<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //Test Request
    public function test(Request $request) {
        $user = $request->get('user');
        echo $user;
        $this->validate($request, [
            'user'=>'required|string'
        ]);
    }
}
