<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\reserve;
use App\timePlace;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reserves = reserve::orderBy('id','desc')->take(10)->get();
        return view('admin.pages.reserve.index',['reserves'=>$reserves]);
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
    public function destroy(reserve $reserve)
    {
        $reserve->delete();
        return redirect()->back()->withStatus(__('Reserve successfully Deleted.'));
    }

    public function Cancel(reserve $reserve)
    {
        $reserve->state=-1;
        $reserve->save();

        return redirect()->back()->withStatus(__('Reserve successfully Canceled.'));
    }

    public function ReserveJson(){
        $timeplaces = timePlace::groupBy('location_id')->groupBy('date')->orderBy('date')->get();

        $result=[];
        foreach ($timeplaces as $timeplace){
            $color='';
            $result[]=[
                'url'=>route('time_place.showInGroup',$timeplace),
                'title' => $timeplace->location->name,
                'start'=>$timeplace->date,
                'color'=>$color
            ];
        }

        return$result;

    }
}
