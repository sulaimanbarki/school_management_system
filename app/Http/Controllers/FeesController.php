<?php

namespace App\Http\Controllers;

use App\Models\ClassWiseFeeCriteria;
use App\Models\FeeSubHead;
use App\Models\StudentWiseFeeCriterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FeesController extends Controller
{
    public function index()
    {
        return view('admin.FeesModule');
    }

    // load class wise fees criterias main page
    public function LoadClassWiseCriterial()
    {
        return view('admin.ClassWiseCriteria');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validate([
            'subhead' => 'required|min:1|max:255',
            'amount' => 'required|integer|max:100|min:0',
            'sequence' => 'required|between:1,20',
            'isdefault' => 'required|in:Yes,No',
            'date' => 'required',
            'description' => '',
        ]);

        $data_array = FeeSubHead::where('campusid', $campusid)->where('subhead', $request->subhead)->first();
        if (empty($data_array)) {
            $fee = new FeeSubHead();
            $fee->subhead = $request->subhead;
            $fee->campusid = $campusid;
            $fee->amount = $request->amount;
            $fee->description = $request->description;
            $fee->sequence = $request->sequence;
            ($request->transportStatus) ? $fee->transport_status = 1 : $fee->transport_status = 0;
            $fee->date = $request->date;
            $fee->addedby = Auth::user()->id;
            $fee->isdefault = $request->isdefault;
            if ($fee->save()) {
                return response()->json(['result' => 'save']);
            } else {
                return response()->json(['result' => 'error']);
            }
        } else {
            return response()->json(['result' => 'already']);
        }
    }

    public function storeFeesCriteria(Request $request)
    {
        //
        $request->validate([
            'classid' => 'required',
            'subheadid' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'academicsession' => 'required',
        ]);
        $campusid = Auth::user()->campusid;
        $UserID = Auth::user()->id;
        $data_array = ClassWiseFeeCriteria::where('campusid', $campusid)->where('classid', $request->classid)
            ->where('subheadid', $request->subheadid)->where('sessionid', $request->academicsession)->first();
        if (empty($data_array)) {
            $feeCri = new ClassWiseFeeCriteria();
            $feeCri->classid = $request->classid;
            $feeCri->campusid = $campusid;
            $feeCri->amount = $request->amount;
            $feeCri->subheadid = $request->subheadid;
            $feeCri->date = $request->date;
            $feeCri->sessionid = $request->academicsession;
            $feeCri->addedby  = $UserID;
            if ($feeCri->save()) {
                return response()->json(['result' => 'save']);
            } else {
                return response()->json(['error' => 'False']);
            }
        } else {
            return "already";
        }
    }

    public function show()
    {
        $campusid = Auth::user()->campusid;
        $feeshead = FeeSubHead::where('campusid', $campusid)->get();
        return response()->json(json_encode($feeshead));
    }

    public function showFeesCriteria()
    {
        $campusid = Auth::user()->campusid;
        // $feesCriteria = ClassWiseFeeCriteria::where('campusid', Auth::user()->campusid)->get();
        $feesCriteria = DB::select("
        SELECT cw.id,f.subhead,cl.classname,c.campusid,cw.amount, cw.sessionid as asessionid, ac.session, cw.date, cl.c_id, cw.subheadid 
        from classwisefeecriterias cw,classes cl,configurations c,feesubheads f, academicsessions ac 
        where cw.classid=cl.c_id and cw.campusid=c.campusid and f.id=cw.subheadid and cw.campusid=f.campusid 
        and cw.campusid=cl.campusid and cw.sessionid = ac.id AND cw.campusid= ?
        ", [$campusid]);

        return response()->json(json_encode($feesCriteria));
    }

    public function edit($id)
    {
        //
    }

    public function UpdateStudentWiseFeeAmount(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validate([
            'changesAmount' => 'required|integer|max:100|min:0',
        ]);

        StudentWiseFeeCriterial::where('campusid', $campusid)->where('id', $request->input('changesAmountId'))->update([
            'amountParentage' => $request->input('changesAmount'),
            'issuedate' => $request->input('expiryDateUpdate'),
            'lastdate' => $request->input('issueDateUpdate'),
            'isactive' => $request->input('isActiveUpdate'),
        ]);
    }

    public function update(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validate([
            // 'subhead' => 'required|min:1|max:255',
            'subhead' => Rule::unique('feesubheads')->where(function ($query) use ($request) {
                return $query->where('campusid', Auth::user()->campusid)->where('id', '<>', $request->id);
            }),
            'amount' => 'required|integer',
            'sequence' => 'required|between:1,20',
            'isdefault' => 'required|in:Yes,No',
            'date' => 'required',
            'description' => '',
        ]);

        FeeSubHead::where('campusid', '=', $campusid)->where('id', $request->input('id'))->update([
            'subhead' => $request->input('subhead'),
            'amount' => $request->input('amount'),
            'sequence' => $request->input('sequence'),
            'isdefault' => $request->input('isdefault'),
            'date' => $request->input('date'),
            'description' => $request->input('description'),
        ]);
    }

    public function UpdateClassWiseFeeCriteria(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validate([
            'subheadid' => 'required',
            'amount' => 'required|integer',
            'classid' => 'required|between:1,20',
            'academicsession' => 'required',
            'date' => 'required',
        ]);

        $data_array = ClassWiseFeeCriteria::where('campusid', $campusid)->where('classid', $request->input('classid'))
            ->where('subheadid', $request->input('subheadid'))->where('sessionid', $request->input('academicsession'))
            ->where('id', '<>', $request->id)->first();
        if (empty($data_array)) {
            ClassWiseFeeCriteria::where('campusid', $campusid)->where('id', $request->input('id'))->update([
                'subheadid' => $request->input('subheadid'),
                'amount' => $request->input('amount'),
                'classid' => $request->input('classid'),
                'sessionid' => $request->input('academicsession'),
                'addedby' => Auth::id(),
                'date' => $request->input('date'),
            ]);
        } else {
            echo "already";
        }
    }

    public function destroy($id)
    {
        //
    }

    public function destroyFeesCriteria(Request $request)
    {
        DB::table('classwisefeecriterias')->where('id', $request->criteriadid)->delete();
        return "Class Deleted Successfully";
        exit;
    }

    public function StoreFeeheadsSessionWise(Request $request)
    {
    }
}
