<?php

namespace App\Http\Controllers;

use App\Models\StudentInfo;
use App\Models\StudentRegistrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentRegistrationsController extends Controller
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
        $request->validate([
            'formid' => 'required',
            'studentname' => 'required',
            'fname' => 'required',
            'contact' => 'required',
            'date' => 'required',
            'academicsession' => 'required',
            'admissioninclass' => 'required'

        ]);
        $campusid = Auth::user()->campusid;
        $check = StudentRegistrations::where('campusid', $campusid)->where('formid', $request->formid)->first();
        if (empty($check)) {
            $reg = new StudentRegistrations();
            $reg->formid = $request->formid;
            $reg->studentname = $request->studentname;
            $reg->fname = $request->fname;
            $reg->contact = $request->contact;
            $reg->admissioninclass = $request->admissioninclass;
            $reg->date = $request->date;
            $reg->academicsession = $request->academicsession;
            $reg->CampusID = $campusid;

            if ($reg->save()) {
                return 'success';
            } else {
                return response()->json(['error' => 'error While adding StudentRegistration']);
            }
        } else {
            return 'duplicate';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $campusid = Auth::user()->campusid;
        // $registrationData = StudentRegistrations::where('campusid','=', $campusid)->get();
        $registrationData = DB::select("select *, sr.id as regid from `studentregistrations` sr, classes cl, academicsessions ass
        where sr.admissioninclass = cl.c_id and sr.academicsession = ass.id
        and sr.campusid = cl.campusid and sr.campusid = ass.campusid and sr.campusid = ?", [$campusid]);

        return response()->json(json_encode($registrationData));
    }

    public function showExistsStd(Request $request)
    {
        $campusid = Auth::user()->campusid;
        try {
            $existedStd = StudentRegistrations::where('campusid', $campusid)->where('formid', $request->formid)->first();
            $ifalreadyAdmitted = StudentInfo::where('campusid', $campusid)->where('formid', $request->formid)->first();
            if ($existedStd and !$ifalreadyAdmitted) {
                return response()->json(json_encode($existedStd));
            } else {
                return response()->json(json_encode([]));
            }
        } catch (\Throwable $th) {
            return response()->json(json_encode(["error" => "Could not load the data"]));
        }
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
    public function update(Request $request)
    {
        //
        // $check = StudentRegistrations::where('campusid', '=', 2)->where('formid', '=', $request->formid)->first();
        // if(empty($check))
        // {
        $request->validate([
            'formid' => 'required',
            'studentname' => 'required',
            'fname' => 'required',
            'contact' => 'required',
            'date' => 'required',
            'academicsession' => 'required',
            'admissioninclass' => 'required'
        ]);

        $update = StudentRegistrations::where('id', $request->input('id'))->update([
            // 'formid' => $request->input('formid'),
            'studentname' => $request->input('studentname'),
            'fname' => $request->input('fname'),
            'contact' => $request->input('contact'),
            'date' => $request->input('date'),
            'academicsession' => $request->input('academicsession'),
            'admissioninclass' => $request->input('admissioninclass'),
        ]);

        if ($update > 0) {
            return response()->json(['Save' => 'StudentRegistration is successfully Done']);
        } else {
            return response()->json(['error' => 'Error While Adding StudentRegistration']);
        }
        //   } else {
        //          return response()->json(['Exist' => 'FormID Already Exist']);
        //      }
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
