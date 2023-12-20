<?php

namespace App\Http\Controllers\Admin;

use App\eventLabel;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventLableRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class EventLabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(eventLabel $model)
    {
        return view('admin.pages.event.event_label.index',['event_labels'=>$model->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.event.event_label.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventLableRequest $request,eventLabel $model)
    {
        $cover_picture_field=['picture' =>null];
        if($request->has('label_image') && !empty($request->label_image)){

            $image = $request->file('label_image');
            $file_name = $this->upload_game_picture_to_storage($image,$request);
            $cover_picture_field = ['picture' => $file_name];
        }


        $model->create($request->merge($cover_picture_field)->all());
        return redirect()->route('event_label.index')->withStatus(__('Event Label successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(eventLabel $event_label)
    {
        return view('admin.pages.event.event_label.show',compact('event_label'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(eventLabel $event_label)
    {
        return view('admin.pages.event.event_label.edit',compact('event_label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventLableRequest $request,eventLabel $eventLabel)
    {

        if($request->has('label_image') && !empty($request->label_image)){

            $image = $request->file('label_image');
            $file_name = $this->upload_game_picture_to_storage($image,$request);
            $cover_picture_field = ['picture' => $file_name];
            $eventLabel->update($request->merge($cover_picture_field)->all());
            return redirect()->route('event_label.index')->withStatus(__('Event Label successfully Updated.'));
        }

        $eventLabel->update($request->all());
        return redirect()->route('event_label.index')->withStatus(__('Event Label successfully Updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(eventLabel $eventLabel)
    {
        $filename = $eventLabel->picture;
        $eventLabel->delete();

        $this->delete_cover_image_from_storage($filename);
        return redirect()->route('event_label.index')->withStatus(__('Event Lable successfully deleted.'));
    }

    public function remove_cover_image(eventLabel $eventLabel)
    {
        $filename = $eventLabel->picture;
        $eventLabel->picture=null;
        $eventLabel->save();

        $this->delete_cover_image_from_storage($filename);


        return redirect()->route('event_label.edit',$eventLabel)->withStatus(__('Event Label Cover Picture successfully deleted.'));
    }

    private function upload_game_picture_to_storage($image,$request){
        $name = Str::slug($request->input('name')).'_'.time();
        $folder = '/img/events/';
        $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
        $img = Image::make($image);
        $img->save(public_path().$filePath);
        return  $name. '.' . $image->getClientOriginalExtension();
    }

    private function delete_cover_image_from_storage($filename){

        $folder = '/img/events/';
        File::delete(public_path().$folder.$filename);
        return true;
    }
}
