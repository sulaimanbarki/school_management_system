<?php

namespace App\Http\Controllers;

use App\Models\addCampus;
use App\Models\schooleavingcirtificate;
use App\Models\StudentsComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentsCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(Request $r)
    {
        // dd($r->input());
        $r->validate([
            'classIdd' => 'required',
            'sectionIdd' => 'required',
            'studentIdd' => 'required',
            'StudentComment' => 'required|min:5|max:255',
        ]);

        $sss = new StudentsComment();
        $sss->studentid = $r->studentIdd;
        $sss->campusid = Auth::user()->campusid;
        $sss->date = date('Y-m-d');
        $sss->description = $r->StudentComment;
        $sss->classid = $r->classIdd;
        $sss->sectionid = $r->sectionIdd;
        if ($sss->save()) {
            return response()->json(['result' => 'FeeHead is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
        }
    }

    public function ViewConsessionComments(Request $r)
    {
        $id = $r->stdid;
        $cid = Auth::user()->campusid;
        $ommment = DB::select("
        SELECT comment FROM `feegenerations` WHERE `studentid` = ? AND comment IS NOT NULL and campusid = ?
        ", [$id, $cid]);
        return response()->json(json_encode($ommment));
    }

    public function ViewPromotionComments(Request $r)
    {
        $id = $r->stdid;
        $cid = Auth::user()->campusid;
        $ommment = DB::select("
        SELECT type FROM `promotion_status` WHERE `studentid` = ? and campusid = ?
        ", [$id, $cid]);
        return response()->json(json_encode($ommment));
    }

    public function CheckSLCStatus(Request $r)
    {
        $id = $r->stdid;
        $cid = Auth::user()->campusid;
        $status = schooleavingcirtificate::where('campusid', $cid)->where('studentid', $id)->get();
        return response()->json(json_encode($status));
    }

    public function CancelCertificate(Request $r)
    {
        $id = $r->stdid;
        $cid = Auth::user()->campusid;
        $status = schooleavingcirtificate::where('campusid', $cid)->where('studentid', $id)->where('id', $r->id)->update([
            'type' => 'Cancel'
        ]);
        return response()->json(json_encode($status));
    }

    public function show(Request $r)
    {
        $comment = StudentsComment::where('campusid', Auth::user()->campusid)->where('studentid', $r->stdid)->orderBy('date', 'DESC')->get();
        return response()->json(json_encode($comment));
        // dd($comment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentsComment  $studentsComment
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentsComment $studentsComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentsComment  $studentsComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentsComment $studentsComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentsComment  $studentsComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentsComment $studentsComment)
    {
        //
    }
}
