<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\reserve;
use App\timePlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimePlaceController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  timePlace $timePlace
     * @return \Illuminate\Http\Response
     */
    public function show(timePlace $timePlace)
    {
        return view('admin.pages.reserve.time_place.show',compact('timePlace'));
    }

    public function showInGroup(timePlace $timePlace)
    {
        $timeplaces_ids = timePlace::select(DB::raw('group_concat(id) as ids'))->groupBy('location_id')->groupBy('date')->orderBy('date')
            ->where('location_id',$timePlace->location_id)->where('date',$timePlace->date)->first()['ids'];

        $reserves = reserve::whereIn('time_place_id',explode(",",$timeplaces_ids))->get();

        return view('admin.pages.reserve.time_place.show_group',compact('timePlace'),['reserves'=>$reserves]);
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
        //
    }
}
