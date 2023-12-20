<?php

namespace App\Http\Controllers\Admin;

use App\game;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GamesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(game $model)
    {
        //return view('admin.pages.game.index',['games'=>$model->paginate(15)]);
        return view('admin.pages.game.index',['games'=>$model->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.game.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\GameRequest  $request
     * @param  \App\game  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GameRequest $request, game $model)
    {
        $cover_picture_field=['cover_picture' =>null];
        if($request->has('game_image') && !empty($request->game_image)){

            $image = $request->file('game_image');
            $file_name = $this->upload_game_picture_to_storage($image,$request);
            $cover_picture_field = ['cover_picture' => $file_name];
        }


        $model->create($request->merge($cover_picture_field)->all());
        return redirect()->route('games.index')->withStatus(__('Game successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  game $game
     * @return \Illuminate\Http\Response
     */
    public function edit(game $game)
    {
        return view('admin.pages.game.edit',compact('game'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GameRequest $request
     * @param  game $game
     * @return \Illuminate\Http\Response
     */
    public function update(GameRequest $request, game $game)
    {
        if($request->has('game_image') && !empty($request->game_image)){
            $image = $request->file('game_image');
            $file_name = $this->upload_game_picture_to_storage($image,$request);

            $game->update($request->merge(['cover_picture' => $file_name])->all());
            return redirect()->route('games.index')->withStatus(__('Game successfully updated.'));
        }

        $game->update($request->all());
        return redirect()->route('games.index')->withStatus(__('Game successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(game $game)
    {
        $filename = $game->cover_picture;
        $game->delete();

        $this->delete_cover_image_from_storage($filename);
        return redirect()->route('games.index')->withStatus(__('Game successfully deleted.'));
    }

    public function remove_cover_image(game $game)
    {
        $filename = $game->cover_picture;
        $game->cover_picture=null;
        $game->save();

        $this->delete_cover_image_from_storage($filename);


        return redirect()->route('games.edit',$game)->withStatus(__('Game Cover Picture successfully deleted.'));
    }

    private function delete_cover_image_from_storage($filename){

        $folder = '/img/games/';
        File::delete(public_path().$folder.$filename);
        return true;
    }

    private function upload_game_picture_to_storage($image,$request){
        $name = Str::slug($request->input('name')).'_'.time();
        $folder = '/img/games/';
        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
        $img = Image::make($image);
        $img->save(public_path().$filePath);
        return  $name. '.' . $image->getClientOriginalExtension();
    }
}
