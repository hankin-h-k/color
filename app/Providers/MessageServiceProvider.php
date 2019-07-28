<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\MessageService;

class MessageServiceProvider extends ServiceProvider

{

    public function boot()

    {

    }

    public function register()

    {

        $this->app->singleton('message', function(){

            return new MessageService();

        });

    }

}