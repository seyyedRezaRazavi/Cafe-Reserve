<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserAuthMiddleware
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
        if(Session::has('user_id')){
            return $next($request);
        }else{

            if(Cookie::has('uid') && Cookie::has('api_token')){
                try {
                    $decryptedUserId = decrypt(Cookie::get('uid'));
                } catch (DecryptException $e) {
                    return redirect()->route('user.login')->withError('لطفا وارد شوید.');
                }

                $user = User::find($decryptedUserId);
                //if(!$user || !Hash::check(Cookie::get('api_token'),$user->api_token)){
                if(!$user ){
                    return redirect()->route('user.login')->withError('لطفا وارد شوید.');
                }else{
                    Session::put('user_id',$decryptedUserId);
                    return $next($request);
                }

            }else{
                return redirect()->route('user.login')->withError('لطفا وارد شوید.');
            }


        }

    }
}
