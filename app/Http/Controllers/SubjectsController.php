<?php

namespace App\Http\Controllers;

use App\Models\ClassWiseSubject;
use App\Models\Subject;
use App\Models\TermName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Subset;
use PhpParser\Node\Expr\Ternary;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.AddSubjects');
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
        $request->validate([
            'name' => 'required',
            'isdisplay' => 'required',
            'sequence' => 'required|integer|between:1,20',
        ]);

        $data_array = Subject::where('campusid', Auth::user()->campusid)->where('name', $request->name)->first();
        if (empty($data_array)) {
            $sss = new Subject();
            $sss->name = $request->name;
            $sss->date = date('Y-m-d');
            $sss->sequence = $request->sequence;
            $sss->campusid = Auth::user()->campusid;
            $sss->isdisplay = $request->isdisplay;
            if ($sss->save()) {
                return response()->json(['result' => 'FeeHead is successfully added']);
            } else {
                return response()->json(['error' => 'Data is successfully added']);
            }
        } else {
            return 'duplicate';
        }
    }

    public function AssignSubject(Request $request)
    {
        $request->validate([
            'subjectid' => 'required',
            'classid' => 'required',
            'transcriptsequence' => 'required|integer|between:1,20',
            'issdisplay' => 'required|boolean',
            'theorymarks' => 'required',
            'obtainmarks' => 'required',
            'passingmarks' => 'required',
        ]);

        $check = ClassWiseSubject::where('classid', $request->classid)
        ->where('subjectid', $request->subjectid)->where('campusid', Auth::user()->campusid)->first();
        if (!empty($check)) {
            echo 'duplicate';
            exit;
        }

        $sss = new ClassWiseSubject();
        $sss->classid = $request->classid;
        $sss->subjectid = $request->subjectid;
        $sss->isdisplay = $request->issdisplay;
        $sss->theorymarks = $request->theorymarks;
        $sss->practicalmarks = $request->obtainmarks;
        $sss->passingmarks = $request->passingmarks;
        $sss->transcriptsequence = $request->transcriptsequence;
        $sss->date = date('Y-m-d');
        $sss->campusid = Auth::user()->campusid;
        if ($sss->save()) {
            return response()->json(['result' => 'FeeHead is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
        }
    }

    public function AddTerm(Request $request)
    {
        $request->validate([
            'termname' => 'required',
            'sessionid' => 'required',
            'tsequence' => 'required|integer|between:1,20',
            'tisactive' => 'required|boolean',
            'tisdisplay' => 'required|boolean',
        ]);

        $check = TermName::where('campusid', Auth::user()->campusid)->where('termname', $request->termname)->where('sessionid', $request->sessionid)->first();
        if (!empty($check)) {
            echo "duplicate";
            exit;
        }


        $sss = new TermName();
        $sss->termname = $request->termname;
        $sss->sessionid = $request->sessionid;
        $sss->isdisplay = $request->tisdisplay;
        $sss->isactive = $request->tisactive;
        $sss->sequence = $request->tsequence;
        $sss->campusid = Auth::user()->campusid;
        if ($sss->save()) {
            return response()->json(['result' => 'FeeHead is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $subjects = Subject::where('campusid', Auth::user()->campusid)->get();
        return response()->json(json_encode($subjects));
    }

    public function ViewActiveSubject()
    {
        $subjects = Subject::where('campusid', Auth::user()->campusid)->where('isdisplay', 1)->get();
        return response()->json(json_encode($subjects));
    }

    public function ViewClassWiseSubjects()
    {
        $cid = Auth::user()->campusid;
        // $subjects = ClassWiseSubject::where('campusid', Auth::user()->campusid)->get();
        $subjects = DB::select("SELECT *, sub.id as subid, cws.id AS iddd FROM `classwisesubjects` cws, subjects sub, classes cl 
        WHERE cws.campusid = sub.campusid AND sub.campusid = cl.campusid AND cl.campusid = ? AND cws.classid = cl.C_id AND cws.subjectid = sub.id", [$cid]);
        return response()->json(json_encode($subjects));
    }

    public function ViewExamTerms()
    {
        // $terms = TermName::where('campusid', Auth::user()->campusid)->get();
        $terms = DB::select("
            SELECT *, tn.id as examtermid, acse.Session FROM `termnames` tn, academicsessions acse 
            WHERE tn.sessionid = acse.id AND tn.campusid = acse.CampusID AND tn.campusid = ?
        ",[Auth::user()->campusid]);
        return response()->json(json_encode($terms));
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
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'isdisplay' => 'required',
            'sequence' => 'required|integer|between:1,20',
        ]);

        $data_array = Subject::where('campusid', Auth::user()->campusid)->where('name', $request->name)->where('id', '<>', $request->input('id'))->first();
        if (empty($data_array)) {
            $update = Subject::where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'isdisplay' => $request->input('isdisplay'),
                'sequence' => $request->input('sequence'),
                'date' => date('Y-m-d'),
            ]);
    
            if ($update > 0) {
                return response()->json(['Save' => 'Subject is successfully Done']);
            } else {
                return response()->json(['error' => 'Error While Adding StudentRegistration']);
            }
        } else {
            return 'duplicate';
        }
    }

    public function UpdateExamTerm(Request $request)
    {
        $request->validate([
            'termname' => 'required',
            'sessionid' => 'required',
            'tsequence' => 'required|integer|between:1,20',
            'tisactive' => 'required|boolean',
            'tisdisplay' => 'required|boolean',
        ]);
        $check = TermName::where('campusid', Auth::user()->campusid)->where('termname', $request->termname)->where('sessionid', $request->sessionid)->where('id', '!=', $request->termid)->first();
        if (!empty($check)) {
            echo "duplicate";
            exit;
        }

        $update = TermName::where('id', $request->input('termid'))->update([
            'termname' => $request->input('termname'),
            'sessionid' => $request->input('sessionid'),
            'isdisplay' => $request->input('tisdisplay'),
            'isactive' => $request->input('tisactive'),
            'sequence' => $request->input('tsequence'),
            'sequence' => $request->input('tsequence'),
        ]);

        if ($update > 0) {
            return response()->json(['Save' => 'Subject is successfully Done']);
        } else {
            return response()->json(['error' => 'Error While Adding StudentRegistration']);
        }
    }
    public function UpdateClassWiseSubject(Request $request)
    {
        $request->validate([
            'CWid' => 'required',
            'subjectid' => 'required',
            'classid' => 'required',
            'transcriptsequence' => 'required|integer|between:1,20',
            'issdisplay' => 'required|boolean',
            'theorymarks' => 'required',
            'obtainmarks' => 'required',
            'passingmarks' => 'required',
        ]);

        $check = ClassWiseSubject::where('classid', $request->classid)->where('subjectid', $request->subjectid)
        ->where('campusid', Auth::user()->campusid)->where('id', '<>', $request->CWid)->first();
        if (!empty($check)) {
            echo 'duplicate';
            exit;
        }

        $update = ClassWiseSubject::where('id', $request->CWid)->update([
            'subjectid' => $request->input('subjectid'),
            'classid' => $request->input('classid'),
            'transcriptsequence' => $request->input('transcriptsequence'),
            'isdisplay' => $request->input('issdisplay'),
            'theorymarks' => $request->input('theorymarks'),
            'practicalmarks' => $request->input('obtainmarks'),
            'passingmarks' => $request->input('passingmarks'),
            'date' => $request->input('date'),
        ]);

        if ($update > 0) {
            return response()->json(['Save' => 'Subject is successfully Done']);
        } else {
            return response()->json(['error' => 'Error While Adding StudentRegistration']);
        }
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
