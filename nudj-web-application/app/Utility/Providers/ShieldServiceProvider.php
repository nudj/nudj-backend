<?php namespace App\Utility\Providers;

use App\Models\User;

use App\Utility\Authenticator\Shield;
use Illuminate\Support\ServiceProvider;

class ShieldServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('shield', function($app) {
            return new Shield(new User());
        });

    }
}
