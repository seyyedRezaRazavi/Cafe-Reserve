<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    protected  $fillable=['name','subtitle','date','zarfiat','zarfiat_unit','desc','vorodi_cost','picture','event_label_id'];

    protected $touches = ['eventLabel'];

    public function eventLabel(){
        return $this->belongsTo(eventLabel::class,'event_label_id');
    }

    public function eventRegistrations(){
        return $this->belongsToMany(User::class,'event_registers','event_id','user_id')->withPivot(['id','created_at','tedad']);
    }



    public function fullData(){

        $remaining = $this->zarfiat;
        foreach ($this->eventRegistrations as $eventRegistration){
            $remaining -=$eventRegistration->pivot->tedad;
        }
        $state = (Carbon::create($this->date)->isPast()) ? 'Expire' : 'Available';

        return[
            'id'=>$this->id,
            'title'=>$this->name,
            'subtitle'=>$this->subtitle,
            'desc'=>$this->desc,
            'state'=>$state,
            'date'=>verta($this->date)->format('Y/m/d'),
            'alt_date'=>verta($this->date)->format('m/d'),
            'day'=>verta($this->date)->format('l'),
            'time'=>verta($this->date)->format('H:i'),
            'vorodi_cost'=>$this->vorodi_cost,
            'zarfiat'=>$this->zarfiat,
            'zarfiat_unit'=>$this->zarfiat_unit,
            'picture'=>($this->picture) ? $this->picture : $this->eventLabel->coverPictureUrl,
            'remaining'=>$remaining,
            'event_label'=>[
                'id'=>$this->event_label_id,
                'cover_picture'=>$this->eventLabel->picture,
            ]

        ];
    }

}
