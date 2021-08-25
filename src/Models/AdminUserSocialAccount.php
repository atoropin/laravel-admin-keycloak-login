<?php


namespace Rusatom\LaravelAdminKeycloak\Models;


use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * LaravelAdminKeycloak\Models\AdminUserSocialAccount
 *
 * @property int $id
 * @property int $admin_user_id
 * @property string $provider_user_id
 * @property string $provider
 * @property array $provider_user_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|AdminUserSocialAccount newModelQuery()
 * @method static Builder|AdminUserSocialAccount newQuery()
 * @method static Builder|AdminUserSocialAccount query()
 * @method static Builder|AdminUserSocialAccount whereId($value)
 * @method static Builder|AdminUserSocialAccount whereProvider($value)
 * @method static Builder|AdminUserSocialAccount whereProviderUserData($value)
 * @method static Builder|AdminUserSocialAccount whereProviderUserId($value)
 * @method static Builder|AdminUserSocialAccount whereCreatedAt($value)
 * @method static Builder|AdminUserSocialAccount whereUpdatedAt($value)
 * @method static Builder|AdminUserSocialAccount whereAdminUserId($value)
 * @mixin Eloquent
 */
class AdminUserSocialAccount extends Model
{
    protected $table = 'admin_user_social_accounts';

    protected $fillable = [
        'admin_user_id',
        'provider_user_id',
        'provider',
        'provider_user_data'
    ];

    protected $casts = [
        'provider_user_data' => 'json'
    ];

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }
}
