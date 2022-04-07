<?php

namespace App\Http\Controllers;

use App\Models\StudentInfo;
use App\Models\StudentRegistrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StudentInfoController extends Controller
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
        $existedStd = StudentRegistrations::where('campusid', Auth::user()->campusid)->where('formid', $request->formid)->first();
        $ifalreadyAdmitted = StudentInfo::where('campusid', Auth::user()->campusid)->where('formid', $request->formid)->first();
        if (!$existedStd or $ifalreadyAdmitted) {
            echo true;
            exit;
        }

        $prefix = \App\Models\addCampus::where('campusid', Auth::user()->campusid)->first();
        $pre = $prefix->CampusPrefix . $request->admissionnumber;

        // if transport is Yes then transporttype is required
        $checkTransport = "";
        if($request->transport == 'Yes')
            $checkTransport = 'required';
        $request->validate([
            'formid' => 'required',
            'admissionnumber' => '', // |unique:studentinfo,registrationid
            'admissiondate' => 'required',
            'session' => 'required',
            'studentnamee' => 'required',
            'profilepicture' => 'mimes:jpg,jpeg,png|max:2048',
            'gender' => 'required|in:Male,Female,Transgender',
            'status' => 'required|in:Active,stuckoff_absences,stuckoff_feeDefluter,Slc,Matriculate',
            'dob' => 'required',
            'transport' => 'in:Yes,No',
            'transporttype' => $checkTransport,
            'admissioninclass' => 'required',
            'section' => 'required',
            'address1' => 'required',
            'address2' => '',
            'fathername' => 'required',
            'cnic' => '',
            'formb' => '',
            'occupation' => '',
            'fathercontact' => 'required',
            'contact1' => '',
            'contactwhatsapp' => '',
            'admissionremarks' => '',
        ]);


        // if (File::exists("studentprofilepicture/" . StudentInfo::where('id', $request->id)->value('picturepath'))) {
        //     File::delete("studentprofilepicture/" . StudentInfo::where('id', $request->id)->value('picturepath'));
        // }
        $imgname = "";
        if ($request->profilepicture) {
            $imgname =  "studentprofilepicture-" . time() . "." . $request->profilepicture->extension();
            $request->profilepicture->move(public_path('studentprofilepicture'), $imgname);
        }

        $adm = new StudentInfo();
        $adm->formid = $request->formid;
        $adm->studentid = $pre;
        $adm->registrationid = $request->admissionnumber;
        $adm->campusid = Auth::user()->campusid;
        $adm->studentname = $request->studentnamee;
        $adm->fathername = $request->fathername;
        $adm->dob = $request->dob;
        $adm->gender = $request->gender;
        $adm->status = $request->status;
        $adm->admissioninclass = $request->admissioninclass;
        $adm->admissioninsection = $request->section;
        $adm->date = $request->admissiondate;
        $adm->session = $request->session;
        $adm->address1 = $request->address1;
        $adm->address2 = $request->address2;
        $adm->fathercontact = $request->fathercontact;
        $adm->contact1 = $request->contact1;
        $adm->contactwhatsapp = $request->contactwhatsapp;
        $adm->cnic = $request->cnic;
        $adm->formb = $request->formb;
        $adm->occupation = $request->occupation;
        $adm->transportstatus = $request->transport;
        $adm->busnumber = $request->transport == 'Yes' ? $request->transporttype : null;
        $adm->picturepath = $imgname;
        $adm->admissionremarks = $request->admissionremarks;

        if ($adm->save()) {
            return 'success';
        } else {
            return 'error';
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $campusid = Auth::user()->campusid;
        // $admissionData = StudentInfo::where('campusid', Auth::user()->campusid)->get();
        $admissionData = DB::select("select *,si.id as stid from studentinfo si, classes cl, sections sec, academicsessions ass
        where si.admissioninclass = cl.c_id and si.admissioninsection = sec.sec_id and si.session = ass.id
        and si.campusid = cl.campusid and si.campusid = sec.campusid and si.campusid = ass.campusid and si.campusid = ?
        ", [$campusid]);

        return response()->json(json_encode($admissionData));
    }
    // fetch admission number
    public function fetchAdmissionId()
    {
        $admissionNumber = StudentInfo::where('campusid', Auth::user()->campusid)->get();
        if ($admissionNumber->isEmpty()) {
            return 1;
        } else {
            $admissionNumber = StudentInfo::where('campusid', Auth::user()->campusid)->max('registrationid');
            return $admissionNumber + 1;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentInfo $studentInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // if transport is Yes then transporttype is required
        $checkTransport = "";
        if($request->transport == 'Yes')
            $checkTransport = 'required';
        $request->validate([
            // 'formid' => 'required',
            'admissionnumber' => '', // |unique:studentinfo,registrationid
            'admissiondate' => 'required',
            'session' => 'required',
            'studentnamee' => 'required',
            'profilepicture' => 'mimes:jpg,jpeg,png|max:2048',
            'gender' => 'required|in:Male,Female,Transgender',
            'status' => 'required|in:Active,stuckoff_absences,stuckoff_feeDefluter,Slc,Matriculate',
            'dob' => 'required',
            'transport' => 'in:Yes,No',
            'transporttype' => $checkTransport,
            'admissioninclass' => 'required',
            'section' => 'required',
            'address1' => 'required',
            'address2' => '',
            'fathername' => 'required',
            'cnic' => '',
            'formb' => '',
            'occupation' => '',
            'fathercontact' => 'required',
            'contact1' => '',
            'contactwhatsapp' => '',
            'admissionremarks' => '',
        ]);

        $imgname = "";
        if ($request->profilepicture) {
            if (File::exists("studentprofilepicture/" . StudentInfo::where('id', $request->admissionid)->value('picturepath'))) {
                File::delete("studentprofilepicture/" . StudentInfo::where('id', $request->admissionid)->value('picturepath'));
            }

            $imgname =  "studentprofilepicture-" . time() . "." . $request->profilepicture->extension();
            $request->profilepicture->move(public_path('studentprofilepicture'), $imgname);
        } else {
            $imgname = StudentInfo::where('id', $request->admissionid)->value('picturepath');
        }

        $update = StudentInfo::where('id', $request->input('admissionid'))->where('registrationid', $request->admissionnumber)->update([
            'studentname' => $request->input('studentnamee'),
            'fathername' => $request->input('fathername'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'status' => $request->input('status'),
            'admissioninclass' => $request->input('admissioninclass'),
            'admissioninsection' => $request->input('section'),
            'date' => $request->input('admissiondate'),
            'session' => $request->input('session'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'fathercontact' => $request->input('fathercontact'),
            'contact1' => $request->input('contact1'),
            'contactwhatsapp' => $request->input('contactwhatsapp'),
            'cnic' => $request->input('cnic'),
            'formb' => $request->input('formb'),
            'occupation' => $request->input('occupation'),
            'transportstatus' => $request->input('transport'),
            'busnumber' => $request->input('transport') == 'Yes' ? $request->input('transporttype') : null,
            'picturepath' => $imgname,
            'admissionremarks' => $request->input('admissionremarks'),
        ]);

        if ($update > 0) {
            return response()->json(['result' => 'Campus is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
        }
    }

    public function StudentProfile()
    {
        return view('admin.StudentProfile');
    }
    public function LoadStudenInfo(Request $r)
    {
        $stdid = $r->stdid;
        $student = DB::select("select * from `studentinfo` si, classes cl, sections sec
        where si.admissioninclass = cl.c_id and si.admissioninsection = sec.sec_id and si.campusid = cl.campusid and si.campusid = sec.campusid and
        `studentid` = ?
        ", [$stdid]);
        return response()->json(json_encode($student));
    }

    public function RelativesData(Request $r)
    {
        $fatherCNIC =  "%{$r->fatherCNIC}%";

        $student = DB::select("select *, sum(fg.feeamount) as summ from studentinfo si, classes cl, sections sec, 
        feegenerations fg where si.admissioninclass = cl.c_id and 
        si.admissioninsection = sec.sec_id and si.campusid = cl.campusid and si.campusid = sec.campusid 
        and fg.studentid = si.studentid and fg.ispaid = 0 and fg.description != 'reversed' and 
        cnic like ? group by fg.studentid
        ", [$fatherCNIC]);

        return response()->json(json_encode($student));
    }
}
