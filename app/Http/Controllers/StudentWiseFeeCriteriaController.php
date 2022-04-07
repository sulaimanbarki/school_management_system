<?php

namespace App\Http\Controllers;

use App\Models\StudentWiseFeeCriterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentWiseFeeCriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.StuedentWiseFeeCriteria');
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
            'studentid' => 'required',
            'scholarshipid' => 'required',
            'sequence' => 'required|integer|between:1,20',
            'allowedupto' => 'required|date',
        ]);
        $data_array = StudentWiseFeeCriterial::where('campusid', Auth::user()->campusid)->where('studentid', '=', $request->studentid)->where('scholarshipid', '=', $request->scholarshipid)->first();
        if (empty($data_array)) {
            $sss = new StudentWiseFeeCriterial();
            $sss->studentid = $request->studentid;
            $sss->campusid = Auth::user()->campusid;
            $sss->scholarshipid = $request->scholarshipid;
            $sss->sequence = $request->sequence;
            $sss->addedby = 2;
            $sss->allowedupto = $request->allowedupto;
            if ($sss->save()) {
                return response()->json(['result' => 'FeeHead is successfully added']);
            } else {
                return response()->json(['error' => 'Data is successfully added']);
            }
        } else {
            return "Error";
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
        $campusid = Auth::user()->campusid;
        $SWFC = DB::select("
        select swfc.id, sss.name, std.studentname, swfc.allowedupto, swfc.sequence 
        from `studentinfo` std, scholarships sss, studentwisefeecriterias swfc 
        where swfc.studentid = std.studentid and 
        swfc.scholarshipid = sss.id and swfc.campusid = ?
        ", [$campusid]);
        return response()->json(json_encode($SWFC));
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
    public function destroy(Request $request)
    {
        DB::table('studentwisefeecriterias')->where('id', $request->criteriadid)->delete();
        return "Class Deleted Successfully";
        exit;
    }
}
