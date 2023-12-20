<?php

namespace App\Http\Controllers\Api\event;

use App\event;
use App\eventLabel;
use App\eventRegister;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class eventController extends Controller
{
    public function index(){
        $events = event::where('date' ,">=",Carbon::now())->orderBy('date')->get();
        //$events = event::orderBy('date','asc')->get();
        $result=[];
        foreach ($events as $event){
            $result[]=$event->fullData();
        }

        return ReturnSuccess($result);
    }

    public function event_label_index(){
        $labels = eventLabel::orderBy('updated_at','desc')->get();
        $result=[];
        foreach ($labels as $label){
            $result[]=$label->miniData();
        }
        return ReturnSuccess($result);
    }

    public function event_label($event_label_id){
        $event_label = eventLabel::find($event_label_id);
        if($event_label){

            return ReturnSuccess($event_label->fullData());
        }
    }

    public function register(Request $request){
        $decryptedId = $request->get('decryptedUserId');
        $event_id=$request->event_id;
        $event = event::find($event_id);


        if($event){
            if($request->tedad > $event->fullData()['remaining']){
                return ReturnError('نامعتبر است.');
            }

            $event_register = new eventRegister();
            $event_register->user_id = $decryptedId;
            $event_register->event_id = $event_id;
            $event_register->tedad = $request->tedad;
            $event_register->save();
            return [
              'status'=>'success',
              'register_id'=>$event_register->id
            ];
        }else{
            return ReturnError('نامعتبر است.');
        }
    }

    public function user_registrations($user_id){
        $user = User::find($user_id);
        if($user){
            $result=[];
            $events = $user->eventRegistrations;
            foreach ($events as $event){
                $result[]=$event->fullData();
            }

            return ReturnSuccess($result);
        }
    }
}
