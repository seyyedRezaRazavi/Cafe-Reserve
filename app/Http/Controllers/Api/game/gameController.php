<?php

namespace App\Http\Controllers\Api\game;

use App\game;
use App\gamePlay;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class gameController extends Controller
{
    public function index(){
        $games = game::all();
        $result = [];
        foreach ($games as $game){
            $result[]=$game->miniData();
        }
        return ReturnSuccess($result);
    }

    public function show($game_id,Request $request){
        $decryptedId = $request->get('decryptedUserId');
        $user = User::find($decryptedId);
        $game = game::find($game_id);
        if($game && $user){
            $game_data = $game->fullData();
            $game_statistic = $this->playerGameStatistic($user,$game);
            $result =[
              'game_data'=>$game_data,
              'game_statistic'=>$game_statistic
            ];
            return ReturnSuccess($result);
        }else{
            return ReturnError();
        }
    }

    private function playerGameStatistic(User $user,game $game){
        $game_playes = gamePlay::where('user_id',$user->id)->where('game_id',$game->id)->orderBy('date','desc')->get();
        $latestPlayDate=null;
        $latestPlayDay=null;
        $tedad_bazi=0;
        $star=0;

        if($game_playes->count() > 0){
            $latestPlayDate = verta($game_playes[0]->date)->format('Y/m/d');
            $latestPlayDay = verta($game_playes[0]->date)->format('l');

            $tedad_bazi = $game_playes->count();
            switch ($tedad_bazi){
                case ($tedad_bazi>=1 && $tedad_bazi<5):
                    $star = 1;
                break;

                case ($tedad_bazi>=5 && $tedad_bazi<20):
                    $star = 2;
                    break;

                case ($tedad_bazi>=20 && $tedad_bazi<50):
                    $star = 3;
                    break;
                case ($tedad_bazi>=50 && $tedad_bazi<100):
                    $star = 4;
                    break;
                case ($tedad_bazi>=100 ):
                    $star = 5;
                    break;
                default:
                    $star = 0;
            }
        }

        return [
            'latestPlayDate'=>$latestPlayDate,
            'latestPlayDay'=>$latestPlayDay,
            'tedad_bazi'=>$tedad_bazi,
            'star'=>$star
        ];
    }
}
