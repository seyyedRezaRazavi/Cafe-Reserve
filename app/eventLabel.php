<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eventLabel extends Model
{

    protected $fillable = [
        'name', 'subtitle','desc','picture'
    ];

    protected $appends=[
        'cover_picture_url'
    ];


    public function events()
    {
        return $this->hasMany(event::class,'event_label_id')->orderBy('date','asc');
    }


    public function fullData(){
        $events = [];
        foreach ($this->events as $event){
            $events[]=$event->fullData();
        }

        return[
            'id'=>$this->id,
            'name'=>$this->name,
            'subtitle'=>$this->subtitle,
            'cover_picture'=>$this->picture,
            'desc'=>$this->desc,
            'events'=>$events

        ];
    }

    public function miniData(){
        return[
            'id'=>$this->id,
            'name'=>$this->name,
            'subtitle'=>$this->subtitle,
            'cover_picture'=>$this->picture,
        ];
    }

    public function getCoverPictureUrlAttribute()
    {
        if($this->picture){
            return url('/')."/img/events/".$this->picture;
        }else{
            return null;
        }

    }
}
