<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SMSRemainder extends Controller
{
    public function index()
    {
        return view('admin.Remainders.SMSRemainder');
    }

    public function FetchStudentsForRemainder(Request $r)
    {
        $cid = Auth::user()->campusid;
        $classid = $r->classId;
        $res = DB::select("
            select studentid,studentname,classname,sectionname, fathercontact from  classes c, sections s, studentinfo si where
            c.c_id=si.admissioninclass and s.sec_id=si.admissioninsection and s.campusid=si.campusid and c.campusid=si.campusid
            and si.campusid=? and si.admissioninclass= ?
            order by si.admissioninclass,si.admissioninsection,studentid asc;
        ", [$cid, $classid]);

        return response()->json(json_encode($res));
    }

    public function FetchStudentsForRemainderClassAndSection(Request $r)
    {
        $cid = Auth::user()->campusid;
        $classid = $r->classid;
        $sectionid = $r->sectionid;
        $res = DB::select("
            select studentid,studentname,classname,sectionname, fathercontact from  classes c, sections s, studentinfo si where
            c.c_id=si.admissioninclass and s.sec_id=si.admissioninsection and s.campusid=si.campusid and c.campusid=si.campusid
            and si.campusid= ? and si.admissioninclass= ? and si.admissioninsection = ?
            order by si.admissioninclass,si.admissioninsection,studentid asc;
        ", [$cid, $classid, $sectionid]);

        return response()->json(json_encode($res));
    }

    public function SMSRemainderWhole(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $classid = $r->classIdd;
        $sectionid = $r->sectionIdd;

        $datefrom = date('Y-m', strtotime($r->DateFrom));
        $datefrom .= '-01';
        $dateto = date('Y-m', strtotime($r->DateTo));
        $dateto .= '-31';

        // dd($datefrom);
        $res = "";
        if ($classid and $sectionid) {
            $res = DB::select("
            select f.studentid, si.studentname, c.classname, s.sectionname, COUNT(DISTINCT f.month, f.year) as monthcount from studentinfo si, `feegenerations` f, classes c, sections s where f.ispaid = 0 and f.description != 'Reversed' and c.c_id = f.classid and s.sec_id = f.sectionid and si.studentid = f.studentid and si.admissioninclass= ? and si.admissioninsection= ? and 
            date_add(makedate(f.year, f.month), interval (f.month)-1 month) >= ? and date_add(makedate(f.year, f.month), interval (f.month)-1 month) <= ? and f.campusid = si.campusid and f.campusid = ? group by f.studentid order by studentid asc
            ", [$classid, $sectionid, $datefrom, $dateto, $campusid]);
        } else {
            // COUNT(f.month)
            $res = DB::select("
            select f.studentid, si.studentname, c.classname, s.sectionname, COUNT(DISTINCT f.month, f.year) as monthcount from studentinfo si, `feegenerations` f, classes c, sections s where f.ispaid = 0 and f.description != 'Reversed' and c.c_id = f.classid and s.sec_id = f.sectionid and si.studentid = f.studentid and si.admissioninclass= ? and date_add(makedate(f.year, f.month), interval (f.month)-1 month) >= ? and date_add(makedate(f.year, f.month), interval (f.month)-1 month) <= ? and f.campusid = si.campusid and f.campusid = ? group by f.studentid order by studentid asc
            ", [$classid, $datefrom, $dateto, $campusid]);

        }
        if (empty($res))
            return abort(404);

        return view('admin.Remainders.SMSRemainderWhole', ['students' => $res, 'request' => $r]);
    }

    public function StruckOffRemainder(Request $r)
    {
        // dd($r);
        $campusid = Auth::user()->campusid;
        $classid = $r->formClass;
        $sectionid = $r->formSection;
        $datefrom = date('Y-m', strtotime($r->datefrom));
        $datefrom .= '-01';
        $dateto = date('Y-m', strtotime($r->dateto));
        $dateto .= '-31';

        // dd($r->dateto);

        $res = "";
        if ($classid and $sectionid) {
            $res = DB::select("
            select f.studentid, si.studentname, c.classname, s.sectionname, COUNT(DISTINCT f.month, f.year) as monthcount from studentinfo si, `feegenerations` f, classes c, sections s where f.ispaid = 0 and f.description != 'Reversed' and c.c_id = f.classid and s.sec_id = f.sectionid and si.studentid = f.studentid and si.admissioninclass= ? and si.admissioninsection= ? and 
            date_add(makedate(f.year, f.month), interval (f.month)-1 month) >= ? and date_add(makedate(f.year, f.month), interval (f.month)-1 month) <= ? and f.campusid = si.campusid and f.campusid = ? group by f.studentid order by studentid asc
            ", [$classid, $sectionid, $datefrom, $dateto, $campusid]);
        } else {
            $res = DB::select("
            select f.studentid, si.studentname, c.classname, s.sectionname, COUNT(DISTINCT f.month, f.year) as monthcount from studentinfo si, `feegenerations` f, classes c, sections s where f.ispaid = 0 and f.description != 'Reversed' and c.c_id = f.classid and s.sec_id = f.sectionid and si.studentid = f.studentid and si.admissioninclass= ? and date_add(makedate(f.year, f.month), interval (f.month)-1 month) >= ? and date_add(makedate(f.year, f.month), interval (f.month)-1 month) <= ? and f.campusid = si.campusid and f.campusid = ? group by f.studentid order by studentid asc
            ", [$classid, $datefrom, $dateto, $campusid]);
        }
        if (empty($res))
            return abort(404);

        return view('admin.Remainders.SMSRemainderStruckoff', ['students' => $res]);
    }
}
