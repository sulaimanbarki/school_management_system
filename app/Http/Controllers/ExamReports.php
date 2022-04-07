<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamReports extends Controller
{
    // award list without data
    public function AwardListWithoutdata(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $subjectid = $r->subject;
        $campusid = Auth::user()->campusid;
        $termid = $r->term;
        $sessionid = $r->asession;

        $StudentData = DB::select("
        SELECT  s.studentid,s.studentname,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid,
        cl.theorymarks,cl.practicalmarks,obtain_marks_theory,obtain_marks_practical,sm.termid,sm.sessionid
        from studentinfo s,classwisesubjects cl,studentmarks sm where s.admissioninclass=cl.classid
        and
        s.admissioninclass= ? and s.admissioninsection= ?  and
        s.campusid=cl.campusid and sm.campusid=s.campusid and cl.classid=sm.classid
        and cl.subjectid= ?
        and s.campusid= ? and status in('active') and termid= ?
        and sessionid= ?
        and sm.studentid=s.studentid and sm.subjectid=cl.subjectid

        ", [$classid, $sectionid, $subjectid, $campusid, $termid, $sessionid]);

        return view('admin.Examination.AwardListWithoutdata', ['StudentData' => $StudentData]);
    }
    // award list with data
    public function AwardListWithdata(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $subjectid = $r->subject;
        $campusid = Auth::user()->campusid;
        $termid = $r->term;
        $sessionid = $r->asession;

        $StudentData = DB::select("
        SELECT  s.studentid,s.studentname,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid,
        cl.theorymarks,cl.practicalmarks,obtain_marks_theory,obtain_marks_practical,sm.termid,sm.sessionid
        from studentinfo s,classwisesubjects cl,studentmarks sm where s.admissioninclass=cl.classid
        and
        s.admissioninclass=? and s.admissioninsection=?  and
        s.campusid=cl.campusid and sm.campusid=s.campusid and cl.classid=sm.classid
        and cl.subjectid=?
        and s.campusid=? and status in('active') and termid=?
        and sessionid=?
        and sm.studentid=s.studentid and sm.subjectid=cl.subjectid

        ", [$classid, $sectionid, $subjectid, $campusid, $termid, $sessionid]);

        return view('admin.Examination.AwardListWithdata', ['StudentData' => $StudentData]);
    }
    // class and section wise award list without data
    public function ClassandSectionWiseWithoutData(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $subjectid = $r->subject;
        $campusid = Auth::user()->campusid;
        $termid = $r->term;
        $sessionid = $r->asession;


        $StudentData = DB::select("
        SELECT  s.studentid,s.studentname,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid,
        cl.theorymarks,cl.practicalmarks,obtain_marks_theory,obtain_marks_practical,sm.termid,sm.sessionid
        from studentinfo s,classwisesubjects cl,studentmarks sm where s.admissioninclass=cl.classid and s.admissioninclass=? and s.admissioninsection=?  and
        s.campusid=cl.campusid and sm.campusid=s.campusid and cl.classid=sm.classid and s.campusid=? and status in('active') and termid=? and sessionid=?
        and sm.studentid=s.studentid and sm.subjectid = cl.subjectid group by cl.subjectid
        ", [$classid, $sectionid, $campusid, $termid, $sessionid]);

        // dd($StudentData);

        return view('admin.Examination.ClassandSectionWiseWithoutData', ['StudentData' => $StudentData, 'r' => $r]);
    }
    // class and section wise award list with data
    public function ClassandSectionWiseWithData(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $subjectid = $r->subject;
        $campusid = Auth::user()->campusid;
        $termid = $r->term;
        $sessionid = $r->asession;

        $StudentData = DB::select("
        SELECT s.studentid,s.studentname,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid,
        cl.theorymarks,cl.practicalmarks,obtain_marks_theory,obtain_marks_practical,sm.termid,sm.sessionid
        from studentinfo s,classwisesubjects cl,studentmarks sm WHERE s.admissioninclass=cl.classid
        and
        s.admissioninclass=? and s.admissioninsection=?  and
        s.campusid=cl.campusid and sm.campusid=s.campusid and cl.classid=sm.classid
        and s.campusid=? and status in('Active') and termid=?
        and sessionid=?
        and sm.studentid=s.studentid and sm.subjectid=cl.subjectid group by cl.subjectid

        ", [$classid, $sectionid, $campusid, $termid, $sessionid]);

        return view('admin.Examination.ClassandSectionWiseWithData', ['StudentData' => $StudentData, 'r' => $r]);
    }


    // class wise award list without data
    public function ClassWiseAwardListWithoutData(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $subjectid = $r->subject;
        $campusid = Auth::user()->campusid;
        $termid = $r->term;
        $sessionid = $r->asession;

        $StudentData = DB::select("
        SELECT * from `studentmarks` where classid = ? and `sessionid` = ? and `termid` = ? and campusid = ?
        ", [$classid, $sessionid, $termid, $campusid]);

        return view('admin.Examination.ClassWiseAwardListWithoutData', ['Class' => $StudentData, 'r' => $r]);
    }

    public function AllSubjectAwardList(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $subjectid = $r->subject;
        $campusid = Auth::user()->campusid;
        $termid = $r->term;
        $sessionid = $r->asession;

        $StudentData = DB::select("
        SELECT * from `studentmarks` where classid = ? and `sessionid` = ? and `termid` = ? and campusid = ?
        ", [$classid, $sessionid, $termid, $campusid]);
        // dd($StudentData);

        return view('admin.Examination.AllSubjectAwardList', ['request' => $r,'StudentData'=>$StudentData]);
    }

    // class wise award list with data
    public function ClassWiseAwardListWithData(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $subjectid = $r->subject;
        $campusid = Auth::user()->campusid;
        $termid = $r->term;
        $sessionid = $r->asession;

        $StudentData = DB::select("
        SELECT * from `studentmarks` where classid = ? and `sessionid` = ? and `termid` = ? and campusid = ?
        ", [$classid, $sessionid, $termid, $campusid]);

        return view('admin.Examination.ClassWiseAwardListWithData', ['Class' => $StudentData, 'r' => $r]);
    }

    public function PersonalDevelopmentWithoutData(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $subjectid = $r->subject;
        $campusid = Auth::user()->campusid;
        $termid = $r->term;
        $sessionid = $r->asession;

        $StudentData = DB::select("
        SELECT s.studentid,s.studentname,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid,
        cl.theorymarks,cl.practicalmarks,obtain_marks_theory,obtain_marks_practical,sm.termid,sm.sessionid
        from studentinfo s,classwisesubjects cl,studentmarks sm where s.admissioninclass=cl.classid
        and s.admissioninclass=? and s.admissioninsection=?  and
        s.campusid=cl.campusid and sm.campusid=s.campusid and cl.classid=sm.classid
        and cl.subjectid=? and s.campusid=? and status in('active') and termid=?
        and sessionid=? and sm.studentid=s.studentid and sm.subjectid=cl.subjectid

        ", [$classid, $sectionid, $subjectid, $campusid, $termid, $sessionid]);

        return view('admin.Examination.PersonalDevelopmentWithoutData', ['StudentData' => $StudentData]);
    }
}
