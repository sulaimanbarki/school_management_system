<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffSalaryDetailsRequest;
use App\Models\StaffSalaryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffSalaryDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.StaffwiseFeesCriteria');
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
    public function store(StaffSalaryDetailsRequest $request)
    {
        $request->validated();
        $campusid = Auth::user()->campusid;

        $data_array = StaffSalaryDetail::where('campusid', $campusid)->where('empid', $request->employeeid)->where('allowanceid', $request->allowanceid)->first();
        if (empty($data_array)) {
            $ssd = new StaffSalaryDetail();
            $ssd->empid = $request->employeeid;
            $ssd->allowanceid = $request->allowanceid;
            $ssd->amount = $request->amount;
            $ssd->description = $request->description;
            $ssd->type = $request->type;
            $ssd->isactive = $request->isactive;
            $ssd->campusid = $campusid;
            $ssd->date = $request->date;
            $ssd->addedby = Auth::user()->id;
            if ($ssd->save()) {
                return response()->json(['result' => 'Data is successfully added']);
            } else {
                return response()->json(['error' => 'Data is successfully added']);
            }
        } else {
            echo 'duplicate';
            exit;
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
        // $des = Scale::where('campusid', $campusid)->get();
        $des = DB::select("
            SELECT ass.Session, staff.id as detailid, staff.isactive as staffisactive, ad.name as empname, allo.name as allowancename, allo.id as allowanceid, staff.amount as detailamount, staff.date as detailsdate, staff.type as stafftype, staff.description as staffdesc, staff.empid as empidd FROM `staff_salary_details` staff, admins ad, allowances allo, academicsessions ass WHERE staff.empid = ad.id AND staff.campusid = ad.campusid AND ass.id = allo.sessionid AND ass.CampusID = allo.campusid AND staff.allowanceid = allo.id AND staff.campusid = allo.campusid AND staff.campusid = ?
        ", [$campusid]);
        return response()->json(json_encode($des));
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
    public function update(StaffSalaryDetailsRequest $request)
    {
        $request->validated();
        $campusid = Auth::user()->campusid;
        $data_array = StaffSalaryDetail::where('campusid', $campusid)->where('empid', $request->employeeid)->where('allowanceid', $request->allowanceid)->where('id', '<>', $request->input('staffwisefeeid'))->first();
        if (empty($data_array)) {
            $jobs = StaffSalaryDetail::where('campusid', $campusid)->where('id', $request->input('staffwisefeeid'))->update([
                'empid' => $request->input('employeeid'),
                'allowanceid' => $request->input('allowanceid'),
                'amount' => $request->input('amount'),
                'description' => $request->input('description'),
                'isactive' => $request->input('isactive'),
                'type' => $request->input('type'),
                'date' => $request->input('date'),
                'addedby' => Auth::user()->id,
            ]);
        } else {
            echo 'duplicate';
            exit;
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
