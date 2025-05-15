<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('firebase', function ($app) {
            return (new Factory)
                ->withServiceAccount(config('firebase.credentials.file'))
                ->withDatabaseUri(config('firebase.database_url'))
                ->createDatabase();
        });
    }
}