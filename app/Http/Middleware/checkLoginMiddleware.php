<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;

class checkLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->has(['pid','api_token'])){
            return response([
                'status'=>'error',
                'msg'=> "پارامترها معتبر نیست"
            ],200);

        }

        $id = $request->pid;
        $api_token = $request ->api_token;

        try {
            $decryptedId = decrypt($id);
        } catch (DecryptException $e) {
            return response([
                'status'=>'error',
                'code'=>69,
                'msg'=> "کلید معتبر نیست"
            ],200);
        }

        if(!$this->Check_id_apiToken($decryptedId,$api_token)){
            return response([
                'status'=>'error',
                'code'=>69,
                'msg'=> "کلید معتبر نیست"
            ],200);
        }
        $request->attributes->add(['decryptedUserId' => $decryptedId]);
        return $next($request);
    }

    private function Check_id_apiToken($user_id,$api_token){


        $user = User::find($user_id);

        if(!$user || !Hash::check($api_token,$user->api_token)){
            return false;
        }else{
            return true;
        }
    }
}
