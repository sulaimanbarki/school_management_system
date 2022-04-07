<?php

namespace App\Http\Controllers;

use App\Models\schooleavingcirtificate;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SchooleavingcirtificateController extends Controller
{
    public function store(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $stdid = $r->student_id;
        $student = DB::select("
        SELECT * FROM `feegenerations` WHERE ispaid = 0 AND description != 'Reversed'
        AND studentid = ? AND campusid = ?
        ", [$stdid, $campusid]);
         $checkSLC = schooleavingcirtificate::where('campusid', $campusid)
         ->where('type', '<>', 'cancel')->where('studentid', $r->student_id)->first();
        // dd($checkSLC);
        $studentRecord =DB::select("
        SELECT * FROM studentinfo  where studentid = ? AND campusid = ? and status!='Slc'
        ", [$stdid, $campusid]);

        if ($studentRecord) {
            echo "1";
            exit;
        } else if($student){
            echo "2";
            exit;
        }else if($checkSLC){
            echo "3";
            exit;
        }else {
            $maxnumber = DB::table('schooleavingcirtificates')->where('campusid', $campusid)->max('slcno');
            if (empty($maxnumber)) {
                $maxnumber = 1;
            }
            // $admissioninclass = DB::select("
            // SELECT studentregistrations.admissioninclass
            // FROM studentregistrations
            // LEFT JOIN studentinfo
            // ON studentinfo.formid = studentregistrations.formid
            // WHERE studentinfo.campusid = '$campusid' AND studentinfo.studentid = '$stdid'
            // ");
            // $admissioninclass = $admissioninclass[0]->admissioninclass;

            $slc = new schooleavingcirtificate();
            $slc->studentid = $r->student_id;
            $slc->slcno = $maxnumber + 1;
            $slc->type = "SLC";
            $slc->admissioninclass = $r->admisstion_class;

            $slc->classtimeofleaving =$r->admisstion_class;
            $slc->campusid =$campusid;
            $slc->conduct =$r->Conduct;
            $slc->remarks ='  ';
            $slc->totalattendence =$r->tw;
            $slc->parentsdays =$r->pd;
            $slc->religion =' ';
            $slc->leavingdate = $r->admissiondate;
            $slc->reasonforleaving = $r->reason;
            if ($slc->save()) {
                return response()->json(['result' => 'FeeHead is successfully added']);
            } else {
                return response()->json(['error' => 'Data is successfully added']);
            }
        }
    }
}
