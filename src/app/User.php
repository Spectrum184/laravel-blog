<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'username'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Create relationship to role model.
     *
     * @var void
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * Create relationship to role post.
     *
     * @var void
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
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
     * Create relationship to comment reply.
     *
     * @var void
     */
    public function replies()
    {
        return $this->hasMany('App\CommentReply');
    }

    /**
     * Create relationship many to many.
     *
     * @param $query
     */
    public function likedPosts()
    {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
}
