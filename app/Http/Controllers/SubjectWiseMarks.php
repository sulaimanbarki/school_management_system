<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ClassWiseSection as ModelsClassWiseSection;
use ClassWiseSection;
use App\Models\StudentMarks;


class SubjectWiseMarks extends Controller
{
    public function index()
    {
        return view('admin.Examination.SubjectWiseMarks');
    }

    public function FetchTermsForClassWiseMarks(Request $r)
    {
        $sessionid = $r->sessionid;
        $campusid = Auth::user()->campusid;
        $res = DB::select("
            SELECT * FROM `termnames` WHERE sessionid = ?  AND campusid = ? and isactive = 1 and isdisplay = 1
        ", [$sessionid, $campusid]);
        return response()->json(json_encode($res));
    }

    public function FetchSctionsForSubjectWiseMarks(Request $r)
    {
        $sessionid = $r->sessionid;
        $campusid = Auth::user()->campusid;
        $res = DB::select("
            SELECT * FROM `termnames` WHERE sessionid = ? AND campusid = ?
        ", [$sessionid, $campusid]);
        return response()->json(json_encode($res));
    }

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

    public function FetchStudentsForSubjectWiseMarks(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $sectionid = $r->sectionid;
        $classid = $r->classid;
        $subjectid = $r->subjectid;
        $sessionID = $r->sessionID;
        $termID = $r->termID;

        if ($sessionID < 1) {
            $sessionID = null;
        } else if ($termID < 1) {
            $termID = null;
        }

        $result1 = DB::select("
        select s.studentid,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid,
        cl.theorymarks,0,0,cl.practicalmarks,0,0,'0','1','1',0,0,'1','date',0,0,'0','0','0' from
        studentinfo s,classwisesubjects cl where s.admissioninclass = cl.classid and 
        s.admissioninclass = ? and s.admissioninsection = ? and
        cl.subjectid = ?
        and s.campusid = ? and status in('active') and studentid
        not in(select studentid from studentmarks sm where  
        sm.classid=? and sm.sectionid=? and sm.subjectid=? 
        and sm.termid=? and sm.campusid=? and sm.sessionid=?)
        ", [$classid, $sectionid, $subjectid, $campusid, $classid, $sectionid, $subjectid, $termID, $campusid, $sessionID]);
        $i = 0;
        foreach ($result1 as $StudentData) {
            $check = StudentMarks::where('studentid', $StudentData->studentid)
                ->where('campusid', Auth::user()->campusid)->where('classid', $classid)
                ->where('sectionid', $sectionid)->where('subjectid', $subjectid)
                ->where('termid', $termID)->where('sessionid', $sessionID)->first();
            if (empty($check)) {
                $reg = new StudentMarks();
                $reg->studentid = $StudentData->studentid;
                $reg->campusid = Auth::user()->campusid;
                $reg->classid = $classid;
                $reg->sectionid = $sectionid;
                $reg->subjectid = $subjectid;
                $totalMarks = $StudentData->theorymarks;
                $reg->total_marks_theory = $totalMarks;
                $reg->obtain_marks_theory = 0;
                $reg->isAbsenct_theory = 0;
                $reg->total_marks_practical = $StudentData->practicalmarks;
                $reg->obtain_marks_practical = 0;
                $reg->isAbsenct_practical = 0;
                $reg->date = date('Y-m-d');
                $reg->termid = $termID;
                $reg->sessionid = $sessionID;
                $reg->attempted_status = 1; // attempted status
                $reg->position = 1;
                $reg->addedby = Auth::user()->id;
                $reg->timestampss = date("Y-m-d H:i:s");
                $reg->isFinalize = 0;
                $reg->pcname = gethostname();
                $reg->macaddress = substr(exec('getmac'), 0, 17);
                $reg->ipaddress = \Request::ip();
                $reg->save();
                $i++;
            }
        }

        $result = DB::select("
        select  s.studentid,s.studentname,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid,
        cl.theorymarks,cl.practicalmarks,obtain_marks_theory,obtain_marks_practical,sm.termid,sm.sessionid, sm.isabsenct_theory, sm.isabsenct_practical
        from studentinfo s,classwisesubjects cl,studentmarks sm where s.admissioninclass=cl.classid
        and
        s.admissioninclass=? and s.admissioninsection=?  and
        s.campusid=cl.campusid and sm.campusid=s.campusid and cl.classid=sm.classid
        and cl.subjectid=?
        and s.campusid=? and status in('active') and termid=?
        and sessionid=?
        and sm.studentid=s.studentid and sm.subjectid=cl.subjectid
        ", [$classid, $sectionid, $subjectid, $campusid, $termID, $sessionID]);
        return response()->json(json_encode($result));
    }

    public function FetchSingleStudentForSubjectWiseMarks(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $sessionID = $r->sessionID;
        $termID = $r->termID;
        $studentid = $r->studentid;
        $classid = $r->classid;
        if ($sessionID < 1) {
            $sessionID = null;
        } else if ($termID < 1) {
            $termID = null;
        }

        $result1 = DB::select("
        select s.studentid,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid,
        cl.theorymarks,0,0,cl.practicalmarks,0,0,'0','1','1',0,0,'1','date',0,0,'0','0','0' from
        studentinfo s,classwisesubjects cl where s.admissioninclass = cl.classid and 
        s.admissioninclass = ?
        and s.campusid = ? and status in('active') and  s.studentid= ?
        ", [$classid, $campusid, $studentid]);
        $i = 0;
        foreach ($result1 as $StudentData) {
            $check = StudentMarks::where('studentid', $StudentData->studentid)
                ->where('campusid', Auth::user()->campusid)->where('classid', $classid)
                ->where('termid', $termID)
                ->where('subjectid', $StudentData->subjectid)
                ->where('sessionid', $sessionID)->first();
            if (empty($check)) {
                $reg = new StudentMarks();
                $reg->studentid = $StudentData->studentid;
                $reg->campusid = Auth::user()->campusid;
                $reg->classid = $classid;
                $reg->sectionid = $StudentData->admissioninsection;
                $reg->subjectid = $StudentData->subjectid;
                $totalMarks = $StudentData->theorymarks;
                $reg->total_marks_theory = $totalMarks;
                $reg->obtain_marks_theory = 0;
                $reg->isAbsenct_theory = 0;
                $reg->total_marks_practical = $StudentData->practicalmarks;
                $reg->obtain_marks_practical = 0;
                $reg->isAbsenct_practical = 0;
                $reg->date = date('Y-m-d');
                $reg->termid = $termID;
                $reg->sessionid = $sessionID;
                $reg->attempted_status = 1; // attempted status
                $reg->position = 1;
                $reg->addedby = Auth::user()->id;
                $reg->timestampss = date("Y-m-d H:i:s");
                $reg->isFinalize = 0;
                $reg->pcname = gethostname();
                $reg->macaddress = substr(exec('getmac'), 0, 17);
                $reg->ipaddress = \Request::ip();
                $reg->save();
                $i++;
            }
        }

        $result = DB::select("
            select s.status, s.studentid,s.studentname,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid, cl.theorymarks,cl.practicalmarks,obtain_marks_theory,obtain_marks_practical,sm.termid,sm.sessionid, sm.isabsenct_theory, sm.isabsenct_practical, sub.name from studentinfo s,classwisesubjects cl,studentmarks sm, subjects sub where s.admissioninclass=cl.classid and s.admissioninclass= ? and  s.campusid=cl.campusid and sm.campusid=s.campusid and cl.classid=sm.classid and s.campusid= ? and status in('active') and termid= ? and sessionid= ? and sm.studentid= ? and sm.studentid=s.studentid and sm.subjectid=cl.subjectid and sub.id = sm.subjectid
        ", [$classid, $campusid, $termID, $sessionID, $studentid]);
        // dd($result);
        return response()->json(json_encode($result));
    }
}
