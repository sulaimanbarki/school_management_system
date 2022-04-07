<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffAttendanceRequest;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select("
            SELECT sa.id, sa.date, sa.description, ad.name FROM `staff_attendances` sa RIGHT JOIN admins ad ON sa.empid = ad.id WHERE sa.campusid = ?
        ", [Auth::user()->campusid]);
        return StaffAttendance::where('campusid', Auth::user()->campusid)->whereRaw('month(date) = month(CURRENT_DATE()) and year(date) = year(CURRENT_DATE())')->get();
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
    public function store(StaffAttendanceRequest $request)
    {
        $request->validated();
        if(StaffAttendance::where('campusid',  Auth::user()->campusid)->where('empid', $request->empid)->where('date', $request->date)->first()){
            echo 'duplicate';
            exit;
        }

        $attendance = new StaffAttendance();
        $attendance->empid = $request->empid;
        $attendance->date = $request->date;
        $attendance->description = $request->description;
        $attendance->campusid = Auth::user()->campusid;
        $attendance->status = 1;

        if($attendance->save()){
            return response('', 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaffAttendance  $staffAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(StaffAttendance $staffAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffAttendance  $staffAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffAttendance $staffAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffAttendance  $staffAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffAttendance $staffAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffAttendance  $staffAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $color = StaffAttendance::find($id);
        $color->delete();
        return response('', 200);
    }
}
