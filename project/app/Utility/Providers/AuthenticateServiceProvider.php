<?php namespace App\Utility\Providers;

use App\Models\User;
use App\Utility\Authenticators\TokenAuthenticator;
use Illuminate\Support\ServiceProvider;

class AuthenticateServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('authenticate', function($app) {
            return new TokenAuthenticator(new User());
        });

    }
}
?>