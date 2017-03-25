<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSocialAccount extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_social_account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'provider_user_id', 'provider', 'access_token', 'access_token_secret'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['id', 'provider', 'provider_user_id'];

    /**
     * Get the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the token of the user provider.
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->access_token;
    }

    /**
     * Get the secret token of the user provider.
     *
     * @return mixed
     */
    public function getSecretToken()
    {
        return $this->access_token_secret;
    }

    /**
     * Get the user provider ID.
     *
     * @return mixed
     */
    public function getProviderID()
    {
        return $this->provider_user_id;
    }

    /**
     * Update access_token in DB.
     *
     * @param $token
     */
    public function updateToken($token)
    {
        $this->access_token = $token;
    }
}
