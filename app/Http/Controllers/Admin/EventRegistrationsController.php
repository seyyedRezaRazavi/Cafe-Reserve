<?php

namespace App\Http\Controllers\Admin;

use App\eventRegister;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRegistratinRequest;
use Illuminate\Http\Request;

class EventRegistrationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  EventRegistratinRequest  $request
     * @param  eventRegister $model
     * @return \Illuminate\Http\Response
     */
    public function store(EventRegistratinRequest $request,eventRegister $model)
    {
        $new_data =[
            'user_id' =>1
        ];
        $request->merge($new_data);

        $model->create($request->all());
        return redirect()->route('event.show',$request->event_id)->withStatus(__('New Event Registration successfully Created.'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eventRegister = eventRegister::find($id);
        $event_id = $eventRegister->event_id;
        $eventRegister->delete();
        return redirect()->route('event.show',$event_id)->withStatus(__(' Event Registration successfully Deleted.'));
    }
}
