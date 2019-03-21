<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempUser extends Model
{
    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }
}
