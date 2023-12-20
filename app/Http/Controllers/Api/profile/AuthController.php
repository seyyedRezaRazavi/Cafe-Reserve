<?php

namespace App\Http\Controllers\Api\profile;

use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function send_confirm_sms($number){

        if(!empty($number)){
            if(!preg_match("/^09[0-9]{9}$/", $number)) {
                return ReturnError("شماره وارد شده معتبر نیست");
            }
            $user = User::where('tell',$number)->first();

            $sms_token = rand(1023,9896);
            if($user){
                //$this->sendSms($number,$sms_token);
                $user->email = $sms_token;
                $user->sms_token = Hash::make($sms_token) ;
                $user->last_sms = Carbon::now();
                //$user->api_token=null;
                $user->save();
            }else{
                $newUser =new User();
                $newUser->email=$sms_token;
                $newUser->tell=$number;
                $newUser->sms_token =Hash::make($sms_token) ;
                $newUser->last_sms = Carbon::now();
                $newUser->api_token=null;
                $newUser->save();
            }

            //Send_sms();
            return ReturnSuccess();
        }else{
            return ReturnError('شماره وارد نشده است');
        }

    }

    public function confirm_pin($number,Request $request){
        if(!$request->has(['pin']) && !empty($number)){
            return ReturnError("پارامترها معتبر نیست");
        }

        $pin = $request->pin;
        $user = User::where('tell',$number)->first();

        if(!$user || !Hash::check($pin,@$user->sms_token)){
            if($user){
                $user->incorrect_check = $user->incorrect_check+1;
                $user->save();
                if($user->incorrect_check >3){
                    $user->sms_token=null;
                    $user->incorrect_check=0;
                    $user->save();
                    return ReturnError("کد اشتباه است. \n کد منقضی شد. دوباره درخواست دهید");

                }
            }
            return ReturnError('کد نادرست است');

        }else{
            $api_token =Str::random(rand(5,20));
            $user->api_token = Hash::make($api_token);
            $user->sms_token = null;
            $user->incorrect_check=0;
            $user->last_login = Carbon::now();
            $user->save();
            $data=[
                'id'=>encrypt($user->id),
                'api_token' =>$api_token
            ];
            return ReturnSuccess($data);
        }
    }

    public function check_user_id_api_token(Request $request){


        if($request->has(['pid','api_token'])){

            try {
                $decryptedUserId = decrypt($request->pid);
            } catch (DecryptException $e) {
                //return ReturnError(" کلید معتبر نیست.",69);
                return [
                    'status'=>'success',
                    'data'=>false,
                ];
            }

            $user = User::find($decryptedUserId);
            if(!$user || !Hash::check($request->api_token,$user->api_token)){
                return [
                    'status'=>'success',
                    'data'=>false,
                ];
            }else{
                return [
                    'status'=>'success',
                    'data'=>true,
                ];
            }
        }else{
            return [
                'status'=>'success',
                'data'=>false,
            ];
        }

    }

    public function logout(Request $request){
        $decryptedId = $request->get('decryptedUserId');
        $user = User::find($decryptedId);
        if($user){
            $user->api_token = null;
            $user->save();
            return ReturnSuccess();
        }

        return ReturnError();
    }
}
