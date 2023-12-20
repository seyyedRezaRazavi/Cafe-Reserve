<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{


    protected $table = 'foods';


    public function getPictureUrlAttribute($key)
    {
        if($this->pic){
            return url('/')."/img/foods/".$this->pic;
        }else{
            return null;
        }
    }

    public function fullData(){
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'price'=>number_format($this->price) ,
            'pic'=>$this->pictureUrl,
        ];
    }


}
