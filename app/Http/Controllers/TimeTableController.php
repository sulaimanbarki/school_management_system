<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeTableRequest;
use App\Models\TimeTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function TimeTable(){
        return view('admin.TimeTable');
    }
    
    public function PrintTimeTables(Request $r){
        return view('admin.Reports.PrintTimeTables', ['request' => $r]);
    }

    // dismissed
    public function fetchTeacherWiseClasses(Request $r){
        return DB::select("
        SELECT cwt.classid, cl.ClassName, cwt.sectionid, sec.SectionName FROM `class_wise_teachers` cwt INNER JOIN classes cl ON cl.C_id = cwt.classid INNER JOIN sections sec ON sec.Sec_ID = cwt.sectionid WHERE cwt.campusid = cl.campusid AND cwt.sectionid = sec.Sec_ID AND cwt.empid = ? and cwt.campusid = ? GROUP BY cwt.classid
        ", [$r->teacherid, Auth::user()->campusid]);
    }

    public function fetchSectionsForTeacher(Request $r){
        return DB::select("
        SELECT cwt.classid, cl.ClassName, cwt.sectionid, sec.SectionName FROM `class_wise_teachers` cwt INNER JOIN classes cl ON cl.C_id = cwt.classid INNER JOIN sections sec ON sec.Sec_ID = cwt.sectionid WHERE cwt.campusid = cl.campusid AND cwt.sectionid = sec.Sec_ID AND cwt.empid = ? and cwt.campusid = ? AND cwt.classid = ?
        ", [$r->teacherid, Auth::user()->campusid, $r->classid]);
    }

    public function fetchSubjecsForClasses(Request $r){
        return DB::select("
        SELECT cws.classid, cws.subjectid, sub.name FROM `classwisesubjects` cws INNER JOIN subjects sub ON cws.subjectid = sub.id WHERE sub.campusid = cws.campusid AND cws.classid = ? and cws.campusid = ?
        ", [$r->classid, Auth::user()->campusid]);
    }

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
    public function store(TimeTableRequest $request)
    {
        $request->validated();

        try {
            $tt = new TimeTable();
            $tt->classid = $request->classid;
            $tt->sectionid = $request->sectionid;
            $tt->subjectid = $request->subjectid;
            $tt->empid = $request->empid;
            $tt->timeid = $request->timeid;
            $tt->locationid = $request->locationid;
            $tt->sequence = $request->sequence;
            $tt->isdisplay = $request->isdisplay;
            $tt->campusid = Auth::user()->campusid;

            $tt->save();
        } catch(Exception $e){
            return response()->json([
                'success' => 'Duplicate Entry.',
                // 'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function show(TimeTable $timeTable)
    {
        return DB::select("
        SELECT tt.id as tableid, cl.C_id, cl.ClassName, sec.Sec_ID, sec.SectionName, tt.subjectid, sub.name as subjectname, tt.empid, ad.name, tt.timeid, ti.starttime, ti.endtime, tt.locationid, loc.locationname, tt.sequence, tt.isdisplay FROM `time_tables` tt INNER JOIN classes cl ON tt.classid = cl.C_id INNER JOIN sections sec ON tt.sectionid = sec.Sec_ID INNER JOIN subjects sub ON tt.subjectid = sub.id INNER JOIN admins ad ON tt.empid = ad.id INNER JOIN times ti ON ti.id = tt.timeid INNER JOIN locations loc ON loc.id = tt.locationid WHERE tt.campusid = cl.campusid AND tt.campusid = sec.campusid AND tt.subjectid = sub.id AND tt.campusid = ad.campusid AND tt.campusid = ti.campusid AND tt.campusid = loc.campusid AND tt.campusid = ?
        ", [Auth::user()->campusid]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeTable $timeTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function update(TimeTableRequest $request, $timeTable)
    {
        $request->validated();
        try {
            TimeTable::where('campusid', Auth::user()->campusid)->where('id', $timeTable)->update([
                'classid' => $request->classid,
                'sectionid' => $request->sectionid,
                'empid' => $request->empid,
                'subjectid' => $request->subjectid,
                'timeid' => $request->timeid,
                'locationid' => $request->locationid,
                'sequence' => $request->sequence,
                'isdisplay' => $request->isdisplay,
            ]);
        } catch(Exception $e){
            return response()->json([
                'success' => 'Duplicate Entry.',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeTable  $timeTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeTable $timeTable)
    {
        //
    }
}
