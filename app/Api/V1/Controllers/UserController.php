<?php

namespace App\Api\V1\Controllers;

class User extends Controller {

    function show($id) {
        $user = User::findOrFail($id);
        return $this->response->array($user->toArray());
    }
}