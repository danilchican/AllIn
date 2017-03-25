<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'body', 'planned', 'status', 'date'];

    /**
     * Getting socials for a post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function socials()
    {
        return $this->hasMany(SocialPost::class);
    }

    /**
     * Set the body of the new post.
     *
     * @param $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get the body of the Post.
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the planned type post.
     *
     * @param $is_plan
     */
    public function setPlanned($is_plan)
    {
        $this->planned = $is_plan;
    }

    /**
     * Set the status of the post.
     *
     * @param $status
     */
    public function setStatus($status = 0)
    {
        $this->status = $status;
    }

    /**
     * Set the status of the post.
     *
     * @param $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}
