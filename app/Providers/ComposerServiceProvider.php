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
//<<<<<<< HEAD
        View::composer('homeSimpleUser', 'App\Http\Composers\HeadComposer');

//=======
        View::composer('homeOwnerUser', 'App\Http\Composers\HeadComposer');
        View::composer('homeSimpleUser', 'App\Http\Composers\HeadComposer');
//>>>>>>> 449e71024804298cdb127c44db7b02a84e391dd0
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
