<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
