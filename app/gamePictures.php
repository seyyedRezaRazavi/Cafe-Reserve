<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gamePictures extends Model
{
    public function game(){
        return $this->belongsTo(game::class,'game_id');
    }
}
