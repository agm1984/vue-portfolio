<?php

namespace App;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use App\Traits\TimestampAttributes;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable //, MustVerifyEmail
{
    use HasRoles, Notifiable, TimestampAttributes;

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
        'status_nice',
        'avatar_url',
        'roles_list',
        'created_at_nice',
        'created_at_diff',
        'updated_at_nice',
        'updated_at_diff',
    ];

    /**
     * Spatie Roles & Permissions will use this guard, as originally defined in `./config/auth.php`.
     *
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    public function getStatusNiceAttribute()
    {
        if ($this->status === 0) return 'Inactive';
        if ($this->status === 1) return 'Active';
        throw \Exception('Problem');
    }

    /**
     * Adds `avatar_url` field to the `user` record to make it easier
     * for the client-side to handle avatar images.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar_filename) {
            return "/users/{$this->id}/{$this->avatar_filename}";
        }
        return '';
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

    public function scopeActive($query)
    {
        return $query->where('status', '=', self::STATUS_ACTIVE);
    }

}
