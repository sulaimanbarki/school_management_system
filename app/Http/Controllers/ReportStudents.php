<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportStudents extends Controller
{
    public function index()
    {
        return view('admin.Reports.ReportStudents');
    }
    public function justClassWiseContact(Request $r)
    {
        $classid = $r->class;
        $cid = Auth::user()->campusid;
        $asession = $r->sessionid;
        $result = DB::select("
        SELECT * FROM `studentinfo` s, sections sec, classes c
        WHERE s.status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter') and `admissioninclass` = ? AND c.C_id = s.admissioninclass AND c.campusid = s.campusid
        AND s.campusid = ? AND s.admissioninsection = sec.Sec_ID and s.session = ?
        GROUP BY admissioninsection
        ", [$classid, $cid, $asession]);

        // dd($result);

        return view("admin.Reports.ReportJustClassWiseContact", ["classes" => $result]);
    }

    public function ShowClassWiseContact(Request $r)
    {
        $classid = $r->class;
        $section = $r->section;
        $asession = $r->sessionid;
        $cid = Auth::user()->campusid;
        $result = DB::select("
            SELECT * FROM `studentinfo` s, classes c, sections sec
            WHERE s.status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter') and s.campusid = c.campusid AND s.admissioninclass = c.C_id
            AND c.C_id = ? AND c.campusid = ? and s.admissioninsection=?
            AND sec.Sec_ID = ? and s.session = ?
        ", [$classid, $cid, $section, $section, $asession]);

        // dd($result);

        return view("admin.Reports.ReportClassWiseContacts", ["students" => $result]);
    }


    public function classAndSectionWiseList(Request $r)
    {
        $classid = $r->class;
        $section = $r->section;
        $cid = Auth::user()->campusid;
        $result = DB::select("
            SELECT * FROM `studentinfo` s, classes c, sections sec
            WHERE s.status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter') and s.campusid = c.campusid AND s.admissioninclass = c.C_id
            AND c.C_id = ? AND c.campusid = ? and s.admissioninsection=?
            AND sec.Sec_ID = ? and s.session = ?
        ", [$classid, $cid, $section, $section, $r->sessionid]);

        return view("admin.Reports.ReportClassAndSectionWise", ["students" => $result]);
    }

    public function ClassWiseList(Request $r)
    {
        $classid = $r->class;
        $cid = Auth::user()->campusid;
        $result = DB::select("
        SELECT * FROM `studentinfo` s, sections sec, classes c
        WHERE s.status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter') and `admissioninclass` = ?
        AND s.campusid = ? AND s.admissioninsection = sec.Sec_ID  and s.session = ?
        GROUP BY admissioninsection
        ", [$classid, $cid, $r->sessionid]);

        return view("admin.Reports.ReportClassWiseList", ["classes" => $result]);
    }

    public function AttendenceRegister(Request $r)
    {
        $classid = $r->class;
        $section = $r->section;
        $cid = Auth::user()->campusid;
        $result = DB::select("
            SELECT * FROM `studentinfo` s, classes c, sections sec
            WHERE  s.status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter')
            and s.campusid = c.campusid AND s.admissioninclass = c.C_id
            AND c.C_id = ? AND c.campusid = ? and s.admissioninsection= ?
            AND sec.Sec_ID = ? and s.session = ?
        ", [$classid, $cid, $section, $section, $r->sessionid]);

        return view("admin.Reports.ReportStudentRegister", ["students" => $result, 'request' => $r]);
    }

    public function AllAttendenceRegister(Request $r)
    {
        $classid = $r->class;
        $section = $r->section;
        $cid = Auth::user()->campusid;
        $result = DB::select("
            SELECT DISTINCT(admissioninsection) FROM `studentinfo`
            WHERE admissioninclass = ? and campusid = ?
            and  status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter') and session = ?
        ", [$classid, $cid, $r->sessionid]);

        return view("admin.Reports.ReportAllStudentRegister", ["sectionss" => $result,  'request' => $r]);
    }

    public function ClassWiseStrength(Request $r)
    {
        $classid = $r->class;
        $section = $r->section;
        $cid = Auth::user()->campusid;
        $classes = DB::select("
        SELECT DISTINCT cw.ClassID, c.ClassName FROM `classwisesection` cw, studentinfo s, classes c
        WHERE s.status in ('Active') and cw.`isDisplay` = 1 AND cw.ClassID = c.C_id AND cw.campusid = ? AND s.admissioninclass = c.C_id and s.session = ?
        ", [$cid, $r->sessionid]);

        return view("admin.Reports.ReportClassWiseStrength", ["classes" => $classes,  'request' => $r]);
    }

    public function SingleBusRegister(Request $r)
    {
        $busnumber = $r->busnumber;
        $cid = Auth::user()->campusid;
        $student = DB::select("
            SELECT * FROM `studentinfo`
            WHERE status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter') and busnumber = ? AND campusid = ? and session = ?
        ", [$busnumber, $cid, $r->sessionid]);
        $employees = DB::select("
            SELECT * FROM `admins` WHERE busnumber = ? AND campusid = ?
        ", [$busnumber, $cid]);

        return view("admin.Reports.SingleBusRegister", ["students" => $student, 'emps' => $employees, 'request' => $r]);
    }

    public function AllBusRegister(Request $r)
    {
        $cid = Auth::user()->campusid;
        $buses = DB::select("
            SELECT * FROM `buses` WHERE campusid = ? AND busisdisplay = 1 ORDER BY busnumber
        ", [$cid]);

        return view("admin.Reports.AllBusRegister", ['buses' => $buses, 'request' => $r]);
    }

    public function SchoolLeavingCertificate(Request $r)
    {
        $stdid = $r->stdid;
        $campusid = Auth::user()->campusid;
        // DD("HELLO");

        $student = DB::select("
            SELECT  sr.date as admissiondate, s.studentid,c.classname,s.studentname,s.fathername,s.status,sr.admissioninclass
            FROM studentinfo s ,studentregistrations sr,classes c
            where sr.formid = s.formid
            and s.formid=sr.formid and s.campusid=sr.campusid and status='Slc'
            and c.campusid=sr.campusid and c.c_id=sr.admissioninclass
            and s.studentid= ? and s.campusid= ?
            GROUP by studentid
        ", [$stdid, $campusid]);

        return response()->json(json_encode($student));
    }

    public function MatriculatedStudents(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $session = $r->session;
        $students = DB::select("
            SELECT * FROM `studentinfo` si, classes cl, sections sec
            WHERE si.status = 'Matriculate' AND sec.Sec_ID = si.admissioninsection AND si.session = ?
            AND si.admissioninclass = cl.C_id AND si.campusid = cl.campusid AND si.campusid = ?
        ", [$session, $campusid]);

        return view("admin.Reports.MatriculatedStudents", ['students' => $students, 'request' => $r]);
    }

    public function SLCStudentsList(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $session = $r->session;
        $students = DB::select("
            SELECT * FROM `studentinfo` si, classes cl, sections sec
            WHERE si.status = 'Slc' AND sec.Sec_ID = si.admissioninsection AND si.session = ?
            AND si.admissioninclass = cl.C_id AND si.campusid = cl.campusid AND si.campusid = ?
        ", [$session, $campusid]);
        // dd($students);
        return view("admin.Reports.SLCStudentsList", ['students' => $students, 'request' => $r]);
    }

    public function SLCStudents(Request $r)
    {
        //  dd($r->input());
        $campusid = Auth::user()->campusid;
        $stdid = $r->student_id;
        // dd($session);
        $students = DB::select("
            SELECT * FROM `studentinfo` si, classes cl, sections sec
            WHERE si.status = 'Slc' AND sec.Sec_ID = si.admissioninsection
            AND si.admissioninclass = cl.C_id AND
            sec.campusid = si.campusid and
            si.campusid = cl.campusid AND si.campusid = ? and si.studentid=?
        ", [$campusid,$stdid]);
        // dd($students);
        return view("admin.Reports.SLCStudents", ['students' => $students, 'request' => $r]);
    }
}
