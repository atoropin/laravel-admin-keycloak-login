<?php


namespace Rusatom\LaravelAdminKeycloak;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Keycloak\Provider as KeycloakProvider;
use SocialiteProviders\Manager\Config as SocialiteConfig;

class LaravelAdminKeycloakServiceProvider extends ServiceProvider
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
        $this->publishes([__DIR__.'/../config' => config_path()]);

        $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')]);

        $this->bootLaravelAdminKeycloakSocialite();

        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::namespace('Rusatom\LaravelAdminKeycloak\Admin\Controllers')
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/routes.php');
            });
    }

    /**
     * Extend Socialite config for Laravel-admin login.
     */
    private function bootLaravelAdminKeycloakSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'la_keycloak',
            function ($app) use ($socialite) {
                $config = $app['config']['laravel_admin_keycloak'];
                $configClass = new SocialiteConfig(
                    $app['config']['laravel_admin_keycloak.client_id'],
                    $app['config']['laravel_admin_keycloak.client_secret'],
                    $app['config']['laravel_admin_keycloak.redirect'],
                    $app['config']['laravel_admin_keycloak']
                );
                return $socialite->buildProvider(KeycloakProvider::class, $config)
                    ->setConfig($configClass);
            }
        );
    }
}
