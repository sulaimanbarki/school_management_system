<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffProfile extends Controller
{
    public function index(){
        return view('admin.StaffProfile');
    }

    public function LoadStaffInfo(Request $r)
    {
        $stdid = $r->stdid;
        $student = DB::select("
            SELECT *, ad.name as adminname, ad.id as adminid, sc.name as scalename FROM `admins` ad, departments dep, scales sc, configurations com
            WHERE ad.departmentid = dep.id AND ad.campusid = dep.campusid
            AND ad.scaleid = sc.id AND ad.campusid = sc.campusid
            AND ad.campusid = com.campusid AND ad.id = ? and ad.campusid = ?
        ", [$stdid, Auth::user()->campusid]);
        return response()->json(json_encode($student));
    }

    public function LoadStaffAllowances(Request $r)
    {
        $stdid = $r->stdid;
        $student = DB::select("
            SELECT *, ssd.amount as staffwiseamount FROM `staff_salary_details` ssd, allowances al
            WHERE ssd.allowanceid = al.id AND ssd.campusid = al.campusid and ssd.isactive = 1
            AND ssd.campusid = ? AND ssd.empid = ?
        ", [Auth::user()->campusid, $stdid]);
        return response()->json(json_encode($student));
    }

    public function LoadAdvanceSalary(Request $r)
    {
        $empid = $r->stdid;
        $month = date('m');
        $year = date('Y');
        $student = DB::select("
            SELECT * FROM `advance_salaries` WHERE empid = ? and month(date) = ? and year(date) = ? and status = 1 and campusid = ?
        ", [$empid, $month, $year, Auth::user()->campusid]);
        return response()->json(json_encode($student));
    }

    public function TotalSalaryPaid(Request $r)
    {
        $empid = $r->stdid;
        $student = DB::select("
            SELECT * FROM `advance_salaries` WHERE empid = ? and status = 1 and campusid = ?
        ", [$empid, Auth::user()->campusid]);
        return response()->json(json_encode($student));
    }

    public function FetchStaffSalaries(Request $r)
    {
        $month = (int)date("m", strtotime($r->date));
        $year = (int)date("Y", strtotime($r->date));
        $salary = DB::select("
            SELECT  n.empid,a.name as empname,a.departmentid , d.title,n.campusid,n.eobiamount,
            n.basicpay,n.allowanceamount,
            n.deductionamount,n.basicpay
            ,n.grosssalary,n.netsalary,n.year,n.month,n.leaveamount
            FROM net_salaries n, admins a,scales sc,departments d where  d.id=a.departmentid
            and d.campusid=a.campusid and n.empid=a.id and a.campusid=n.campusid and
            sc.campusid=n.campusid and a.scaleid=sc.id and a.campusid = ? and a.isactive = 1
            and month = ? and year = ?
            group by n.empid,year,month;
        ", [Auth::user()->campusid, $month, $year]);
        return response()->json(json_encode($salary));
    }

    public function FetchStaffDeductionsAndAllowances(Request $r)
    {
        $empid = $r->staffid;
        $month = (int)date("m", strtotime($r->date));
        $year = (int)date("Y", strtotime($r->date));
        $salary = DB::select("
        SELECT ssd.amount as allowanceamount, al.allowancetype as type, al.name as name FROM `staff_salary_details` ssd,
        allowances al WHERE al.id = ssd.allowanceid and al.campusid = ssd.campusid
        AND ssd.empid = ? and ssd.campusid = ? and type='PLUS' and isactive=1;
        ", [$empid,  Auth::user()->campusid]);

        //  dd($salary);

        return response()->json(json_encode($salary));
    }
}
