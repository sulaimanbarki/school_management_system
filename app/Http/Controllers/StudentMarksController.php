<?php

namespace App\Http\Controllers;

use App\Models\StudentInfo;
use App\Models\StudentMarks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentMarksController extends Controller
{
    public function AddStudentsMarks(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $subjectid = $r->subject;
        $counter = count($r->practicalmarks);
        for ($i = 0; $i < $counter; $i++) {
            StudentMarks::where('studentid', $r->studentid[$i])
                ->where('campusid', Auth::user()->campusid)
                ->where('classid', $classid)->where('sectionid', $sectionid)
                ->where('subjectid', $subjectid)->where('termid', $r->term)
                ->where('sessionid', $r->asession)->update([
                    'total_marks_theory' => $r->theorymarkstotal[$i],
                    'obtain_marks_theory' => $r->theorymarks[$i],
                    'isAbsenct_theory' => $r->isAbsentTheory[$i],

                    'total_marks_practical' => $r->practicalmarkstotal[$i],
                    'obtain_marks_practical' => $r->practicalmarks[$i],
                    'isAbsenct_practical' => $r->isAbsentPractical[$i],
                    'date' => date('Y-m-d'),
                    'timestampss' => date("Y-m-d H:i:s"),
                ]);
        }
    }

    public function AddSingleStudentMarks(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $r->subjectidd;
        // dd($subjectid);
        // dd($r);
        // dd($r->studentid);
        $counter = count($r->practicalmarks);
        for ($i = 0; $i < $counter; $i++) {
            echo $r->subjectid;
            StudentMarks::where('studentid', $r->studentidd[$i])
                ->where('campusid', Auth::user()->campusid)
                ->where('classid', $classid)
                ->where('subjectid', $r->subjectidd[$i])->where('termid', $r->term)
                ->where('sessionid', $r->asession)->update([
                    // 'total_marks_theory' => $r->theorymarkstotal[$i],
                    'obtain_marks_theory' => $r->theorymarks[$i],
                    'isAbsenct_theory' => $r->isAbsentTheory[$i],

                    // 'total_marks_practical' => $r->practicalmarkstotal[$i],
                    'obtain_marks_practical' => $r->practicalmarks[$i],
                    'isAbsenct_practical' => $r->isAbsentPractical[$i],
                    'date' => date('Y-m-d'),
                    'timestampss' => date("Y-m-d H:i:s"),
                ]);
        }
    }

    public function ExamResultFetchStudentInfo(Request $r)
    {
        $res = StudentInfo::where('campusid', Auth::user()->campusid)->where('studentid', $r->studentid)->first();

        return response()->json(json_encode($res));
    }

    public function ExamRptSinglStudent(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $session = $r->asession;
        $termid = $r->term;
        $studentid = $r->studentid;
        // $res = StudentMarks::where('campusid', Auth::user()->campusid)->where('sessionid', $r->asession)->where('termid', $r->term)->where('studentid', $r->studentid)->get();
        $ress = DB::select("
        select * from `studentmarks` sm, subjects s
        where sm.subjectid = s.id and sm.campusid = s.campusid and sm.campusid = ? and sm.sessionid = ? and sm.termid = ? and sm.studentid = ?
        ", [$campusid, $session, $termid, $studentid]);
        return view('admin.Examination.SingleStudentDMC', ['student' => $ress, 'r' => $r]);
    }
}
