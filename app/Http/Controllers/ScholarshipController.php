<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\StudentWiseFeeCriterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.Scholarships');
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
    public function storeSWSH(Request $request)
    {
        $request->validate([
            'studentid' => 'required',
            'subheadid' => 'required',
            'issuedate' => 'required|date',
            'lastdate' => 'required|date|after:issuedate',
            'amount' => 'required|integer|between:0,100',
            'scholarshipid' => 'required',
            'academicsession' => 'required',
            'isactive' => 'required|in:Yes,No',
            'SWsequence' => 'required|integer|between:1,20',
        ]);

        $data_array = StudentWiseFeeCriterial::where('campusid', Auth::user()->campusid)
            ->where('subheadid', $request->subheadid)->where('scholarshipid', $request->scholarshipid)
            ->where('studentid', $request->studentid)->where('sessionid', $request->academicsession)->first();
        if (empty($data_array)) {
            $subhead = new StudentWiseFeeCriterial();
            $subhead->subheadid = $request->subheadid;
            $subhead->amountParentage = $request->amount;
            $subhead->studentid = $request->studentid;
            $subhead->campusid = Auth::user()->campusid;
            $subhead->scholarshipid = $request->scholarshipid;
            $subhead->sessionid = $request->academicsession;
            $subhead->issuedate = $request->issuedate;
            $subhead->lastdate = $request->lastdate;
            $subhead->sequence = $request->SWsequence;
            $subhead->isactive = $request->isactive;
            if ($subhead->save()) {
                return response()->json(['result' => 'FeeHead is successfully added']);
            } else {
                return response()->json(['error' => 'Data is successfully added']);
            }
        } else {
            return "Error";
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:255',
            'amount' => 'required|integer',
            'sequence' => 'required|integer|between:1,20',
            'isactive' => 'required|in:Yes,No',
            'date' => 'required',
            'description' => '',
        ]);

        $data_array = Scholarship::where('campusid', Auth::user()->campusid)->where('name', '=', $request->name)->first();
        if (empty($data_array)) {
            $fee = new Scholarship();
            $fee->name = $request->name;
            $fee->campusid = Auth::user()->campusid;
            $fee->amount = $request->amount;
            $fee->description = $request->description;
            $fee->isactive = $request->isactive;
            $fee->sequence = $request->sequence;
            $fee->date = $request->date;
            $fee->addedby = 1;
            if ($fee->save()) {
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
        $scholarship = Scholarship::where('campusid', Auth::user()->campusid)->get();
        return response()->json(json_encode($scholarship));
    }

    public function showSWSH()
    {
        $campusid = Auth::user()->campusid;
        // $scholarship = ScholarshipWiseSubheads::where('campusid', Auth::user()->campusid)->get();
        $scholarship = DB::select("
        select fh.subhead,s.name, sh.id, sh.amountparentage,sh.sequence,sh.isactive, sh.studentid, sh.issuedate, sh.lastdate,
        si.studentname, acc.id as accid, acc.session
        from studentscholarshipwisesubheads sh,configurations  c,scholarships s , feesubheads fh, studentinfo si, academicsessions acc
        where sh.campusid=c.campusid and sh.scholarshipid=s.id and sh.studentid = si.studentid and
        sh.campusid=s.campusid and s.campusid = ?
        and sh.campusid=fh.campusid and sh.subheadid=fh.id
        and acc.id = sh.sessionid
        ", [$campusid]);
        return response()->json(json_encode($scholarship));
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
            'name' => Rule::unique('scholarships')->where(function ($query) use ($request) {
                return $query->where('campusid', Auth::user()->campusid)->where('id', '<>', $request->id);
            }),
            'amount' => 'required|integer',
            'sequence' => 'required|integer|between:1,20',
            'isactive' => 'required|in:Yes,No',
            'date' => 'required',
            'description' => '',
        ]);

        $update = Scholarship::where('id', $request->input('id'))->update([
            'name' => $request->input('name'),
            'amount' => $request->input('amount'),
            'sequence' => $request->input('sequence'),
            'isactive' => $request->input('isactive'),
            'date' => $request->input('date'),
            'description' => $request->input('description'),
        ]);
        if ($update > 0) {
            return response()->json(['result' => 'Campus is successfully added']);
        } else {
            return response()->json(['error' => 'Error while Updating Schlorship']);
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

    public function destroySWSH(Request $request)
    {
        DB::table('studentwisefeecriterias')->where('id', $request->subheadid)->delete();
        return "Class Deleted Successfully";
        exit;
    }
}
