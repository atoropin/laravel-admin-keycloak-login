<?php


namespace Rusatom\LaravelAdminKeycloak\Admin\Controllers;


use Rusatom\LaravelAdminKeycloak\Services\AdminSocialAccountService;
use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Http\Request;

class AuthController extends BaseAuthController
{
    private Socialite $socialite;

    public function __construct(Socialite $socialite)
    {
        $this->socialite = $socialite;
    }

    /**
     * Show the login page.
     */
    public function getLoginForm()
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }

        return view($this->loginView);
    }

    /**
     * Go to Keycloak login page.
     */
    public function getLogin()
    {
        if ($this->guard()->check()) {
            return redirect($this->redirectPath());
        }

        if (config('laravel_admin_keycloak.client_id') !== null) {
            return $this->socialite->driver('laravel_admin_keycloak')->redirect();
        }

        return view($this->loginView);
    }

    /**
     * Keycloak callback handler.
     */
    public function callback(Request $request, $provider)
    {
        $socialiteUser = $this->socialite->driver($provider)->stateless()->user();

        $adminUser = AdminSocialAccountService::getUser($socialiteUser, $provider);

        if (!$adminUser) {
            return redirect('/admin/login/form');
        }

        if ($this->guard()->loginUsingId($adminUser->getAuthIdentifier(), true)) {
            $request->session()->regenerate();

            return redirect()->intended($this->redirectPath());
        }
    }

    /**
     * User logout.
     */
    public function getLogout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
