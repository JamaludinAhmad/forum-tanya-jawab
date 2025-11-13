<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        Gate::define('update-answer', function (User $user, Answer $answer){
            return $user->id === $answer->user_id;
        });

        Gate::define('delete-answer', function (User $user, Answer $answer){
            return $user->id === $answer->user_id;
        });
    }
}
