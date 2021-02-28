<?php

namespace App\MyProject\Common\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use HasApiTokens, Notifiable;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * @var array
     */
    protected ?array $transformable = [
        'name', 'email'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @return HasMany
     */
    public function settings(): HasMany
    {
        return $this->hasMany(UserSetting::class);
    }

    /**
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * @param string $package
     * @param string $action
     * @return bool
     */
    public function hasPermission(string $package, string $action): bool
    {
        $check_permission = function (Builder $query) use ($action) {
            return $query->where('action', $action)->orWhere('action', 'admin');
        };

        return $this->permissions()->where('package', $package)->where($check_permission)->exists();
    }

    /**
     * @param string $package
     * @param string $action
     * @return $this
     */
    public function grantPermission(string $package, string $action): self
    {
        if (!$this->hasPermission($package, $action)) {
            $this->permissions()->create([
                'package' => $package,
                'action' => $action
            ]);
        }

        return $this;
    }

    /**
     * @param string $package
     * @param string $action
     * @return $this
     */
    public function revokePermission(string $package, string $action): self
    {
        $this->permissions()->where('package', $package)->where('action', $action)->delete();

        return $this;
    }

    /**
     * @param array $permissions Format: [ 'package' => [ 'action', ... ] ]
     * @return $this
     */
    public function syncPermissions(array $permissions): self
    {
        $this->permissions()->delete();
        foreach ($permissions as $package => $actions) {
            foreach ($actions as $action) {
                $this->grantPermission($package, $action);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return 'mdi-user';
    }
}
