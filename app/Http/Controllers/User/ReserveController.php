<?php

namespace App\Http\Controllers\User;

use App\Food;
use App\Http\Controllers\Api\reserve\reservationController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\location;
use App\reserve;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class ReserveController extends Controller
{

    public function __construct()
    {
        $this->middleware('user_login');
    }

    public function index(){

        $locations = location::pluck('name','id');
        $foods = Food::all();

        return view('users.reserve.index',['locations'=>$locations,'foods'=>$foods]);
    }

    public function reserve(ReservationRequest $request){
        //dd($request->all());
        $api = new reservationController();

        $request = addUserId($request);
        $date = $request->date;
        $pdate =verta($request->date)->format('Y/m/d');
        $request->merge(['date'=>$pdate]);
        $response = $api->reservation($request);

        if($response['status']=='success'){
            if($response['data']['action']=='reserved'){

                $reserve_id = $response['data']['reserve_id'];
                $request->merge(['reserved_id'=>(int)$reserve_id]);
                $request->merge(['foods'=>json_decode($request->foods)]);
                $resp = $api->extraServices($request);

                return redirect()->route('home')->withStatus('با موفقیت رزرو شد');
            }
            $request->merge(['date'=>$date]);
            return redirect()->route('user.reserve.confirm')->with('response',$response)->withInput($request->all());
        }else{
            if($response['status']=='error'){
              $msg =   $response['msg'];
            }else{
              $msg =   'خطایی وجود دارد.';
            }
            $request->merge(['date'=>$date]);
            return redirect()->route('user.reserve.index')->withError($msg)->withInput($request->all());
        }


    }

    public function confirm(Request $request){

        if(session('response') == null){
            return redirect()->route('user.reserve.index');
        }

        //dd($request->old());
        return view('users.reserve.confirm');
    }

    public function edit($id){
        $reserve = reserve::findOrFail($id);
        $foods = Food::all();
        return view('users.reserve.edit',['reserve'=>$reserve,'foods'=>$foods]);
    }

    public function update($id,Request $request){
        $request = addUserId($request);
        $request->merge(['reserved_id'=>(int)$id]);

        $api= $api = new reservationController();
        $response = $api->update($request);

        if($response['status'] == 'success'){
            return redirect()->route('user.profile.reserve_history')->withStatus('با موفقیت بروزرسانی شد');
        }else{
            if($response['status'] == 'error'){
                return redirect()->back()->withError($response['msg']);
            }else{
                return redirect()->back()->withError("خطایی وجود دارد");
            }
        }
    }

    public function cancel($id){
        $request = addUserId();
        $request->merge(['reserved_id'=>(int)$id]);

        $api= $api = new reservationController();
        $response = $api->cancel($request);

        if($response['status'] == 'success'){
            return redirect()->route('user.profile.reserve_history')->withStatus('با موفقیت حذف شد');
        }else{
            if($response['status'] == 'error'){
                return redirect()->back()->withError($response['msg']);
            }else{
                return redirect()->back()->withError("خطایی وجود دارد");
            }
        }
    }
}
