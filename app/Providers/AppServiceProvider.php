<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share([
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
        ]);
  
        Inertia::share('flash', function () {
            return [
                'message' => Session::get('message'),
            ];
        });
        Inertia::share('basket', function () {
            return [
                'basket' => Session::get('basket'),
            ];
        });
        Inertia::share('user_id', function () {
            if (Session::has('user_id')) {
                return  Session::get('user_id');
            } else {
                return false;
            }

        });
        Inertia::share('auth.user', function (){
            return[
                'loggedIn' => Auth::check(),
            ];
        });
        Inertia::share('auth.role', function (){
            if (Auth::check() == true) {
                $user = Auth::user();
                return[
                    'can' => Auth::user()->hasRole('admin'),
                ];
            } else {
                return[
                    'can' => false,
                ];
            }

        });
        Inertia::share('user', function (){
            if (Auth::check() == true) {
                $user = Auth::user();
                return[
                    'user' => Auth::user(),
                ];
            } 

        });

    }
}
