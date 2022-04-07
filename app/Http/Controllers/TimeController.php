<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeRequest;
use App\Models\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeController extends Controller
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
    public function store(TimeRequest $request)
    {
        $request->validated();

        $campusid = Auth::user()->campusid;
        // if (Time::where('campusid', $campusid)->where('timename', $request->timename)->first()){
        //     echo 'duplicate';
        //     exit;
        // } else {
            $time = new Time();
            $time->starttime = $request->starttime;
            $time->endtime = $request->endtime;
            $time->sequence = $request->sequence;
            $time->isdisplay = $request->isdisplay;
            $time->campusid = $campusid;

            if($time->save()){
                return response('', 200);
            }
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function show(Time $time)
    {
        return Time::where('campusid', Auth::user()->campusid)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function edit(Time $time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function update(TimeRequest $request, $time)
    {
        $request->validated();
        $campusid = Auth::user()->campusid;
        Time::where('campusid', $campusid)->where('id', $time)->update([
            'starttime' => $request->starttime,
            'endtime' => $request->endtime,
            'sequence' => $request->sequence,
            'isdisplay' => $request->isdisplay,
        ]);

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function destroy(Time $time)
    {
        //
    }
}
