<?php

namespace App\Http\Controllers;

use App\Models\PersonalDevelopment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ClassWiseSection as ModelsClassWiseSection;
use ClassWiseSection;
use App\Models\StudentMarks;

class PersonalDevelopmentController extends Controller

{
    public function FetchSubjectsForSubjectWiseMarks(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $classId = $r->classId;
        $subjects = DB::select("
            select * from `classwisesubjects` cws, subjects s
            where cws.subjectid = s.id and cws.campusid = s.campusid and 
            cws.isdisplay = 1 and cws.campusid = ? and classid = ?
        ", [$campusid, $classId]);

        return response()->json(json_encode($subjects));
    }
}
