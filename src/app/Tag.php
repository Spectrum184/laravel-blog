<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * delete attributes timestamps .
     *
     *
     */
    public $timestamps = false;

    /**
     * Create relationship to role post.
     *
     * @var void
     */
    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id', 'id');
    }
}
