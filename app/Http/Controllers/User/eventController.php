<?php

namespace App\Http\Controllers\User;

use App\event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class eventController extends Controller
{
    public function show($id){

        $event = event::findOrFail($id);
        return view('users.event.show',['event'=>$event]);
    }
    public function confirm($id){

        $event = event::findOrFail($id);
        return view('users.event.confirm',['event'=>$event]);
    }
    public function registration($id,Request $request){

        $event = event::findOrFail($id);
        $api = new \App\Http\Controllers\Api\event\eventController();
        $request->merge(['event_id'=>$id]);
        $request = addUserId($request);
        $response = $api->register($request);
        if($response['status']=='success'){
            return redirect()->route('home')->withStatus('با موفقیت در رویداد ثبت نام کردید.');
        }else{
            return redirect()->back()->withError($response['msg']);
        }
    }
}
