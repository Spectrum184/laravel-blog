<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Create relationship to user model.
     *
     * @var void
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
