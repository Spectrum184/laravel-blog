<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    /**
     * Create relationship to comment.
     *
     * @var void
     */
    public function comment()
    {
        return $this->belongsTo('App\Comment');
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
