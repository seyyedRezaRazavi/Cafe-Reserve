<?php

namespace App\Http\Controllers\Admin;

use App\event;
use App\eventLabel;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(event $model)
    {
        $event_labels = eventLabel::pluck('name','id');
        return view('admin.pages.event.index',['events'=>$model->all(),'event_labels'=>$event_labels]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventRequest $request
     * @param  event $model
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request,event $model)
    {
        $event_label = eventLabel::find($request->event_label_id);
        if(!($name = $request->name) || empty($name)){
            $name = $event_label->name;
        }

        if(!($subtitle = $request->subtitle) || empty($name)){
            $subtitle = $event_label->subtitle;
        }
        $new_data =[
            'name'=>$name,
            'subtitle' => $subtitle,
        ];
        $request->merge($new_data);
        $model->create($request->all());

        return redirect()->route('event.index')->withStatus(__('Event successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  event $event
     * @return \Illuminate\Http\Response
     */
    public function show(event $event)
    {
        return view('admin.pages.event.show',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(event $event)
    {

        $event_labels = eventLabel::pluck('name','id');
        return view('admin.pages.event.edit',['event'=>$event,'event_labels'=>$event_labels]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EventRequest $request
     * @param  event $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request,event $event)
    {
        $event->update($request->all());

        return redirect()->route('event.index')->withStatus(__('Event successfully Updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  event $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(event $event)
    {
        $event->delete();
        return redirect()->route('event.index')->withStatus(__('Event successfully Deleted.'));
    }


    public function EventsJson(){
        $events = event::all();
        $result=[];
        $color='';
        foreach ($events as $event){
            $color = ($event->fullData()['state'] == 'Expire') ? 'red' : '';
            $result[]=[
                'url'=>route('event.show',$event),
                'title' => $event->name,
                'start'=>$event->date,
                'color'=>$color
            ];
        }
        return $result;
    }
}
