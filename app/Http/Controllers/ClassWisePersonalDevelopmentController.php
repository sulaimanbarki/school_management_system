<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassWisePersonalDevelopmentController extends Controller
{
    public function index()
    {
        return view('admin.Examination.ClassWisePersonalDevelopment');
    }

    public function showSectionForClass(Request $request)
    {
        //ontact::all()
        $campusid = Auth::user()->campusid;
        $cid = $request->classId;
        $SectionData = DB::select("
            SELECT * from `classwisesection` cw, sections s
            where cw.classid = '$cid' and cw.sectionid = s.sec_id
            and cw.campusid = s.campusid and cw.campusid = '$campusid'
            and cw.isdisplay = 1

        ");

        return response()->json(json_encode($SectionData));
    }
}
