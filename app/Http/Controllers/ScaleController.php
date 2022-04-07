<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScaleRequest;
use App\Models\Scale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScaleController extends Controller
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
    public function store(ScaleRequest $request)
    {
        // validation request, ScaleRequest performs all the validation
        $request->validated();
        $campusid = Auth::user()->campusid;

        $data_array = Scale::where('campusid', $campusid)->where('name', $request->scalename)->where('academicsession', $request->academicsession)->first();
        if (empty($data_array)) {
            $scale = new Scale();
            $scale->name = $request->scalename;
            $scale->description = $request->scaledescription;
            $scale->basicpay = $request->basicpay;
            $scale->yearlyincrement = $request->yearlyincrement;
            $scale->salarylimit = $request->salarylimit;
            $scale->eobiamount = $request->eobiamount;
            $scale->academicsession = $request->academicsession;
            $scale->isactive = $request->isactive;
            $scale->sequence = $request->sequence;
            $scale->campusid = $campusid;
            $scale->leaveAmount = $request->LeaveAmount;
            $scale->leaveStatus = $request->LeaveStatus ? 1 : 0;
            if ($scale->save()) {
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
     * @param  \App\Models\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function show(Scale $scale)
    {
        $campusid = Auth::user()->campusid;
        // $des = Scale::where('campusid', $campusid)->get();
        $des = DB::select("SELECT *, sc.id as scaleid FROM `scales` sc, academicsessions acs WHERE sc.academicsession = acs.id AND acs.CampusID = sc.campusid AND sc.campusid = ?
        ", [$campusid]);
        return response()->json(json_encode($des));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function edit(Scale $scale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function update(ScaleRequest $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validated();
        $data_array = Scale::where('campusid', $campusid)->where('name', $request->scalename)->where('academicsession', $request->academicsession)->where('id', '<>', $request->input('id'))->first();
        if (empty($data_array)) {
            $jobs = Scale::where('campusid', $campusid)->where('id', $request->input('id'))->update([
                'name' => $request->input('scalename'),
                'description' => $request->input('scaledescription'),
                'basicpay' => $request->input('basicpay'),
                'yearlyincrement' => $request->input('yearlyincrement'),
                'salarylimit' => $request->input('salarylimit'),
                'leaveAmount' => $request->LeaveAmount,
                'leaveStatus' => $request->LeaveStatus ? 1 : 0,
                'eobiamount' => $request->input('eobiamount'),
                'academicsession' => $request->input('academicsession'),
                'isactive' => $request->input('isactive'),
                'sequence' => $request->input('sequence'),
            ]);
        } else {
            echo 'duplicate';
            exit;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scale $scale)
    {
        //
    }
}
