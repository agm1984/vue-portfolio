<?php

namespace App;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable //, MustVerifyEmail
{
    use HasRoles, Notifiable;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'photo_url',
        'roles_list',
    ];

    /**
     * Spatie Roles & Permissions will use this guard, as originally defined in `./config/auth.php`.
     *
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * Create a new user.
     *
     * If the `id` prop is passed in the `$attributes` array, a user can be
     * created with a specific ID.
     *
     * @param string $name
     * @param string $email
     * @param string|null $password
     * @param array $attributes
     *
     * @return self
     */
    public static function generate(
        string $name,
        string $email,
        ?string $password,
        ?array $attributes = []
    ) : self
    {
        if (isset($attributes['id']) && $attributes['id']) {
            $user = self::query()->firstOrNew([ 'id' => $attributes['id'] ]);
            $user->email = $email;
        } else {
            $user = self::query()->firstOrNew([ 'email' => $email ]);
        }

        $user->fill([
            'status' => self::STATUS_ACTIVE,
            'name' => $name,
            'password' => bcrypt($password),
        ]);

        foreach ($attributes as $key => $attribute) {
            $user->{$key} = $attribute;
        }

        $user->save();

        return $user;
    }

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'.jpg?s=200&d=mm';
    }

    /**
     * Get a simple enum list of the user's roles.
     *
     * @return array
     */
    public function getRolesListAttribute()
    {
        return $this->roles->pluck('name')->toArray();
    }

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

}
