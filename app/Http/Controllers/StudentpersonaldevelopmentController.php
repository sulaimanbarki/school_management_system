<?php

namespace App\Http\Controllers;

use App\Models\PersonalDevelopment;
use App\Models\PersonalDevelopmentStore;
use App\Models\studentpersonaldevelopment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class StudentpersonaldevelopmentController extends Controller
{
    public function index()
    {
        return view('admin.Examination.PersonalDevelopment');
    }

    public function AddPersonalDevelopment(Request $request)
    {
        $request->validate([
            'pname' => 'required',
            'date' => 'required',
        ]);

        $campusid = Auth::user()->campusid;
        $data_array = PersonalDevelopment::where('campusid', $campusid)->where('pname', $request->pname)->first();
        if (empty($data_array)) {
            $sss = new PersonalDevelopment();
            $sss->pname = $request->pname;
            $sss->date = $request->date;
            $sss->campusid = Auth::user()->campusid;
            if ($sss->save()) {
                return response()->json(['result' => 'FeeHead is successfully added']);
            } else {
                return response()->json(['error' => 'Data is successfully added']);
            }
        } else {
            echo 'duplicate';
            exit;
        }
    }

    public function ViewPersonalDevelopment()
    {
        $vpd = PersonalDevelopment::where('campusid', Auth::user()->campusid)->get();
        return response()->json(json_encode($vpd));
    }

    public function UpdatePersonalDevelopment(Request $request)
    {
        $request->validate([
            'pname' => Rule::unique('personal_developments')->where(function ($query) use ($request) {
                return $query->where('campusid', Auth::user()->campusid)->where('id', '<>', $request->id);
            }),
            // 'pname' => 'required|unique:personal_developments,pname,' . $request->id . ',id',
            'date' => 'required',
        ]);



        $update = PersonalDevelopment::where('id', $request->input('id'))->update([
            'pname' => $request->input('pname'),
            'date' => $request->input('date'),
        ]);

        if ($update > 0) {
            return response()->json(['Save' => 'Subject is successfully Done']);
        } else {
            return response()->json(['error' => 'Error While Adding StudentRegistration']);
        }
    }

    public function FetchPersonalDevelopment(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $classId = $r->classId;
        $subjects = DB::select("
        select * from `studentpersonaldevelopments` spd, personal_developments pd where spd.campusid = pd.campusid 
        and spd.campusid = ? and spd.classid = ? and spd.pdid = pd.id and spd.isactive = 1
        ", [$campusid, $classId]);

        return response()->json(json_encode($subjects));
    }


    public function AssignPDT(Request $request)
    {
        $request->validate([
            'classid' => 'required',
            'pdid' => 'required',
            'isactive' => 'required|boolean',
            'status' => 'required|in:Active,InActive',
            'sequence' => 'required|integer|between:1,20',
            'date' => 'required',
        ]);

        $check = studentpersonaldevelopment::where('classid', $request->classid)->where('pdid', $request->pdid)->where('campusid', Auth::user()->campusid)->first();
        if (!empty($check)) {
            echo 'duplicate';
            exit;
        }

        $sss = new studentpersonaldevelopment();
        $sss->classid = $request->classid;
        $sss->pdid = $request->pdid;
        $sss->isactive = $request->isactive;
        $sss->status = $request->status;
        $sss->sequence = $request->sequence;
        $sss->date = $request->date;
        $sss->campusid = Auth::user()->campusid;
        if ($sss->save()) {
            return response()->json(['result' => 'FeeHead is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
        }
    }

    public function ViewCWPDT()
    {
        $cid = Auth::user()->campusid;
        // $subjects = ClassWiseSubject::where('campusid', Auth::user()->campusid)->get();
        $subjects = DB::select("select *, spd.id as iddd from `studentpersonaldevelopments` spd, personal_developments pd, classes cl 
        where spd.campusid = pd.campusid and pd.campusid = cl.campusid and cl.campusid = ? and spd.classid = cl.c_id and spd.pdid = pd.id
        ",[$cid]);
        return response()->json(json_encode($subjects));
    }

    public function UpdateClassWisePD(Request $request)
    {
        $request->validate([
            'CWid' => 'required',
            'pdid' => 'required',
            'classid' => 'required',
            'isactive' => 'required|boolean',
            'status' => 'required|in:Active,InActive',
            'date' => 'required',
            'sequence' => 'required|integer|between:1,20',
        ]);

        $check = studentpersonaldevelopment::where('classid', $request->classid)->where('pdid', $request->pdid)->where('campusid', Auth::user()->campusid)->where('id', '<>', $request->CWid)->first();
        if (!empty($check)) {
            echo 'duplicate';
            exit;
        }

        $update = studentpersonaldevelopment::where('id', $request->CWid)->update([
            'pdid' => $request->input('pdid'),
            'classid' => $request->input('classid'),
            'sequence' => $request->input('sequence'),
            'isactive' => $request->input('isactive'),
            'status' => $request->input('status'),
            'date' => $request->input('date'),
        ]);

        if ($update > 0) {
            return response()->json(['Save' => 'Subject is successfully Done']);
        } else {
            return response()->json(['error' => 'Error While Adding StudentRegistration']);
        }
    }

    public function FetchStudentsForPersonalDevelopment(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $sectionid = $r->sectionid;
        $classid = $r->classid;
        $Pd_id = $r->Pd_id;
        $sessionID = $r->sessionID;
        $termID = $r->termID;

        if ($sessionID < 1) {
            $sessionID = null;
        } else if ($termID < 1) {
            $termID = null;
        }
        $result1 = DB::select("
        select s.studentid,s.campusid,s.admissioninclass,
        s.admissioninsection, cl.*,p.*
        from
        studentinfo s,studentpersonaldevelopments 
        cl,personal_developments p where
        s.admissioninclass = cl.classid and
        s.campusid=cl.campusid and p.id=cl.pdid and p.campusid=cl.campusid and
        s.admissioninclass = ? and 
        s.admissioninsection = ? 
        and cl.pdid  = ?
        and s.campusid = ? and s.status in('active')
        ", [$classid, $sectionid, $Pd_id, $campusid]);
        // print_r($result);
        // $counter = count($result);
        // dd($result1);
        foreach ($result1 as $StudentData) {
            $check = PersonalDevelopmentStore::where('studentid', $StudentData->studentid)
                ->where('campusid', Auth::user()->campusid)->where('classid', $classid)
                ->where('sectionid', $sectionid)->where('termid', $termID)->where('sessionid', $sessionID)
                ->where('pdid', $Pd_id)->first();
            if (empty($check)) {
                $reg = new PersonalDevelopmentStore();
                $reg->pdid = $StudentData->pdid;
                $reg->termid = $termID;
                $reg->sessionid = $sessionID;
                $reg->sectionid = $StudentData->admissioninsection;
                $reg->studentid = $StudentData->studentid;
                $reg->campusid = Auth::user()->campusid;
                $reg->classid = $classid;
                $reg->comment = "";
                $reg->date = date('Y-m-d');
                $reg->isdisplay = 1;
                $reg->sequence = 1;
                $reg->save();
            }
        }

        // make a query here...
        // $result = DB::select("
        // SELECT  s.studentid,s.studentname,s.campusid,s.admissioninclass,s.admissioninsection,cl.subjectid,
        // cl.theorymarks,cl.practicalmarks,obtain_marks_theory,obtain_marks_practical,sm.termid,sm.sessionid, sm.isAbsenct_theory, sm.isAbsenct_practical
        // from studentinfo s,classwisesubjects cl,studentmarks sm WHERE s.admissioninclass=cl.classid
        // and
        // s.admissioninclass='$classid' and s.admissioninsection='$sectionid'  and
        // s.campusid=cl.campusid and sm.campusid=s.campusid and cl.classid=sm.classid
        // and cl.subjectid='$subjectid'
        // and s.campusid='$campusid' and status in('Active') and termid='$termID' 
        // and sessionid='$sessionID'
        // and sm.studentid=s.studentid and sm.subjectid=cl.subjectid
        // ");
        $result = DB::select("
        select pd.*, s.studentname, s.fathername from `personal_development_stores` pd, studentinfo s where 
        s.studentid = pd.studentid 
        and s.campusid = pd.campusid and pd.campusid = ? and
        pd.termid = ? and pd.classid = ? and pd.sectionid = ? and pd.sessionid = ? and pd.pdid = ?
        ", [$campusid, $termID, $classid, $sectionid, $sessionID, $Pd_id]);
        return response()->json(json_encode($result));
    }

    public function AddStudentPersonalDevelopment(Request $r)
    {
        $sessionid = $r->sessionid;
        $termid = $r->termid;
        $classid = $r->classid;
        $sectionid = $r->sectionid;
        $studentid = $r->studentid;
        $pdid = $r->pdid;
        $comment = $r->comment;
        $counter = count($r->comment);

        for ($i = 0; $i < $counter; $i++) {
            PersonalDevelopmentStore::where('pdid', $r->pdid[$i])
                ->where('campusid', Auth::user()->campusid)
                ->where('termid', $termid[$i])->where('sessionid', $sessionid[$i])
                ->where('classid', $classid[$i])->where('sectionid', $sectionid[$i])
                ->where('studentid', $studentid[$i])->update([
                    'comment' => $r->comment[$i],
                    'date' => date('Y-m-d'),
                ]);
        }
    }
}
