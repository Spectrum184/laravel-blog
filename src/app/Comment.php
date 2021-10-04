<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Create relationship to post.
     *
     * @var void
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * Create relationship to comment reply.
     *
     * @var void
     */
    public function replies()
    {
        return $this->hasMany('App\CommentReply');
    }

    /**
     * Create relationship to user.
     *
     * @var void
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
