<?php


namespace Rusatom\LaravelAdminKeycloak\Services;


use Encore\Admin\Auth\Database\Administrator;
use Rusatom\LaravelAdminKeycloak\Admin\Models\AdminUserSocialAccount;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\User;

class AdminSocialAccountService extends ServiceProvider
{
    public static function getUser(User $providerUser, string $providerName): ?Administrator
    {
        $account = AdminUserSocialAccount::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        $userData = json_encode($providerUser->user, JSON_UNESCAPED_UNICODE);

        $adminUser = Administrator::whereEmail($providerUser->getEmail())->first();

        if (!$account && $adminUser) {
            $account = new AdminUserSocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider'         => $providerName,
            ]);

            $account->adminUser()->associate($adminUser);
        }
        elseif (!$adminUser) {
            return null;
        }

        $account->provider_user_data = $userData;
        $account->access_token = $providerUser->token;

        $account->save();

        return $account->adminUser()->first();
    }
}
