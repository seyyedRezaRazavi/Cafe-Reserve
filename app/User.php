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
        'name', 'email', 'password','user_name','pic'
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


    public function Pictures()
    {
        return $this->hasMany(userPictures::class,'user_id');
    }

    public function eventRegistrations(){
        return $this->belongsToMany(event::class,'event_registers','user_id','event_id')->withPivot(['id','created_at','tedad']);
    }

    public function gamePlays(){
        return $this->belongsToMany(game::class,'game_plays','user_id','game_id')->withPivot(['date','state']);
    }

    public function reserves(){
        return $this->belongsToMany(timePlace::class,'reserves','user_id','time_place_id')->withPivot(['state','number','id','food','game_id','created_at']);
    }

    public function getPictureUrlAttribute()
    {
        if($this->pic){
            return url('/')."/img/users/profile/".$this->pic;
        }else{
            return null;
        }

    }
}
