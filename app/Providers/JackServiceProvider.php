<?php

namespace App\Providers;

use Illuminate\Support\Facades\Jack;
use Illuminate\Support\ServiceProvider;

class JackServiceProvider extends ServiceProvider {

    public function register() {
        $this->app->bind('jack', \App\Libraries\Jack::class);
        $this->app->bind('ewash', \App\Libraries\EWash::class);
    }
}