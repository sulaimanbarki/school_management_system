<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeeReports extends Controller
{
    public function index()
    {
        return view('admin.Reports.FeeReports');
    }

    public function Outstanding(Request $r)
    {
        $fromdate = date('Y-m', strtotime($r->fromdate));
        $fromdate .= '-01';
        $todate = date('Y-m', strtotime($r->todate));
        $todate .= '-31';
        $cid = Auth::user()->campusid;

        $classes = DB::select("
        SELECT distinct f.studentid, fh.subhead, si.studentname, c.classname, f.month, f.year, s.sectionname,
        sum(feeamount) as sum from `feegenerations` f, classes c, sections s, studentinfo si, feesubheads fh
        where si.status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter') and ispaid = 0 and c.c_id = f.classid and s.sec_id = f.sectionid and fh.id = f.subheadid AND fh.campusid = f.campusid
        and si.studentid = f.studentid and f.campusid = si.campusid and f.campusid = ?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month) >= ?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month) <= ?
        group by f.studentid, f.month, f.subheadid order by c.classname, f.studentid,
        date_add(makedate(f.year, f.month), interval (f.month)-1 month), c.sequence, s.sectionsequence
        ", [$cid, $fromdate, $todate]);
        // DATE_ADD(DATE_ADD(MAKEDATE(GF.year, 1), INTERVAL (GF.month) - 1 MONTH), INTERVAL (5)-1 DAY)
        return view('admin.Reports.FeeReportOutstanding', ['request' => $r, 'classes' => $classes]);
    }

    public function OutstandingPaid(Request $r)
    {
        $fromdate = date('Y-m', strtotime($r->fromdate));
        $fromdate .= '-01';
        $todate = date('Y-m', strtotime($r->todate));
        $todate .= '-31';
        $cid = Auth::user()->campusid;
        $classes = DB::select("
        SELECT distinct f.studentid, fh.subhead, si.studentname, c.classname, f.month, f.year, s.sectionname,
        sum(feeamount) as sum from `feegenerations` f, classes c, sections s, studentinfo si, feesubheads fh
        where si.status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter') and ispaid = 1 and c.c_id = f.classid and s.sec_id = f.sectionid and fh.id = f.subheadid AND fh.campusid = f.campusid
        and si.studentid = f.studentid and f.campusid = si.campusid and f.campusid = ?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month) >= ?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month) <= ?
        group by f.studentid, f.month, f.subheadid order by c.classname, f.studentid,
        date_add(makedate(f.year, f.month), interval (f.month)-1 month), c.sequence, s.sectionsequence
        ", [$cid, $fromdate, $todate]);
        return view('admin.Reports.FeeReportOutstandingPaid', ['request' => $r, 'classes' => $classes]);
    }

    public function ClassWiseOutstanding(Request $r)
    {
        $fromdate = date('Y-m', strtotime($r->fromdate));
        $fromdate .= '-01';
        $todate = date('Y-m', strtotime($r->todate));
        $todate .= '-31';
        $cid = Auth::user()->campusid;
        $classid = $r->class;
        $classes = DB::select("
        SELECT distinct f.studentid, si.studentname, c.classname, f.month, f.year, s.sectionname, sum(feeamount) as sum from `feegenerations` f, classes c, sections s, studentinfo si
        where si.status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter') and ispaid = 0 and c.c_id = f.classid and s.sec_id = f.sectionid and si.studentid = f.studentid and f.campusid = si.campusid and f.campusid = ?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month) >= ?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month) <= ?
        and f.classid = ?
        group by f.studentid, f.month order by c.classname, f.studentid, date_add(makedate(f.year, f.month), interval (f.month)-1 month), c.sequence, s.sectionsequence
        ", [$cid, $fromdate, $todate, $classid]);
        return view('admin.Reports.FeeReportClassWiseOutstanding', ['request' => $r, 'classes' => $classes]);
    }

    public function ClassAndSectionWiseOutstanding(Request $r)
    {
        $fromdate = date('Y-m', strtotime($r->fromdate));
        $fromdate .= '-01';
        $todate = date('Y-m', strtotime($r->todate));
        $todate .= '-31';
        $cid = Auth::user()->campusid;
        $classid = $r->class;
        $sectionid = $r->section;
        $classes = DB::select("
        SELECT distinct f.studentid, si.studentname, c.classname, f.month, f.year, s.sectionname, sum(feeamount) as sum from `feegenerations` f, classes c, sections s, studentinfo si
        where si.status in('Active', 'stuckoff_absences', 'stuckoff_feeDefluter') and ispaid = 0 and c.c_id = f.classid and s.sec_id = f.sectionid and si.studentid = f.studentid and f.campusid = si.campusid and f.campusid = ?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month) >= ?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month) <= ?
        and f.classid = ? and f.sectionid = ?
        group by f.studentid, f.month order by c.classname, f.studentid, date_add(makedate(f.year, f.month), interval (f.month)-1 month), c.sequence, s.sectionsequence
        ", [$cid, $fromdate, $todate, $classid, $sectionid]);
        return view('admin.Reports.FeeReportClassAndSectionWiseOutstanding', ['request' => $r, 'classes' => $classes]);
    }

    public function HeadWiseFeeReports(Request $r)
    {
        $fromdate = $r->fromdate;
        $todate = $r->todate;
        $cid = Auth::user()->campusid;
        $classes = DB::select("
        SELECT DISTINCT fh.subhead, sum(f.feeamount) as summ FROM `feegenerations` f, feesubheads fh where f.subheadid = fh.id and f.campusid = fh.campusid and ispaid = 1 AND recievedate >= ? and recievedate <= ? and f.campusid = fh.campusid and f.campusid = ? GROUP by fh.subhead
        ", [$fromdate, $todate, $cid]);
        return view('admin.Reports.HeadWiseFeeReports', ['request' => $r, 'classes' => $classes]);
    }
}
