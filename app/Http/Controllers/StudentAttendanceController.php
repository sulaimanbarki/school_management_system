<?php

namespace App\Http\Controllers;

use App\Models\ClassWiseTeacher;
use App\Models\Role;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Attendance()
    {
        return view('admin.StudentsAttendance');
    }

    public function saveAttendance(Request $r)
    {
        $id = $r->tableid;
        $attendence = $r->attendence;
        $description = $r->description;

        for ($i = 0; $i < count($id); $i++) {
            StudentAttendance::where('campusid', Auth::user()->campusid)->where('id', $id[$i])->update([
                'status' => $attendence[$i],
                'description' => $description[$i],
            ]);
        }

        return response('', 200);
    }

    // student attendance report 
    public function StudentAttendanceReportDateWise(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $sessionid = $r->sessionid;
        $date = $r->attendancedate;
        $campusid = Auth::user()->campusid;

        $result = DB::select("
        SELECT sa.id, cl.ClassName, sec.SectionName, sa.description, sa.studentid, sa.status, sa.date, si.studentname FROM `student_attendances` sa LEFT JOIN studentinfo si ON si.studentid = sa.studentid INNER JOIN classes cl ON si.admissioninclass = cl.C_id INNER JOIN sections sec ON sec.Sec_ID = si.admissioninsection WHERE cl.campusid = sa.classid AND sec.campusid = sa.campusid AND classid=? and sectionid=? and sa.campusid=? and sa.date=? and sa.campusid = si.campusid and sa.sessionid = ?
        ", [$classid, $sectionid, $campusid, $date, $sessionid]);
        // dd($result);
        return view('admin.Reports.ReportStudentAttendanceDateWise', ['students' => $result, 'request' => $r]);
    }

    // student attendance report counting between two dates
    public function StudentAttendanceReportCount(Request $r)
    {
        $classid = $r->class;
        $sectionid = $r->section;
        $sessionid = $r->sessionid;
        $fromdate = $r->fromdate;
        $todate = $r->todate;
        $campusid = Auth::user()->campusid;

        $result = DB::select("
        select (select COUNT(DISTINCT(sa1.date)) from student_attendances sa1 WHERE sa.studentid = sa1.studentid) AS 'Total', (select COUNT(DISTINCT(sa1.date)) from student_attendances sa1 WHERE sa.studentid = sa1.studentid and sa1.status = 'Present') AS 'Present', (select COUNT(DISTINCT(sa1.date)) from student_attendances sa1 WHERE sa.studentid = sa1.studentid and sa1.status = 'Absent') AS 'Absent',sa.studentid,ss.studentname,sa.date from student_attendances sa inner join studentinfo ss on sa.studentid=ss.studentid and ss.campusid=sa.campusid WHERE sa.date BETWEEN ? AND ? and sa.classid=? AND sa.sectionid=? and sa.sessionid = ? and sa.campusid = ? GROUP BY sa.studentid
        ", [$fromdate, $todate, $classid, $sectionid, $sessionid, $campusid]);
        // dd($result);
        return view('admin.Reports.ReportStudentAttendanceCount', ['students' => $result, 'request' => $r]);
    }

    public function fetchStudentForAttendance(Request $r)
    {
        $date = $r->date;
        $classid = $r->class;
        $sectionid = $r->section;
        $campusid = Auth::user()->campusid;
        $staffid = Auth::user()->id;
        $roleid = Auth::user()->roleid;

        $roleid = Role::where('campusid', $campusid)->where('Roleid', $roleid)->value('Role');

        if ($roleid == "Admin" or $roleid == "admin") {
            $result1 = DB::select("
        select s.studentid,s.campusid,s.admissioninclass,s.admissioninsection,s.session from
        studentinfo s where s.admissioninclass = ? and s.admissioninsection = ? and s.campusid = ?
        and status in('active') and studentid not in(select studentid from student_attendances sm
        where sm.classid=? and sm.sectionid=? and sm.campusid=? and date=?)
        ", [$classid, $sectionid, $campusid, $classid, $sectionid, $campusid, $date]);
        } else {
            $classid = ClassWiseTeacher::where('campusid', $campusid)->where('empid', $staffid)->value('classid');
            $sectionid = ClassWiseTeacher::where('campusid', $campusid)->where('empid', $staffid)->value('sectionid');
            $roleid = Auth::user()->roleid;


            $result1 = DB::select("
        select s.studentid,s.campusid,s.admissioninclass,s.admissioninsection,s.session from
        studentinfo s,class_wise_teachers c where
        c.classid=s.admissioninclass and c.sectionid=s.admissioninsection and
        c.campusid=s.campusid and
        s.admissioninclass = ? and s.admissioninsection = ?
        and s.campusid = ? and status in('active') and studentid
        not in(select studentid from student_attendances sm where
        sm.classid=? and sm.sectionid=? and  sm.campusid=? and date=?) and  c.empid=?
        ", [$classid, $sectionid, $campusid, $classid, $sectionid, $campusid, $date, $staffid]);
        }
        $i = 0;
        foreach ($result1 as $StudentData) {
            $check = StudentAttendance::where('studentid', $StudentData->studentid)
                ->where('campusid', Auth::user()->campusid)->where('classid', $classid)
                ->where('date', $date)
                ->where('sectionid', $sectionid)->first();
            if (empty($check)) {
                $reg = new StudentAttendance();
                $reg->studentid = $StudentData->studentid;
                $reg->campusid = Auth::user()->campusid;
                $reg->classid = $classid;
                $reg->sectionid = $sectionid;
                $reg->date  = $date;
                $reg->sessionid  = $StudentData->session;
                $reg->status = 1; // attempted status
                $reg->description = '';
                $reg->save();
                $i++;
            } else {
                echo "s";
            }
        }

        $result = DB::select("
        SELECT sa.id, sa.description, sa.studentid, sa.status, sa.date,
        si.studentname FROM `student_attendances` sa LEFT JOIN studentinfo si ON
        si.studentid = sa.studentid WHERE classid=? and sectionid=? and sa.campusid=?
        and sa.date=? and sa.campusid = si.campusid
        ", [$classid, $sectionid, $campusid, $date]);
        return response()->json(json_encode($result));
    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentAttendance $studentAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentAttendance  $studentAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentAttendance $studentAttendance)
    {
        //
    }
}
