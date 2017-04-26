<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'socials_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'social_post_id', 'provider_id', 'provider', 'status'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the provider name.
     *
     * @return mixed
     */
    public function getProviderName()
    {
        return $this->provider;
    }

    /**
     * Set the status of the SocialPost.
     *
     * @param $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * Set the social post ID of the post.
     *
     * @param $social_post_id
     */
    public function setSocialPostID($social_post_id) {
        $this->social_post_id = $social_post_id;
    }
}
