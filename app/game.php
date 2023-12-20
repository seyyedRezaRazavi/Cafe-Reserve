<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class game extends Model
{

    protected $fillable = [
        'name', 'cost', 'tedad_safhe','desc','cover_picture'
    ];

    protected $appends=[
      'cover_picture_url'
    ];

    public function gamePlays(){
        return $this->belongsToMany(User::class,'game_plays','game_id','user_id')->withPivot(['date','state']);
    }

    public function Pictures()
    {
        return $this->hasMany(gamePictures::class,'game_id');
    }

    public function miniData(){
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'cost'=>number_format($this->cost),
            'picture'=>$this->cover_picture,
        ];
    }

    public function fullData(){
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'cost'=>number_format($this->cost),
            'picture'=>$this->cover_picture,
            'desc'=>$this->desc,
            'tedad_safhe'=>$this->tedad_safhe,
        ];
    }

    public function getCoverPictureUrlAttribute()
    {
        if($this->cover_picture){
            return url('/')."/img/games/".$this->cover_picture;
        }else{
            return null;
        }

    }
}
