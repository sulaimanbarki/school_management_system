<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\NetSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class NetSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.FeeGenerationStaff');
    }

    public function GenerateSalary(Request $r)
    {
        $count=0;
        $scaleID=0;
        $campusid = Auth::user()->campusid;
        $status='1';
        $grosssalary=0;
        $NetSalaryamount=0;
        // $date=
        // dd($r->monthfrom);
        $month=date("m",strtotime($r->monthfrom));
        $year=date("Y",strtotime($r->monthfrom));


        if($r->departmentid>0 && $r->section<1)
        {

            $staffCheckExist = DB::select("delete from net_salaries where ispaid=0 and month='$month'
            and year='$year' and empid  in(select id from admins where campusid='$campusid'
            and departmentid='$r->departmentid' and isactive='1' )
           ");
            // echo "departments";
        $staff = DB::select("
        SELECT  s.empid,a.name,sum(s.amount) as alwamount,a.departmentid,sb.amount as basicpay,
        sc.eobiamount as eobiamount  ,d.title,s.campusid,a.scaleid,sc.leaveamount,sc.leavestatus
        FROM staff_salary_details s, admins a,staff_basic_pay_salaries sb,scales sc,allowances aa,departments d
        where  d.id=a.departmentid and d.campusid=a.campusid and
        s.empid=a.id and a.campusid=s.campusid and sb.campusid=s.campusid and sb.empid=a.id and
        sc.campusid=s.campusid and a.scaleid=sc.id and type='PLUS'
        and aa.id=s.allowanceid and aa.campusid=s.campusid and  sc.campusid=aa.campusid
        and a.departmentid=? and a.campusid=? and a.isactive=?
        group by s.empid
        ",[$r->departmentid,$campusid,$status]);
        }else if($r->departmentid>0 && $r->section){

            $scaleID=$r->section;
            // echo "scale";
            $staffCheckExist = DB::select("delete from net_salaries where ispaid=0 and month='$month'
            and year='$year' and empid  in(select id from admins where campusid='$campusid'
            and departmentid='$r->departmentid' and isactive='1' and scaleid='$scaleID')
           ");


            $staff = DB::select("
            SELECT  s.empid,a.name,sum(s.amount) as alwamount,a.departmentid,sb.amount as basicpay,
            sc.eobiamount as eobiamount,a.scaleid,d.title,s.campusid,sc.leaveamount,sc.leavestatus
            FROM staff_salary_details s, admins a,staff_basic_pay_salaries sb,scales sc,allowances aa,departments d
            where  d.id=a.departmentid and d.campusid=a.campusid and
            s.empid=a.id and a.campusid=s.campusid and sb.campusid=s.campusid and sb.empid=a.id and
            sc.campusid=s.campusid and a.scaleid=sc.id and type='PLUS'
            and aa.id=s.allowanceid and aa.campusid=s.campusid and  sc.campusid=aa.campusid
            and a.departmentid=? and a.scaleid=? and a.campusid=? and a.isactive=?
            group by s.empid
            ",[$r->departmentid,$scaleID,$campusid,$status]);
            }else if($r->searchbystaffid>0){
            $scaleID=$r->section;
            // echo "scale";
            $staffCheckExist = DB::select("delete from net_salaries where ispaid=0 and month='$month'
            and year='$year' and empid  in(select id from admins where campusid='$campusid'
             and isactive='1' and  id='$r->searchEmployee')
           ");


            $staff = DB::select("
            SELECT  s.empid,a.name,sum(s.amount) as alwamount,a.departmentid,sb.amount as basicpay,
            sc.eobiamount as eobiamount,a.scaleid,d.title,s.campusid,sc.leaveamount,sc.leavestatus
            FROM staff_salary_details s, admins a,staff_basic_pay_salaries sb,scales sc,allowances aa,departments d
            where  d.id=a.departmentid and d.campusid=a.campusid and
            s.empid=a.id and a.campusid=s.campusid and sb.campusid=s.campusid and sb.empid=a.id and
            sc.campusid=s.campusid and a.scaleid=sc.id and type='PLUS'
            and aa.id=s.allowanceid and aa.campusid=s.campusid and  sc.campusid=aa.campusid
            and a.id=? and a.campusid=? and a.isactive=?
            group by s.empid
            ",[$r->searchEmployee,$campusid,$status]);
        }

            //  dd($staff);

            // dd($staff);

                $campusid=Auth::user()->campusid;
                $UserID=Auth::user()->id;
                 foreach ($staff as $StaffData) {

                $empid=$StaffData->empid;


                $staffDe = DB::select("
                SELECT  sum(amount) as ded_amount from staff_salary_details where
                type='MINUS' and campusid=? and empid=?
                ", [$campusid,$empid]);

                //   dd($staffDe);
                $scaleID=$StaffData->scaleid;
                $ScaleAmount=$StaffData->leaveamount;
                // echo $scaleID."     ";
                $scalestatusleave = DB::select("
                SELECT * FROM scales where campusid=?
                and id=? and leavestatus=1
                ",[$campusid,$scaleID]);

                    // echo $scalestatusleave[0]->id;

                //  dd($scalestatusleave);
                if(!empty($scalestatusleave)){
                    $staffLeave = DB::select("
                    SELECT count(distinct(date)) as totaldays,month(date) as month,year(date)
                    as year from staff_attendances
                    where campusid= ? and empid=? and month(date)=? and year(date)=?
                    ", [$campusid,$empid,$month,$year]);
                    $leaveamount=$staffLeave[0]->totaldays*$ScaleAmount;
                    // $leaveamount=123;
                }else{
                    $leaveamount=0;
                }
                // echo $leaveamount."   ";
                 $NetSalaryData = NetSalary::where('campusid', Auth::user()->campusid)
                 ->where('empid','=',$empid)
                 ->where('month','=',$month)
                 ->where('year','=',$year)->first();
                //  dd($NetSalaryData);

                // echo $leaveamount."  ";
                 if (empty($NetSalaryData)) {
                     $count++;
                        $NetSalary = new NetSalary();
                        $NetSalary->empid  = $StaffData->empid;
                        $NetSalary->eobiamount = $StaffData->eobiamount;
                        $NetSalary->basicpay = $StaffData->basicpay;

                        $grosssalary=$StaffData->basicpay+ $StaffData->alwamount;
                        $NetSalaryamount=$grosssalary-$staffDe[0]->ded_amount-$StaffData->eobiamount-$leaveamount;
                         $staffDe[0]->ded_amount;
                        if(empty($StaffData->alwamount) ){
                            $NetSalary->allowanceamount=0;
                        }else{
                            $NetSalary->allowanceamount = $StaffData->alwamount;
                        }

                        $NetSalary->bonusamount =0;
                        if(empty($staffDe[0]->ded_amount) ){
                            $NetSalary->deductionamount =0;
                        }else{
                            $NetSalary->deductionamount =$staffDe[0]->ded_amount;
                        }
                        $NetSalary->grosssalary = $grosssalary;
                        $NetSalary->leaveamount = $leaveamount;
                        $NetSalary->netsalary =$NetSalaryamount;
                        $NetSalary->campusid  = $StaffData->campusid;
                        $NetSalary->date = Date('Y-m-d');
                        $NetSalary->month =$month;
                        $NetSalary->year =$year;
                        $NetSalary->addedby =$UserID;
                        $NetSalary->save();
                    }
                }
                return response()->json(json_encode($count));




    }
























    public function showDepartmentWiseStaff(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $staff = DB::select("
            SELECT *, ad.name as empname, ad.id as empid, scale.name AS scalename FROM `admins` ad, departments dept, scales scale
            WHERE ad.departmentid = dept.id AND ad.campusid = dept.campusid
            AND ad.scaleid = scale.id AND ad.campusid = scale.campusid and
            ad.campusid = ? AND dept.id = ? and ad.isactive=1
        ", [$campusid, $r->departmentid]);
        return response()->json(json_encode($staff));
    }

    public function showDepartmentAndScaleWiseStaff(Request $r)
    {
        $deptandscalewisestaff = DB::SELECT("
            SELECT *, ad.name as empname, ad.id as empid, scale.name AS scalename FROM `admins` ad, departments dept, scales scale
            WHERE ad.departmentid = dept.id AND ad.campusid = dept.campusid
            AND ad.scaleid = scale.id AND ad.campusid = scale.campusid and
            ad.campusid = ? AND dept.id = ? AND scale.id = ?  and ad.isactive=1
        ", [Auth::user()->campusid, $r->departmentid, $r->scaleid]);

        return response()->json(json_encode($deptandscalewisestaff));
    }

    public function showSingleEmployee(Request $r)
    {
        $employee = DB::SELECT("
            SELECT *, ad.name as empname, ad.id as empid, scale.name AS scalename FROM `admins` ad, departments dept, scales scale
            WHERE ad.departmentid = dept.id AND ad.campusid = dept.campusid
            AND ad.scaleid = scale.id AND ad.campusid = scale.campusid and
            ad.campusid = ? AND ad.id = ?  and ad.isactive=1
        ", [Auth::user()->campusid, $r->empid]);

        return response()->json(json_encode($employee));
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
     * @param  \App\Models\NetSalary  $netSalary
     * @return \Illuminate\Http\Response
     */
    public function show(NetSalary $netSalary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NetSalary  $netSalary
     * @return \Illuminate\Http\Response
     */
    public function edit(NetSalary $netSalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NetSalary  $netSalary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NetSalary $netSalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NetSalary  $netSalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(NetSalary $netSalary)
    {
        //
    }
}
