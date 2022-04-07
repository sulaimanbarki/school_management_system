<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FeeSubHead;
use App\Models\FeeGeneration;
use App\Models\ScholarshipWiseSubheads;
use Illuminate\Support\Facades\Auth;

class FeeGenerationsCalculate extends Controller
{
    public function GenerateFees(Request $request)
    {

        $hello = 0;
        ///  dd($request->monthfrom);
        $request->validate([
            'monthfrom' => 'required|date',
            'monthto'  => 'required|date|after_or_equal:monthfrom',
            'issuedate' => 'required|date',
            'lastdate'  => 'required|date|after_or_equal:monthfrom',

        ]);
        //   echo $request->issuedate;
        //   echo $request->monthto;
        $date1 = $request->monthfrom;
        $date2 = $request->monthto;
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        //   echo $diff . "</br>";
        $month = date("m", strtotime($date1));
        $month = (int)$month;
        $month1 = $month;
        $year3 = $year1;

        $campusid = Auth::user()->campusid;
        // dd($request->searchStudent1);

        // check feeheads if null then exit
        if (is_null($request->feeheads))
            exit;
        if (is_null($request->classid) && is_null($request->All) && is_null($request->searchStudent1))
            exit;
        $lenth = count($request->feeheads);
        // dd($lenth);
        //  $request->searchStudent1;
        for ($k = 0; $k < $lenth; $k++) {

            $index = $request->feeheads[$k];
            $month = $month1;
            $year1 = $year3;
            $data_array1 = FeeSubHead::where('campusid', $campusid)->where('id', '=', $index)->first();
            if ($request->classid > 0) {

                if ($data_array1['transport_status'] == 1) {

                    $generateFee = DB::select("
                SELECT s.studentid,cf.amount,cf.subheadid,s.session,cf.classid,s.admissioninsection from studentinfo s,classwisefeecriterias cf where
                s.admissioninclass=cf.classid  and status not in('Slc','Matriculate')
                and
                cf.campusid=cf.campusid and classid=? and
                cf.subheadid=? and s.transportstatus='yes'
                ", [$request->classid, $index]);
                } else {

                    $generateFee = DB::select("
                SELECT s.studentid,cf.amount,cf.subheadid,s.session,cf.classid,s.admissioninsection from studentinfo s,classwisefeecriterias cf where
                s.admissioninclass=cf.classid  and status not in('Slc','Matriculate')
                and
                cf.campusid=cf.campusid and classid=? and
                cf.subheadid=?
                ", [$request->classid, $index]);
                }
            } 
            
            
            else if ($request->All == "All") {

                if ($data_array1['transport_status'] == 1) {
                    $generateFee = DB::select("
                    SELECT s.studentid,cf.amount,cf.subheadid,s.session,cf.classid,s.admissioninsection from studentinfo s,classwisefeecriterias cf where
                    s.admissioninclass=cf.classid  and status not in('Slc','Matriculate')
                    and
                    cf.campusid=cf.campusid and
                    cf.subheadid=? and s.transportstatus='yes'
                    ", [$index]);
                } else {
                    $generateFee = DB::select("
                    SELECT s.studentid,cf.amount,cf.subheadid,s.session,cf.classid,s.admissioninsection from studentinfo s,classwisefeecriterias cf where
                    s.admissioninclass=cf.classid  and status not in('Slc','Matriculate')
                    and
                    cf.campusid=cf.campusid and
                    cf.subheadid=?
                    ", [$index]);
                }
            } else if ($request->searchStudent1 == "2") {

                if ($data_array1['transport_status'] == 1) {

                    $generateFee = DB::select("
                    SELECT s.studentid,cf.amount,cf.subheadid,s.session,cf.classid,s.admissioninsection from studentinfo s,classwisefeecriterias cf where
                    s.admissioninclass=cf.classid  and status not in('Slc','Matriculate')
                    and
                    cf.campusid=cf.campusid and s.studentid=? and
                    cf.subheadid=? and s.transportstatus='yes'
                    ", [$request->stdid, $index]);
                } else {
                    $generateFee = DB::select("
                    SELECT s.studentid,cf.amount,cf.subheadid,s.session,cf.classid,s.admissioninsection from studentinfo s,classwisefeecriterias cf where
                    s.admissioninclass=cf.classid  and status not in('Slc','Matriculate')
                    and
                    cf.campusid=cf.campusid and s.studentid=? and
                    cf.subheadid=?
                    ", [$request->stdid, $index]);
                }
            } else if ($request->searchStudent1 == "2") {

                if ($data_array1['transport_status'] == 1) {
                    $generateFee = DB::select("
                    SELECT s.studentid,cf.amount,cf.subheadid,s.session,cf.classid,s.admissioninsection from studentinfo s,classwisefeecriterias cf where
                    s.admissioninclass=cf.classid  and status not in('Slc','Matriculate')
                    and
                    cf.campusid=cf.campusid and s.studentid=? and
                    cf.subheadid=? and s.transportstatus='yes'
                    ", [$request->stdid, $index]);
                } else {

                    $generateFee = DB::select("
                    SELECT s.studentid,cf.amount,cf.subheadid,s.session,cf.classid,s.admissioninsection from studentinfo s,classwisefeecriterias cf where
                    s.admissioninclass=cf.classid  and status not in('Slc','Matriculate')
                    and
                    cf.campusid=cf.campusid and s.studentid=? and
                    cf.subheadid=?
                    ", [$request->searchstudent, $index]);
                }
            }

            //$count=count($generateFee);

            for ($i = 0; $i <= $diff; $i++) {

                //  echo $month."            ".$year1."\n";

                if ($month == 13) {
                    $month = 1;
                    $year1++;
                }
                $j = 0;

                foreach ($generateFee as $StudentData) {
                    $StudentInfoData = FeeGeneration::where('campusid', Auth::user()->campusid)
                        ->where('subheadid', '=', $index)
                        ->where('studentid', '=', $StudentData->studentid)->where('month', '=', $month)
                        ->where('year', '=', $year1)->first();
                    if (empty($StudentInfoData)) {
                        $campusid=Auth::user()->campusid;

                        // $StudentWiseFeeCriterial = ScholarshipWiseSubheads::where('campusid', Auth::user()->campusid)
                        //     ->where('studentid', '=', $StudentData->studentid)
                        //     ->where('subheadid', '=', $index)->first();
                        $StudentWiseFeeCriterial = DB::select("
                        SELECT * FROM `studentscholarshipwisesubheads` ss,scholarships s
                         where ss.scholarshipid=s.id and s.campusid=ss.campusid and
                         s.isactive='yes' and ss.isactive='yes' and s.campusid=?
                         and ss.studentid=?
                         and ss.subheadid=?
                             ", [$campusid, $StudentData->studentid, $index]);

                            //  dd($StudentWiseFeeCriterial[0]->studentid);


                        if (empty($StudentWiseFeeCriterial)) {
                            $FeeGeneration = new FeeGeneration();
                            $FeeGeneration->campusid = Auth::user()->campusid;
                            $FeeGeneration->studentid = $StudentData->studentid;
                            $FeeGeneration->sessionid = $StudentData->session;
                            $FeeGeneration->mainhead = 'Income';
                            $FeeGeneration->subheadid = $index;
                            $FeeGeneration->month = $month;
                            $FeeGeneration->year = $year1;
                            $FeeGeneration->feeamount = $StudentData->amount;
                            $FeeGeneration->description = 'Unpaid';
                            $FeeGeneration->ispaid = 0;
                            $FeeGeneration->date = date('d-M-Y');
                            $FeeGeneration->issuedate = $request->issuedate;
                            $FeeGeneration->lastdate = $request->lastdate;
                            $FeeGeneration->recievedate = $request->lastdate;
                            $FeeGeneration->isprint = 0;
                            $FeeGeneration->invoiceno = 0;
                            $FeeGeneration->classid = $StudentData->classid;
                            $FeeGeneration->sectionid = $StudentData->admissioninsection;
                            $FeeGeneration->freetransport = $request->lastdate;
                            $FeeGeneration->pcname = 'none';
                            $FeeGeneration->issuspence = 0;
                            $FeeGeneration->macaddress = 'none';
                            $FeeGeneration->ipaddress = 'none';
                            $FeeGeneration->save();
                        } else {
                            $FeeGeneration = new FeeGeneration();
                            $FeeGeneration->campusid = Auth::user()->campusid;
                            $FeeGeneration->studentid = $StudentData->studentid;
                            $FeeGeneration->sessionid = $StudentData->session;
                            $FeeGeneration->mainhead = 'Income';
                            $FeeGeneration->subheadid = $index;
                            $FeeGeneration->month = $month;
                            $FeeGeneration->year = $year1;
                            $SubheadAmount = (int)$StudentData->amount * $StudentWiseFeeCriterial[0]->amountParentage / 100;
                            $amount = $StudentData->amount - $SubheadAmount;
                            $FeeGeneration->feeamount = $amount;
                            $FeeGeneration->comment = $StudentWiseFeeCriterial[0]->name;
                            $FeeGeneration->description = 'Unpaid';
                            $FeeGeneration->ispaid = 0;
                            $FeeGeneration->date = date('d-M-Y');
                            $FeeGeneration->issuedate = $request->issuedate;
                            $FeeGeneration->lastdate = $request->lastdate;
                            $FeeGeneration->recievedate = $request->lastdate;
                            $FeeGeneration->isprint = 0;
                            $FeeGeneration->invoiceno = 0;
                            $FeeGeneration->classid = $StudentData->classid;
                            $FeeGeneration->sectionid = $StudentData->admissioninsection;
                            $FeeGeneration->freetransport = $request->lastdate;
                            $FeeGeneration->pcname = 'none';
                            $FeeGeneration->issuspence = 0;
                            $FeeGeneration->macaddress = 'none';
                            $FeeGeneration->ipaddress = 'none';
                            $FeeGeneration->save();
                        }
                        // echo $hello. "     " . $StudentData->STUDENTID . "      " . $StudentData->AMOUNT      . "     " . $month . "\n";
                        $j++;
                    }
                }
                $month++;
            }
        }

        // return $request;
        return response()->json(['result' => 'save']);
    }

    public function FetchFeesDetails(Request $request)
    {
        $id = $request->stdid;
        $det = DB::select("
            SELECT f.id, s.studentname, s.fathername, f.studentid,c.classname,sec.sectionname,fh.subhead,f.month,f.year,sum(f.feeamount) as amount from feegenerations f,studentinfo s ,classes c ,sections sec,
            feesubheads fh
            where
            fh.id=f.subheadid and fh.campusid=f.campusid and
            s.studentid=f.studentid and s.campusid=f.campusid and c.c_id=s.admissioninclass and c.campusid=s.campusid
            and sec.sec_id=s.admissioninsection and
            s.status!='slc' and ispaid=0 and f.description!='reversed' and
			f.studentid=? and feeamount>0
        ", [$id]);
        return response()->json(json_encode($det));
    }

    public function EditFeeFetch(Request $request)
    {
        $campus = Auth::user()->campusid;
        $feesEdit = DB::select("
            SELECT f.id, f.comment, s.studentname, s.fathername, f.studentid,c.classname,sec.sectionname,fh.subhead,f.month,f.year,sum(f.feeamount) as amount from feegenerations f,studentinfo s ,classes c ,sections sec,
            feesubheads fh where fh.id=f.subheadid and fh.campusid=f.campusid and
            s.studentid=f.studentid and s.campusid=f.campusid and c.c_id=s.admissioninclass and c.campusid=s.campusid
            and sec.sec_id=s.admissioninsection and
            s.status!='slc' and ispaid=0 and f.description!='reversed'
            and f.studentid = ? and f.campusid = ? and feeamount>0
            group by studentid,subheadid,month,year
        ", [$request->stdid, $campus]);

        return response()->json(json_encode($feesEdit));
    }

    public function UpdateFees(Request $request)
    {
        for ($i = 0; $i < count($request->discount); $i++) {
            FeeGeneration::where('id', $request->feeid[$i])->update([
                'feeamount' =>  $request->discount[$i],
                'date' => date('Y-m-d'),
                'comment' => $request->discription[$i],
            ]);
        }
        echo 'success';
        exit;
    }

    public function ReverseStudentFees(Request $r)
    {
        $id = $r->tableid;
        $cmt = $r->comments;

        FeeGeneration::where('id', $id)->update([
            'description' => "Reversed",
            'comment' => $cmt,
            'date' => date('Y-m-d'),
        ]);
    }

    public function fetchUnpaidSubheads(Request $r)
    {
        $id = Auth::user()->campusid;
        $classid = $r->classid;
        $sectionid = $r->sectionid;
        $stdid = $r->searchStudent2;
        $monthto = $r->monthto;
        $monthto = $monthto . "-28";

        if ($classid > 0 && $sectionid > 0) {
            $subheads = DB::select("
        SELECT f.id, s.studentname, s.fathername, f.studentid,c.classname,sec.sectionname,
        fh.subhead,f.month,f.year,feeamount from feegenerations f,studentinfo s ,classes c ,sections sec,
        feesubheads fh where fh.id=f.subheadid and fh.campusid=f.campusid and
        s.studentid=f.studentid and s.campusid=f.campusid
        and c.c_id=s.admissioninclass and c.campusid=s.campusid
        and sec.sec_id=s.admissioninsection and sec.campusid=s.campusid and ispaid=0 and f.description!='reversed'
        and
        s.status!='slc'
        and
        s.admissioninclass=? and  s.admissioninsection=?
        and date_add(makedate(f.year, f.month), interval (f.month)-1 month)<=?
        and
        f.campusid=?  and feeamount>0
		order by f.studentid,year,month asc


        ", [$classid, $sectionid, $monthto, $id]);
        } else if ($classid > 0 && $sectionid == 0) {
            //echo 'hit';
            $subheads = DB::select("
            SELECT f.id, s.studentname, s.fathername, f.studentid,c.classname,sec.sectionname,fh.subhead,f.month,f.year,feeamount from feegenerations f,studentinfo s ,classes c ,sections sec,
            feesubheads fh where fh.id=f.subheadid and fh.campusid=f.campusid and
            s.studentid=f.studentid and s.campusid=f.campusid
            and c.c_id=s.admissioninclass and c.campusid=s.campusid
            and sec.sec_id=s.admissioninsection and sec.campusid=s.campusid and ispaid=0 and f.description!='reversed'
            and date_add(makedate(f.year, f.month), interval (f.month)-1 month)<=?
            and
            s.status!='slc'
            and
            s.admissioninclass=?
            and
            f.campusid=?  and feeamount>0

			order by f.studentid,year,month asc
            ", [$monthto, $classid, $id]);
        }
        if ($stdid > 0) {
            //echo 'hit';
            $studentid = $r->stdid;
            $subheads = DB::select("
            SELECT f.id, s.studentname, s.fathername, f.studentid,c.classname,sec.sectionname,fh.subhead,f.month,f.year,feeamount from feegenerations f,studentinfo s ,classes c ,sections sec,
            feesubheads fh where fh.id=f.subheadid and fh.campusid=f.campusid and
            s.studentid=f.studentid and s.campusid=f.campusid
            and c.c_id=s.admissioninclass and c.campusid=s.campusid
            and sec.sec_id=s.admissioninsection and sec.campusid=s.campusid and ispaid=0 and f.description!='reversed'
            and date_add(makedate(f.year, f.month), interval (f.month)-1 month)<=?
            and
            s.status!='slc'
            and
            s.studentid=?
            and
            f.campusid=? and feeamount>0
			order by f.studentid,year,month asc

            ", [$monthto, $studentid, $id]);
        }
        return response()->json(json_encode($subheads));
    }
}
