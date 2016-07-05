<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(){
        View::composer('layouts.header_menu', 'App\Http\Composers\HeadComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(){
        //
    }
}
