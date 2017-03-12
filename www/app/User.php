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
    public static function createBySocialProvider($providerUser)
    {
        return self::create([
            'email' => $providerUser->getEmail(),
            'username' => $providerUser->getNickname(),
            'avatar' => $providerUser->getAvatar(),
            'password' => Hash::make('secret'),
            'name' => $providerUser->getName(),
        ]);
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

}
