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
        'name', 'email', 'password',
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
     * @param $providerUser
     * @return mixed
     */
    public static function createBySocialProvider($providerUser)
    {

        return self::create([
            'email' => $providerUser->getEmail(),
            'username' => $providerUser->getNickname(),
            'password' => Hash::make(str_random(8)),
            'name' => $providerUser->getName(),
        ]);
    }
}
