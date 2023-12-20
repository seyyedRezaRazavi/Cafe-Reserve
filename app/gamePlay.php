<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gamePlay extends Model
{
    protected $fillable=['date','game_id','user_id','state'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function game(){
        return $this->belongsTo(game::class,'game_id');
    }

    public function getPdateAttribute()
    {
        return verta($this->date)->format('Y/n/j');
    }


    public function stateTranslate(){
        switch ($this->state){
            case 0:
                return 'نامشخص';
            break;

            case 1:
                return 'برنده';
                break;
            case 2:
                return 'رتبه دوم';
                break;

            case 3:
                return 'رتبه سوم';
                break;
        }
    }
}
