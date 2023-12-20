<?php

namespace App\Http\Controllers\Api\reserve;

use App\Food;
use App\game;
use App\location;
use App\reserve;
use App\timePlace;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class reservationController extends Controller
{


    public function reservation(Request $request){

        $decryptedId = $request->get('decryptedUserId');
        $time = $request->hour.":".$request->minute;
        $date = Verta::parse($request->date)->formatGregorian('Y-m-d');

        if(!Carbon::parse($date." ".$time)->gt(Carbon::now())){
            return ReturnError('زمان مشخص شده معتبر نیست');
        }

        $time_place = timePlace::where('date',$date)->where('time',$time)->where('location_id',$request->location)->first();

        if($time_place){
            foreach ($time_place->reserves as $reserve){
                if($reserve->id == $decryptedId && $reserve->pivot->state != -1){
                    return ReturnError("شما قبلا این ساعت را رزرو کرده اید.\n لطفا جهت مشاهده و یا تغییرات به قسمت تاریخچه رزروهای خود مراجعه کنید");
                }
            }
            $available_table = $time_place->availableTable();
            $new_reservation_table =(int) ceil($request->number/6);
            if(($available_table-$new_reservation_table)>=0){
                if($request->reserve == true){
                    $new_reserve = new reserve();
                    $new_reserve->user_id = $decryptedId;
                    $new_reserve->time_place_id = $time_place->id;
                    $new_reserve->number = $request->number;
                    $new_reserve->save();

                    $games = game::all();
                    $gamesData=[];
                    foreach ($games as $game){
                        $gamesData[]= $game->miniData();
                    }

                    $foods = Food::all();
                    $foodsData=[];
                    foreach ($foods as $food){
                        $foodsData[]=$food->fullData();
                    }
                    $data=['games'=>$gamesData,'foods'=>$foodsData];

                    return ReturnSuccess(['action'=>'reserved','reserve_id'=>$new_reserve->id,'data'=>$data]);
                }else{
                    return ReturnSuccess(['action'=>'available']);
                }
            }else{
                $nearest_available=$this->getNearestsAvailableTimePlace($time_place->date,$time_place->time,$request->number,true);
                $nearest=[];

                if(empty($nearest_available['upper']) &&empty($nearest_available['downer']) ){
                    return ReturnError("تمامی میزهای امروز {$time_place->location->name} رزرو میباشد. لطفا طبقه و یا روز دیگری را انتخاب قرمایید.");
                }else{
                    return ReturnSuccess(['action'=>'unavailable','nearest'=>$nearest_available,'msg'=>'تمامی میزهای این طبقه در این ساعت رزرو است.']);
                }
                //return ReturnError('تمامی میزها رزرو میباشد. لطفا ساعت دیگری را انتخاب قرمایید.');
            }
        }else{
            $nearest_available=$this->getNearestsAvailableTimePlace($date,$time,$request->number,true);
            $nearest=[];

            if(empty($nearest_available['upper']) &&empty($nearest_available['downer']) ){
                return ReturnError('در ساعت مورد نظر شما خدمات ارائه نمیشود');
            }else{
                return ReturnSuccess(['action'=>'unavailable','nearest'=>$nearest_available,'msg'=>'در این ساعت مورد نظر شما خدمات ارائه نمیشود']);
            }

        }

    }

    public function extraServices(Request $request){
        $decryptedId = $request->get('decryptedUserId');
        $reserve = reserve::findOrFail($request->reserved_id);
        if($reserve){
            if(!empty($request->game)){
                $reserve->game_id = $request->game;
            }

            $food_text='';
            if($request->foods){
                foreach ($request->foods as $food_id=> $tedad){
                    if($tedad > 0){
                        $food = Food::find($food_id);
                        $food_text .= "- ".$food->name ." - تعداد: " .$tedad."\n";
                    }
                }
            }
            
            $reserve->food = $food_text;

            $reserve->save();
            return ReturnSuccess();
        }else{
            return ReturnError();
        }
    }

    public function getAllLocations(){
        $locations = location::all();
        $result =[];
        foreach ($locations as $location){
            $result []= [
                'location_id'=>$location->id,
                'name'=>$location->name
            ];
        }
        return ReturnSuccess($result);
    }

    public function update(Request $request){
        $decryptedId = $request->get('decryptedUserId');
        $reserve = reserve::findOrFail($request->reserved_id);

        if($request->number != $reserve->number){
            $now_tables = (int) ceil($reserve->number/6);
            $new_tables = (int) ceil($request->number/6);
            if($now_tables == $new_tables){
                $reserve->number = $request->number;
            }else{
                $available_table = $reserve->timePlace->availableTable();
                if(($available_table + $now_tables - $new_tables) >=0){
                    $reserve->number = $request->number;
                }else{
                    return ReturnError('ظرفیت تکمیل است، امکان افزایش تعداد رزرو نیست');
                }
            }

        }

        /*if(!empty($request->game)){
            $reserve->game_id = $request->game;
        }

        $food_text=$reserve->food;
        foreach ($request->foods as $food_id=> $tedad){
            if($tedad > 0){
                $food = Food::findOrFail($food_id);
                $food_text .= "- ".$food->name ." - تعداد: " .$tedad."\n";
            }
        }
        $reserve->food = $food_text;*/



        $reserve->save();
        return ReturnSuccess();
    }

    public function cancel(Request $request){
        $decryptedId = $request->get('decryptedUserId');
        $reserve = reserve::findOrFail($request->reserved_id);
        $reserve->state = -1;
        $reserve->save();
        return ReturnSuccess();
    }


    /////////////////////
    private function getNearestsAvailableTimePlace($date,$time,$number,$jsonOutput=false){
        /*$available_table = $time_place->availableTable();
        $new_reservation_table =(int) ceil($number/6);
        if(($available_table-$new_reservation_table)>=0){
            //available
        }*/

        $result=[
            'upper'=>null,
            'downer'=>null
        ];
        $upperNearestsTimePlace = timePlace::where('date','>=',$date)->where('time','>',$time)->orderBy('time')->get();
        $downNearestsTimePlace = timePlace::where('date','<=',$date)->where('time','<',$time)-> where('time','>' ,date("h:i"))->where('date','>',date("Y/m/d")) ->orderBy('time', 'desc')->get();


        foreach ($upperNearestsTimePlace as $upperTimePlace){
            $available_table = $upperTimePlace->availableTable();
            $new_reservation_table =(int) ceil($number/6);
            if(($available_table-$new_reservation_table)>=0){
                if($jsonOutput){
                    $result['upper'] = $upperTimePlace->fullData();
                }else{
                    $result['upper'] = $upperTimePlace;
                }

                break;
            }
        }
        foreach ($downNearestsTimePlace as $downerTimePlace){
            $available_table = $downerTimePlace->availableTable();
            $new_reservation_table =(int) ceil($number/6);
            if(($available_table-$new_reservation_table)>=0){
                if($jsonOutput){
                    $result['downer'] = $downerTimePlace->fullData();
                }else{
                    $result['downer'] = $downerTimePlace;
                }

                break;
            }
        }

        return $result;

    }

}
