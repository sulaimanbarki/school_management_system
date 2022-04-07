<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassWiseTeacherRequest;
use App\Models\ClassWiseTeacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassWiseTeacherController extends Controller
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
    public function store(ClassWiseTeacherRequest $request)
    {
        $request->validated();

        try {
            $cwt = new ClassWiseTeacher();
            $cwt->classid = $request->classid;
            $cwt->sectionid = $request->section;
            $cwt->empid = $request->empid;
            $cwt->campusid = Auth::user()->campusid;

            $cwt->save();
        } catch(Exception $e){
            return response()->json([
                'success' => 'Duplicate Entry.',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassWiseTeacher  $classWiseTeacher
     * @return \Illuminate\Http\Response
     */
    public function show(ClassWiseTeacher $classWiseTeacher)
    {
        return DB::select("
        SELECT cl.C_id, cl.ClassName, sec.Sec_ID, sec.SectionName, ad.id, ad.name, cwt.id as tableid FROM `class_wise_teachers` cwt INNER JOIN classes cl ON cwt.classid = cl.C_id INNER JOIN sections sec ON cwt.sectionid = sec.Sec_ID INNER JOIN admins ad ON ad.id = cwt.empid WHERE cwt.campusid = cl.campusid AND cwt.campusid = sec.campusid AND cwt.campusid = ad.campusid AND cwt.campusid = ?
        ", [Auth::user()->campusid]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassWiseTeacher  $classWiseTeacher
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassWiseTeacher $classWiseTeacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassWiseTeacher  $classWiseTeacher
     * @return \Illuminate\Http\Response
     */
    public function update(ClassWiseTeacherRequest $request, $classWiseTeacher)
    {
        $request->validated();
        try {
            ClassWiseTeacher::where('campusid', Auth::user()->campusid)->where('id', $classWiseTeacher)->update([
                'classid' => $request->classid,
                'sectionid' => $request->section,
                'empid' => $request->empid,
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
     * @param  \App\Models\ClassWiseTeacher  $classWiseTeacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassWiseTeacher $classWiseTeacher)
    {
        //
    }
}
