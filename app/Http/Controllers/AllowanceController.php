<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllowanceRequest;
use App\Models\AdvanceSalary;
use App\Models\Allowance;
use App\Models\Scale;
use App\Models\StaffBasicPaySalary;
use App\Models\StaffSalaryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AllowanceController extends Controller
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
    public function store(AllowanceRequest $request)
    {
        $request->validated();
        $data_array = Allowance::where('campusid', Auth::user()->campusid)->where('name', $request->allowancename)->where('sessionid', $request->allownaceacademinsession)->where('scaleid', $request->allowancescale)->first();
        if (empty($data_array)) {
            $allow = new Allowance();
            $allow->name = $request->allowancename;
            // $allow->amount = $request->allawanceamount;
            $allow->amount = 1;
            // $allow->eobiamount = $request->eobiamount;
            $allow->allowancetype = $request->allowancetype;
            $allow->sessionid = $request->allownaceacademinsession;
            $allow->description = $request->allowancedescription;
            $allow->scaleid = $request->allowancescale;
            $allow->campusid = Auth::user()->campusid;

            if ($allow->save()) {
                return response()->json(['result' => 'Employee is successfully added']);
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
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // $allowances = Allowance::where('campusid', Auth::user()->campusid)->get();

        // $allowances = DB::table('allowances')->join('scales', 'allowances.scaleid', '=', 'scales.id')->select()->get();
        $allowances = DB::select("SELECT *, al.id as allowanceid, al.name  as allowancename, sc.name as scalename, al.description as AllowanceDescription FROM `allowances` al, scales sc, academicsessions acs
        WHERE acs.campusid = al.campusid and acs.id = al.sessionid and al.scaleid = sc.id AND al.campusid = sc.campusid AND al.campusid = ?", [Auth::user()->campusid]);
        return response()->json(json_encode($allowances));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function edit(Allowance $allowance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function update(AllowanceRequest $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validated();
        $data_array = Allowance::where('campusid', $campusid)->where('name', $request->scalename)->where('id', '<>', $request->input('allowanceid'))->first();
        if (empty($data_array)) {
            $jobs = Allowance::where('campusid', $campusid)->where('id', $request->input('allowanceid'))->update([
                'name' => $request->input('allowancename'),
                // 'amount' => $request->input('allawanceamount'),
                'amount' => 1,
                // 'eobiamount' => $request->input('eobiamount'),
                'allowancetype' => $request->input('allowancetype'),
                'description' => $request->input('allowancedescription'),
                'scaleid' => $request->input('allowancescale'),
                'sessionid' => $request->input('allownaceacademinsession'),
            ]);
        } else {
            echo 'duplicate';
            exit;
        }
    }

    public function ChechAdvanceSalry(Request $r){
        $empid=$r->employeeidadvancesalary;

        $ScaleAmount=0;
        $scaleID=0;
        $month = date("m",strtotime($r->advancesalarydate));
        $year = date("Y",strtotime($r->advancesalarydate));
        // dd($month);
        $val = DB::select("
        SELECT sum(debitamount) as debitamount FROM `advance_salaries`
        WHERE YEAR(date) =? AND MONTH(`date`) = ? and empid = ?
        and campusid = ?
        ", [$year, $month,$empid, Auth::user()->campusid]);

        $advancePaid = (int)$val[0]->debitamount;
        //    dd($advancePaid);
        // fetch emp salary allowances + basicpay
            // dd($advancePaid);
        $campusid= Auth::user()->campusid;


        $getScaleId = DB::select("
            select  scaleid from admins where id = ? and campusid = ?
        ", [$empid, $campusid]);
            // dd($getScaleId);
        $scaleID=$getScaleId[0]->scaleid;
        // dd($scaleID);
        $basicpay = StaffBasicPaySalary::where('empid', $r->employeeidadvancesalary)->value('amount');
        // dd($basicpay);
        $eobi = Scale::where('id', $scaleID)->value('eobiamount');
        //  dd($eobi);
        $allowancesSum = StaffSalaryDetail::where('campusid', Auth::user()->campusid)
        ->where('empid', $r->employeeidadvancesalary)
        ->where('type','PLUS')
        ->where('isactive','1')->sum('amount');
        // dd($allowancesSum);
        $ded_amount = StaffSalaryDetail::where('campusid', Auth::user()->campusid)
        ->where('empid', $r->employeeidadvancesalary)
        ->where('type','MINUS')
        ->where('isactive','1')->sum('amount');

        //  dd($ded_amount);
        $total = $basicpay + $allowancesSum-$eobi-$ded_amount;
        //  dd($total);

        $scalestatusleave = DB::select("
        SELECT * FROM scales where campusid=? and id=? and leavestatus=1
        ",[$campusid,$scaleID]);

            // echo $scalestatusleave[0]->id;

        //  dd($scalestatusleave);
        if(!empty($scalestatusleave)){
            $staffLeave = DB::select("
            SELECT count(distinct(date)) as totaldays,month(date) as month,year(date)
            as year from staff_attendances
            where campusid= ? and empid=? and month(date)=? and year(date)=?
            ", [$campusid,$empid,$month,$year]);
        //  dd($staffLeave);
            $leaveamount=$staffLeave[0]->totaldays*$scalestatusleave[0]->leaveAmount;
            //  dd($leaveamount);
            // $leaveamount=123;
        }else{
            $leaveamount=0;
        }
        // dd($leaveamount);
        $limit = $total - $advancePaid-$leaveamount;

        //    dd($limit);
        if($r->debitamount > $limit){
            echo 'larger';
            exit;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Allowance $allowance)
    {
        //
    }
}
