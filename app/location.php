<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    public function timePlaces()
    {
        return $this->hasMany(timePlace::class);
    }



}
