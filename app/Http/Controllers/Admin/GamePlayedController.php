<?php

namespace App\Http\Controllers\Admin;

use App\game;
use App\gamePlay;
use App\Http\Controllers\Controller;
use App\Http\Requests\GamePlayedRequest;
use Illuminate\Http\Request;

class GamePlayedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @param  gamePlay $model
     * @return \Illuminate\Http\Response
     */
    public function index(gamePlay $model)
    {
        $games = game::pluck('name','id');
        $states = [
            '0'=>'Unknown',
            '1'=>'Winner',
            '2'=>'Second Place',
            '3'=>'Third Place',
        ];
        return view('admin.pages.game.games_played.index',['games_played'=>$model->all(),'games'=>$games,'states'=>$states]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  gamePlay $model
     * @param  GamePlayedRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GamePlayedRequest $request,gamePlay $model)
    {
       $user_id =1;
        $model->create($request->merge(['user_id'=>$user_id])->all());
        return redirect()->route('game_played.index')->withStatus(__('Game Play successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  gamePlay $gamePlay
     * @return \Illuminate\Http\Response
     */
    public function edit(gamePlay $game_played)
    {
        $games = game::pluck('name','id');
        $states = [
            '0'=>'Unknown',
            '1'=>'Winner',
            '2'=>'Second Place',
            '3'=>'Third Place',
        ];

        return view('admin.pages.game.games_played.edit',compact('game_played'),['games'=>$games,'states'=>$states]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GamePlayedRequest $request
     * @param  gamePlay $game_played
     * @return \Illuminate\Http\Response
     */
    public function update(GamePlayedRequest $request,gamePlay $game_played)
    {
        $user_id =1;
        $game_played->update($request->merge(['user_id'=>$user_id])->all());
        return redirect()->route('game_played.index')->withStatus(__('Game Play successfully Edited.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  gamePlay $game_played
     * @return \Illuminate\Http\Response
     */
    public function destroy(gamePlay $game_played)
    {
        $game_played->delete();
        return redirect()->route('game_played.index')->withStatus(__('Game Play successfully deleted.'));
    }
}
