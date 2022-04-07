<?php

namespace App\Http\Controllers;

use App\Models\academicsessions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademicsessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  public $campusid=0;
    public function index()
    {
        //
        $campusid = Auth::user()->campusid;
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

    public function store(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validate([
            'Session' => 'required|min:1|max:255',
            'SessionType' => 'required|min:1|max:255',
            'StartDate' => 'required|date',
            'EndDate' => 'required|date',
            'IsActive' => 'required|boolean',
            'IsCurrent' => 'boolean'
        ]);

        $data_array = academicsessions::where('CampusID', $campusid)->where('Session', $request->Session)->first();
        if (empty($data_array)) {
            $campusid = Auth::user()->campusid;

            $session = new academicsessions();
            $session->Session = $request->Session;
            $session->SessionType = $request->SessionType;
            $session->CampusID = $campusid;
            $session->StartDate = $request->StartDate;
            $session->EndDate = $request->EndDate;
            $session->IsActive = $request->IsActive;
            $session->IsCurrent = 0;
            if ($session->save()) {
                return response()->json(['result' => 'Session is successfully added']);
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
     * @param  \App\Models\academicsessions  $academicsessions
     * @return \Illuminate\Http\Response
     */
    public function show(academicsessions $academicsessions)
    {
        $campusid = Auth::user()->campusid;
        $SessionData = academicsessions::where('CampusID', '=', $campusid)->get();

        return response()->json(json_encode($SessionData));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\academicsessions  $academicsessions
     * @return \Illuminate\Http\Response
     */
    public function edit(academicsessions $academicsessions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\academicsessions  $academicsessions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, academicsessions $academicsessions)
    {
        $campusid = Auth::user()->campusid;
        $request->validate([
            'SessionType' => 'required|min:1|max:255',
            'StartDate' => 'required|date',
            'EndDate' => 'required|date',
            'IsActive' => 'required|boolean',
            'IsCurrent' => 'boolean'
        ]);
        if((int)$request->input('IsCurrent')){
            $checkIsCurrentAcademinSession = academicsessions::where('CampusID', $campusid)->where('IsCurrent', 1)->where('id', '<>', $request->input('SessionID'))->first();
            if(!empty($checkIsCurrentAcademinSession)){
                // returns and issue an error to disable another session
                return 'disable';
                exit;
            }
        }
        $data_array = academicsessions::where('CampusID', $campusid)->where('Session', $request->input('Session'))->where('id', '<>', $request->input('SessionID'))->first();
        if (empty($data_array)) {
            academicsessions::where('id', $request->input('SessionID'))->where('campusid', $campusid)->update([
                'Session' => $request->input('Session'),
                'SessionType' => $request->input('SessionType'),
                'StartDate' => $request->input('StartDate'),
                'EndDate' => $request->input('EndDate'),
                'IsActive' => $request->input('IsActive'),
                'IsCurrent' => $request->input('IsCurrent'),
            ]);
        } else {
            echo 'duplicate';
            exit;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\academicsessions  $academicsessions
     * @return \Illuminate\Http\Response
     */
    public function destroy(academicsessions $academicsessions)
    {
        //
    }
}
