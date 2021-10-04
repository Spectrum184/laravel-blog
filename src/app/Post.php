<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Create relationship to role post.
     *
     * @var void
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Create relationship to role category.
     *
     * @var void
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Create relationship to role tag.
     *
     * @var void
     */
    public function tags()
    {
        return $this->hasMany('App\Tag', 'post_id', 'id');
    }

    /**
     * Create relationship to comment.
     *
     * @var void
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Define scope published
     *
     * @param $query
     */
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Create relationship many to many.
     *
     * @param $query
     */
    public function likedUsers()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
