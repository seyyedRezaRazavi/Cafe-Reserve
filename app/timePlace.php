<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class timePlace extends Model
{
    public function reserves(){
        return $this->belongsToMany(User::class,'reserves','time_place_id','user_id')->withPivot(['state','number','created_at']);
    }

    public function location(){
        return $this->belongsTo(location::class,'location_id');
    }

    public function fullData(){
        return[
            'id'=>$this->id,
            'location'=>$this->location->name,
            'location_id'=>$this->location->id,
            'date'=>verta($this->date)->format('Y/n/j'),
            'time'=>date ('H:i',strtotime($this->time)),
            'zarfiat'=>$this->zarfiat,
            'availableTable'=>$this->availableTable(),
            'reservedTable'=>$this->reservedTable()
        ];
    }

    public function availableTable(){
        $reservedTable = $this->reservedTable();
        $available_table = $this->zarfiat - $reservedTable;
        return $available_table;

    }

    public function reservedTable(){
        $reserves =reserve::where('time_place_id',$this->id)->where('state',0)->get();
        $reservedTable=0;
        foreach ($reserves as $reserve){
            $reservedTable +=(int) ceil(($reserve->number)/6);
        }
        return$reservedTable;
    }

}
