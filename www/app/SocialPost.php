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
    protected $fillable = ['post_id', 'post_provider_id', 'provider'];

    /**
     * Get the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
