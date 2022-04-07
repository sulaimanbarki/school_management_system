<?php

namespace App\Http\Controllers;

use App\Models\FeeGeneration;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeeGenerationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.FeesGeneration');
    }

    public function PrintSlip()
    {
        return view('admin.printslip');
    }

    public function LoadEditFeePage()
    {
        return view('admin.EditFee');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //GetSectionClassWiseRequest $request
        //ViewStudentsClassANDsectionsWise
    }

    public function showAllStudents()
    {
        $campusid = Auth::user()->campusid;
        // $allStudents = StudentInfo::where('campusid', Auth::user()->campusid)->where('status', '!=', 'Slc')->get();
        $allStudents = DB::select(" 
        SELECT distinct (s.studentid),s.studentname,s.fathername,c.classname,
        sec.sectionname,s.transportstatus
        from studentinfo s inner join classwisesection cl
        on s.admissioninclass = cl.classid and s.campusid = cl.campusid
        inner join classes c on c.campusid=s.campusid and s.admissioninclass=c.c_id
        inner join sections sec on sec.campusid=s.campusid and s.admissioninsection=sec.sec_id
        and status!='slc'  
        and s.campusid=?
        group by s.studentid       
        ", [$campusid]);
        return response()->json(json_encode($allStudents));
    }
    public function ViewStudentsClassANDsectionsWise(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $ViewStudentsClassANDsectionsWise = DB::SELECT("
        SELECT distinct (s.studentid),s.studentname,s.fathername,c.classname,
        sec.sectionname,s.transportstatus
        from studentinfo s inner join classwisesection cl
        on 
        s.admissioninclass = cl.classid and s.campusid = cl.campusid
        inner join classes c on c.campusid=s.campusid and s.admissioninclass=c.c_id
        inner join sections sec on sec.campusid=s.campusid and s.admissioninsection=sec.sec_id
        and s.admissioninclass=? and status!='slc'   
        and s.campusid=? and s.admissioninsection=?
        group  by s.studentid

        ", [$request->classid, $campusid, $request->sectionid]);

        return response()->json(json_encode($ViewStudentsClassANDsectionsWise));
    }
    public function GetSectionClassWise(Request $request)
    {
        $campusid = Auth::user()->campusid;

        $ViewClasssWiseSection = DB::select("    
        SELECT distinct (s.sec_id) ,s.sectionname from classwisesection cw 
        inner join classes c
        on cw.classid=c.c_id inner join sections s on cw.sectionid=sec_id
        where cw.campusid=c.campusid and cw.campusid=s.campusid
        and cw.isdisplay=1 and cw.classid=?
        and s.campusid=?
        order by cw.sequence ASC
    ", [$request->classid, $campusid]);
        return response()->json(json_encode($ViewClasssWiseSection));
    }

    public function showClassWiseStudents(Request $request)
    {
        $campusid = Auth::user()->campusid;
        // $allStudents = StudentInfo::where('campusid', Auth::user()->campusid)->where('status', '!=', 'Slc')->where('admissioninclass', $request->classid)->get();
        // return response()->json(json_encode($allStudents));
        $allStudents = DB::SELECT("
            SELECT distinct (s.studentid),s.studentname,s.fathername,c.classname,
            sec.sectionname,s.transportstatus
            from studentinfo s inner join classwisesection cl
            on 
            s.admissioninclass = cl.classid and s.campusid = cl.campusid
            inner join classes c on c.campusid=s.campusid and s.admissioninclass=c.c_id
            inner join sections sec on sec.campusid=s.campusid and s.admissioninsection=sec.sec_id
            and s.admissioninclass=? and status!='slc'  
            and s.campusid=?
            group by s.studentid  ORDER BY sectionname
            ", [$request->classid, $campusid]);
        return response()->json(json_encode($allStudents));
    }

    public function showSingleStudent(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $studid = $request->studentid;
        // $allStudents = StudentInfo::where('campusid', Auth::user()->campusid)->where('studentid', $request->studentid)->get();
        $allStudents = DB::select("SELECT * from `studentinfo` si, classes cl, sections sec 
        where si.admissioninclass = cl.c_id and si.admissioninsection = sec.sec_id 
        and si.campusid = cl.campusid and si.campusid = sec.campusid and si.campusid = ? and si.studentid = ?
        ", [$campusid, $studid]);
        return response()->json(json_encode($allStudents));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
