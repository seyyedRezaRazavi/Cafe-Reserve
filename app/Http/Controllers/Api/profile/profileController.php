<?php

namespace App\Http\Controllers\Api\profile;

use App\game;
use App\User;
use App\userPictures;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;


class profileController extends Controller
{
    public function getProfileData(Request $request){
        $decryptedId = $request->get('decryptedUserId');
        $user=User::find($decryptedId);
        if($user){
            $user_data = [
                'name'=>$user->name,
                'profile_picture'=>$user->pictureUrl,
                'user_name'=>$user->user_name,
                'laghab'=>$user->laghab,
                'user_type'=>'basic'
            ];

            return [
                'status'=>'success',
                'data'=>$user_data
            ];
        }else{
            return [
                'status'=>'error',
                'msg'=>'خطا در ورود اطلاعات'
            ];
        }

    }

    public function UpdateProfile(Request $request){
        $decryptedId = $request->get('decryptedUserId');

        $user=User::find($decryptedId);
        if($user && $request->has(['name','userName'])){
            $user->name = $request->name;
            $user->user_name = $request->userName;
            $user->save();
            return ['status'=>'success'];
        }else{
            return [
                'status'=>'error',
                'msg'=>'خطا در ورود اطلاعات'
            ];
        }

    }

    public function getProfilePictures(Request $request){
        $decryptedId = $request->get('decryptedUserId');
        $user=User::find($decryptedId);
        if($user){
            $result =[];
            $user_pictures = $user->Pictures;
            foreach ($user_pictures as $picture){
                $result[] = [
                  'id'=>$picture->id,
                  'thumb'=>url('/')."/img/users/thumb/thumb-".$picture->name,
                  'original'=>route('getOriginalUserPicture', ['pictureid' => $picture->id]),
                ];
            }
            return ReturnSuccess($result);
        }else{
            return [
                'status'=>'error',
                'msg'=>'خطا در ورود اطلاعات'
            ];
        }


    }

    public function getOriginalPicture($picture_id,Request $request){

        $decryptedId = $request->get('decryptedUserId');
        if(!$decryptedId){
            if(Session::has('user_id')){
                $decryptedId = Session::get('user_id');
            }else{
                return ReturnError("درخواست نامعتبر است");
            }
        }



        $user=User::find($decryptedId);
        if($user){
            $user_picture = userPictures::where('id',$picture_id)->where('user_id',$decryptedId)->first();
            if($user_picture){
                $path = public_path("img\\users\\orginal\\".$user_picture->name);

            if (!File::exists($path)) {

                abort(404);

            }

            /*$file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;*/
                return response()->download($path, "mr.fun.$user_picture->name");
            }else{
                return response(ReturnError());
            }
        }else{
            return response(ReturnError());
        }

    }

    public function user_reservations(Request $request){
        $decryptedId = $request->get('decryptedUserId');
        $user = User::find($decryptedId);
        if($user){
            $result=[
                'open'=>[],
                'close'=>[],
            ];

            $reservations = $user->reserves;
            foreach ($reservations as $reservation){

                $game_data=null;
                if($reservation->pivot->game_id){
                    $game_data = game::find($reservation->pivot->game_id)->miniData();
                }

                $data=[
                    'type'=>'reserve',
                    'data'=>[
                        'reservation_id' =>$reservation->pivot->id,
                        'number'=>$reservation->pivot->number,
                        'state'=>$reservation->pivot->state,
                        'created_at'=>$reservation->pivot->created_at,
                        'time_place_data'=>$reservation->fullData(),
                        'food'=>$reservation->pivot->food,
                        'game_data'=>$game_data
                    ]
                ];
                $reservation_date = new Carbon("{$reservation->date} {$reservation->time}");
                //dd($reservation_date,Carbon::now(),$reservation_date->gt(Carbon::now()));
                if($reservation->pivot->state == 0 && $reservation_date->gt(Carbon::now())){
                    $result['open'][] = $data;
                }else{
                    $result['close'][] = $data;
                }
            }

            $event_registrations = $user->eventRegistrations;
            foreach ($event_registrations as $registration){
                $data = [
                    'type'=>'event',
                    'data'=>[
                        'registration_id' =>$registration->pivot->id,
                        'number'=>$registration->pivot->tedad,
                        'create_at'=>$registration->pivot->create_at,
                        'event_data'=>$registration->fullData(),
                    ]
                ];
                $register_date = new Carbon($registration->date);

                if($register_date->gt(Carbon::now())){
                    $result['open'][] = $data;
                }else{
                    $result['close'][] = $data;
                }

            }

            usort($result['open'], function($a, $b) {
                $t1 = strtotime(($this->getDate($a)));
                $t2 = strtotime(($this->getDate($b)));
                return $t1 - $t2;
                //return $a['order'] <=> $b['order'];
            });



            return ReturnSuccess($result);
        }else{
            return ReturnError();
        }

    }

    private function getDate($data){
        $date='';
        $time='';
        if($data['type'] == 'reserve'){
            $date=$data['data']['time_place_data']['date'];
            $time = $data['data']['time_place_data']['time'];
        }
        if($data['type'] == 'event'){
            $date=$data['data']['event_data']['date'];
            $time = $data['data']['event_data']['time'];
        }

        return "$date $time";
    }

}
