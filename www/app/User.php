<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['name', 'email', 'avatar'];

    /**
     * @param $providerUser
     * @return mixed
     */
    public static function createBySocialProvider($providerUser, $avatar)
    {
        return self::create([
            'email' => $providerUser->getEmail(),
            'username' => $providerUser->getNickname(),
            'avatar' => $avatar,
            'password' => bcrypt('secret'),
            'name' => $providerUser->getName(),
        ]);
    }

    /**
     * Set new password for the user.
     *
     * @param $password
     */
    public function setPassword($password) {
        $this->password = bcrypt($password);
    }

    /**
     * Get the social account of user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socials()
    {
        return $this->hasMany(UserSocialAccount::class);
    }

    /**
     * Getting posts for a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
