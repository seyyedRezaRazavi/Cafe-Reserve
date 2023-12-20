<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reserve extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function timePlace(){
        return $this->belongsTo(timePlace::class,'time_place_id');
    }
    public function game(){
        return $this->belongsTo(game::class,'game_id');
    }

    public function translateState(){
        switch ($this->state){
            case 0:
                return 'reserved';
            case 1:
                return 'done';
            case -1:
                return 'cancel';
        }
    }
}
