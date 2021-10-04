<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Create relationship to role post.
     *
     * @var void
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
