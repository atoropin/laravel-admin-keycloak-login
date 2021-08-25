<?php


namespace Rusatom\LaravelAdminKeycloak;


class LaravelAdminKeycloakServiceProvider
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
        $this->publishes([
            __DIR__ . '/../config/laravel_admin_keycloak.php' => config_path('laravel_admin_keycloak.php')
        ]);

        $this->bootAdminKeycloakSocialite();

        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::namespace('Rusatom\LaravelAdminKeycloak\Controllers')
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/routes.php');
            });
    }

    /**
     * Extend Socialite config for Laravel-admin login.
     */
    private function bootAdminKeycloakSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'laravel_admin_keycloak',
            function ($app) use ($socialite) {
                $config = $app['config']['services.keycloak_admin'];
                $configClass = new \SocialiteProviders\Manager\Config(
                    $app['config']['laravel_admin_keycloak.client_id'],
                    $app['config']['laravel_admin_keycloak.client_secret'],
                    $app['config']['laravel_admin_keycloak.redirect'],
                    $app['config']['laravel_admin_keycloak']
                );
                return $socialite->buildProvider(\SocialiteProviders\Keycloak\Provider::class, $config)
                    ->setConfig($configClass);
            }
        );
    }
}
