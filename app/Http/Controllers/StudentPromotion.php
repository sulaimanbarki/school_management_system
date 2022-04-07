<?php

namespace App\Http\Controllers;

use App\Models\Promotion_Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentPromotion extends Controller
{
    public function index()
    {
        return view('admin.StudentPromotion');
    }

    public function show(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $classid = $r->classid;
        $sectionid = $r->sectionid;
        $students = DB::select("
            select * from `studentinfo` where campusid = ? 
            and status = 'active' and admissioninclass = ? and admissioninsection = ?
        ", [$campusid, $classid, $sectionid]);
        return response()->json(json_encode($students));
    }

    public function PromoteStudents(Request $r)
    {
        $studentid = $r->students;
        if (empty($studentid)) {
            echo 'empty';
            exit;
        }
        // dd($r);
        $campusid = Auth::user()->campusid;
        $formClass = $r->formClass;
        $formSection = $r->formSection;
        $toClass = $r->toClass;
        $toSection = $r->toSection;
        foreach ($studentid as $std) {
            DB::update("
                update `studentinfo` set `admissioninclass`= ?,`admissioninsection`= ? where studentid = ? 
                and admissioninclass = ? and admissioninsection = ? and campusid = ?
            ", [$toClass, $toSection, $std, $formClass, $formSection, $campusid]);

            $sessionid = $r->academicsession;
            $checking = DB::select("
                SELECT * FROM `promotion_status` WHERE sessionid = ? AND studentid = ? AND campusid = ? AND classid = ?
            ", [$sessionid, $std, $campusid, $formClass]);

            if ($formClass > $toClass or $formClass == $toClass) {
                // demoted
                $ps = new Promotion_Status();
                $ps->sessionid = $r->academicsession;
                $ps->studentid = $std;
                $ps->classid = $r->toClass;
                $ps->campusid = $campusid;
                $ps->type = "Demoted";
                $ps->isdisplay = 1;
                $ps->sequence = 1;
                $ps->save();
            } else if ($toClass > $formClass) {
                // promoted
                $ps = new Promotion_Status();
                $ps->sessionid = $r->academicsession;
                $ps->studentid = $std;
                $ps->classid = $r->toClass;
                $ps->campusid = $campusid;
                $ps->type = "Promoted";
                $ps->isdisplay = 1;
                $ps->sequence = 1;
                $ps->save();
            }
            if (!$checking) {
            }
        }
        return "success";
    }
}
