<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
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
    public function store(DepartmentRequest $request)
    {
        $request->validated();
        $data_array = Department::where('campusid', Auth::user()->campusid)->where('title', $request->title)->first();
        if (empty($data_array)) {
            $dept = new Department();
            $dept->title = $request->title;
            $dept->description = $request->departmentdescription;
            $dept->isdisplay = $request->departmentisdisplay;
            $dept->sequence = $request->departmmentsequence;
            $dept->campusid = Auth::user()->campusid;

            if ($dept->save()) {
                return response()->json(['result' => 'Employee is successfully added']);
            } else {
                return response()->json(['error' => 'Data is successfully added']);
            }
        } else {
            echo 'duplicate';
            exit;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $des = Department::where('campusid', Auth::user()->campusid)->get();
        return response()->json(json_encode($des));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request)
    {
        $request->validated();
        $campusid = Auth::user()->campusid;
        $data_array = Department::where('campusid', $campusid)->where('title', $request->scalename)->where('id', '<>', $request->input('departmentid'))->first();
        if (empty($data_array)) {
            $jobs = Department::where('campusid', $campusid)->where('id', $request->input('departmentid'))->update([
                'title' => $request->input('title'),
                'description' => $request->input('departmentdescription'),
                'isdisplay' => $request->input('departmentisdisplay'),
                'sequence' => $request->input('departmmentsequence'),
            ]);
        } else {
            echo 'duplicate';
            exit;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }
}
