<?php

namespace App\Providers;

use App\Mail\userCreated;
use App\Mail\userMailChanged;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

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
        User::created(function ($user){
            Mail::to($user)->send(new userCreated($user));
        });

        User::updated(function ($user){
            if($user->isDirty('email')){

                Mail::to($user)->send(new userMailChanged($user));
            }
        });
    }
}
