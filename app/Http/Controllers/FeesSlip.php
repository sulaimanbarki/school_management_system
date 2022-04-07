<?php

namespace App\Http\Controllers;

use App\Models\FeeGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeesSlip extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.FeesSlip');
    }

    public function UnpaidFees(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $student = DB::select("
        SELECT s.studentname, s.status, s.busnumber, s.fathername,c.classname,sec.sectionname from studentinfo s ,classes c ,sections sec
        where s.campusid = c.campusid and c.c_id = s.admissioninclass and sec.sec_id = s.admissioninsection and
        s.campusid=? and
        s.studentid=?
        ", [$campusid, $r->stdid]);

        $unpaid = DB::select("
        SELECT f.id, s.studentname, s.status, s.fathername, f.studentid,c.classname,sec.sectionname,fh.subhead,f.month,f.year, sum(f.feeamount) as amount from feegenerations f,studentinfo s ,classes c ,sections sec,
        feesubheads fh
        where
        fh.id=f.subheadid and fh.campusid=f.campusid and
        s.studentid=f.studentid and s.campusid=f.campusid
        and c.c_id=s.admissioninclass and c.campusid=s.campusid
        and sec.sec_id=s.admissioninsection
        and ispaid=0 and f.description!='reversed' and
        f.campusid= ? and
        f.studentid= ? and feeamount>0
        group by studentid,subheadid,month,year
        order by year,month asc
        ", [$campusid, $r->stdid]);

        $paid = DB::select("
        SELECT f.id, f.comment, s.studentname, s.status, s.fathername, f.studentid,c.classname,sec.sectionname,fh.subhead,f.month,f.year, f.recievedate,sum(f.feeamount) as amount from feegenerations f,studentinfo s ,classes c ,sections sec,
        feesubheads fh
        where
        fh.id=f.subheadid and fh.campusid=f.campusid and
        s.studentid=f.studentid and s.campusid=f.campusid and c.c_id=s.admissioninclass and c.campusid=s.campusid
        and sec.sec_id=s.admissioninsection
        and ispaid=1 and f.description!='reversed' and
        f.campusid= ? and
        f.studentid= ?
        group by studentid,subheadid,month,year
        order by year,month asc
        ", [$campusid, $r->stdid]);

        $reversed = DB::select("
        SELECT f.id, s.studentname, s.fathername, f.comment, f.studentid,c.classname,sec.sectionname,fh.subhead,f.month,f.year, f.recievedate,sum(f.feeamount) as amount from feegenerations f,studentinfo s ,classes c ,sections sec,
        feesubheads fh
        where
        fh.id=f.subheadid and fh.campusid=f.campusid and
        s.studentid=f.studentid and s.campusid=f.campusid and c.c_id=s.admissioninclass and c.campusid=s.campusid
        and sec.sec_id=s.admissioninsection
        and ispaid=0 and f.description = 'reversed' and
        f.campusid= ? and
        f.studentid= ? and feeamount>0
        group by studentid,subheadid,month,year
        order by month,subhead
        ", [$campusid, $r->stdid]);

        $data = array();
        $data['student'] = $student;
        $data['unpaid'] = $unpaid;
        $data['paid'] = $paid;
        $data['rev'] = $reversed;
        return response()->json(json_encode($data));
    }

    public function PayUnpaidFees(Request $r)
    {
        for ($i = 0; $i < count($r->checkStatus); $i++) {
            if ($r->checkStatus[$i] == 1) {

                FeeGeneration::where('id', $r->feeheadid[$i])->where('campusid', Auth::user()->campusid)->update([
                    'description' => 'Paid',
                    'ispaid' => 1,
                    'recievedate' => $r->recievedate,
                    'date' => date('Y-m-d'),
                ]);
            }
        }
        echo 'success';
        exit;
    }
    public function UnpaidPaidFees(Request $r)
    {
        // dd($r->checkStatus1);

        for ($i = 0; $i < count($r->checkStatus1); $i++) {
            if ($r->checkStatus1[$i] == 1) {

                FeeGeneration::where('id', $r->feeheadid1[$i])->where('campusid', Auth::user()->campusid)->update([
                    'description' => 'UnPaid',
                    'ispaid' => 0,
                    'recievedate' => $r->recievedate,
                    'date' => date('Y-m-d'),
                ]);
            }
        }
        echo 'success';
        exit;
    }
    public function UnRevereddPaidFees(Request $r)
    {
        // dd($r->checkStatus1);

        for ($i = 0; $i < count($r->checkStatus2); $i++) {
            if ($r->checkStatus2[$i] == 1) {

                FeeGeneration::where('id', $r->feeheadid2[$i])->where('campusid', Auth::user()->campusid)->update([
                    'description' => 'UnPaid',
                    'ispaid' => 0,
                    'recievedate' => $r->recievedate,
                    'date' => date('Y-m-d'),
                ]);
            }
        }
        echo 'success';
        exit;
    }

    public function LoadFeesForDateModify(Request $r)
    {
        $cid = Auth::user()->campusid;
        $modify = db::select("
        select f.id, s.studentname, s.fathername, f.studentid,sum(f.feeamount) as amount,
        f.recievedate from feegenerations f,studentinfo s ,classes c ,sections sec,
        feesubheads fh where fh.id=f.subheadid and fh.campusid=f.campusid and
        s.studentid=f.studentid and s.campusid=f.campusid and c.c_id=s.admissioninclass and
        c.campusid=s.campusid and sec.sec_id=s.admissioninsection and ispaid=1 and
        f.description!='reversed' and f.campusid=? and recievedate=?
        group by studentid
        ", [$cid, $r->datee]);
        return response()->json(json_encode($modify));
    }

    public function TotalUnpaidStudents(Request $r)
    {
        $campusid = Auth::user()->campusid;
        $classid = $r->classid;
        $sectionid = $r->sectionid;
        $stdid = $r->searchStudent2;

        $monthto = $r->monthto;
        $monthto = $monthto . "-28";

        if ($classid > 0 && $sectionid > 0) {
            $modify = DB::select("
        SELECT   distinct(s.studentid), s.studentname, s.fathername, f.studentid,c.classname,
        sec.sectionname,fh.subhead,f.month,f.year,feeamount from feegenerations f,studentinfo s
        ,classes c ,sections sec,
        feesubheads fh where fh.id=f.subheadid and fh.campusid=f.campusid and
        s.studentid=f.studentid and s.campusid=f.campusid
        and c.c_id=s.admissioninclass and c.campusid=s.campusid
        and sec.sec_id=s.admissioninsection  and sec.campusid=s.campusid and ispaid=0
        and f.description!='reversed' and
        f.campusid=?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month)<=?
        and  s.admissioninsection=? and s.status!='slc' and s.admissioninclass=?
		and feeamount>0
        group by s.studentid
        order by s.admissioninclass,s.admissioninsection,s.studentid;
        ", [$campusid, $monthto, $sectionid, $classid]);
        } else if ($classid > 0 && $sectionid == 0) {
            $modify = DB::select("
        SELECT   distinct(s.studentid), s.studentname, s.fathername, f.studentid,c.classname,sec.sectionname,fh.subhead,f.month,f.year,feeamount
        from feegenerations f,studentinfo s ,classes c ,sections sec,
        feesubheads fh where fh.id=f.subheadid and fh.campusid=f.campusid and
        s.studentid=f.studentid and s.campusid=f.campusid
        and c.c_id=s.admissioninclass and c.campusid=s.campusid
        and sec.sec_id=s.admissioninsection and sec.campusid=s.campusid and ispaid=0 and f.description!='reversed' and
        f.campusid=?  and s.status!='slc' and s.admissioninclass= ?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month)<= ?
		and feeamount>0
        group by s.studentid
        order by s.admissioninclass,s.admissioninsection,s.studentid;
        ", [$campusid, $classid, $monthto]);
        } else if ($stdid > 0) {

            $studentid = $r->stdid;
            // dd($studentid);
            $modify = DB::select("
        select   distinct(s.studentid), s.studentname, s.fathername, f.studentid,c.classname,sec.sectionname,fh.subhead,f.month,f.year,feeamount from feegenerations f,studentinfo s ,classes c ,sections sec,
        feesubheads fh where fh.id=f.subheadid and fh.campusid=f.campusid and
        s.studentid=f.studentid and s.campusid=f.campusid
        and c.c_id=s.admissioninclass and c.campusid=s.campusid
        and sec.sec_id=s.admissioninsection and ispaid=0 and f.description!='reversed' and
        f.campusid= ?  and s.status!='slc'
        and s.studentid= ?
        and   date_add(makedate(f.year, f.month), interval (f.month)-1 month) <= ?
			and feeamount>0
        group by s.studentid
        order by s.admissioninclass,s.admissioninsection,s.studentid;

        ", [$campusid, $studentid, $monthto]);
        }

        // dd($stdid);


        return response()->json(json_encode($modify));
    }




    public function ModifyRecieveDate(Request $r)
    {
        for ($i = 0; $i < count($r->checkStatus); $i++) {
            if ($r->checkStatus[$i] == 1) {
                FeeGeneration::where('recievedate', $r->datee)->where('campusid', Auth::user()->campusid)->update([
                    'recievedate' => $r->todatee,
                ]);
            }
        }
        echo 'success';
        exit;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
