<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Api\profile\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('users.login');
    }

    public function send_confirm_sms(Request $request){
        $api =new AuthController();
        $resonse = $api->send_confirm_sms($request->tell);

        if($resonse['status']=='success'){
            return redirect()->route('user.login.confirm',$request->tell);
        }else{
            if($resonse['status']=='error'){
                return redirect()->route('user.login')->withError($resonse['msg']);
            }else{
                return redirect()->route('user.login')->withError("خطایی وجود دارد.");
            }
        }
    }

    public function confirm($number)
    {
        return view('users.confirm_sms',['number'=>$number]);
    }

    public function confirm_pin(Request $request)
    {
        $api =new AuthController();
        $response = $api->confirm_pin($request->number,$request);


        if($response['status']=='success'){
            Session::put('user_id',decrypt($response['data']['id']));
            Cookie::queue('uid',$response['data']['id']);
            Cookie::queue('api_token',$response['data']['api_token']);

            $user = User::find(decrypt($response['data']['id']));
            if($user->user_name == null && empty($user->name)){
                return redirect()->route('user.first');
            }
            return redirect()->route('home');
        }else{
            if($response['status']=='error'){
                return redirect()->route('user.login.confirm',$request->number)->withError($response['msg']);
            }else{
                return redirect()->route('user.login.confirm',$request->number)->withError("خطایی وجود دارد.");
            }
        }

    }

    public function logout(){
        //$api =new AuthController();
        //$api->logout(addUserId());
        Session::forget('user_id');
        Cookie::unqueue('uid');
        Cookie::unqueue('api_token');
        return redirect()->route('home');
    }

    public function first(){
        return view('users.first');
    }
    public function first_update(Request $request){

        $request->merge(['user_name'=>$request->name]);
        $co = new HomeController();
        return $co->update($request);
    }
}
