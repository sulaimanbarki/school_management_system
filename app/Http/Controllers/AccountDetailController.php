<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountDetailRequest;
use App\Models\AccountDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountDetailController extends Controller
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

    public function searchDetails(Request $request)
    {
        if(!empty($request->account_iddd) and !empty($request->fromdate) and !empty($request->todate)){
            // dd("all");
            return DB::select("
                SELECT ad.account_desc, ad.transactiondate, ad.amount, ad.type, acc.accountname
                FROM `account_details` ad INNER JOIN accounts acc ON
                ad.account_id = acc.id WHERE ad.account_id = ? AND ad.transactiondate
                BETWEEN ? AND ? AND ad.campusid = acc.campusid AND ad.campusid = ?
            ", [$request->account_iddd, $request->fromdate, $request->todate, Auth::user()->campusid]);

        }else if(empty($request->account_iddd) and !empty($request->fromdate) and !empty($request->todate)){
            // dd("jsut date");
            return DB::select("
                SELECT ad.account_desc, ad.transactiondate, ad.amount, ad.type,
                acc.accountname FROM `account_details` ad INNER JOIN accounts acc ON
                ad.account_id = acc.id WHERE ad.transactiondate BETWEEN ? AND ? AND
                 ad.campusid = acc.campusid AND ad.campusid = ?
            ", [$request->fromdate, $request->todate, Auth::user()->campusid]);
        }
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
    public function store(AccountDetailRequest $request)
    {
        $request->validated();

        $campusid = Auth::user()->campusid;
        $scale = new AccountDetail();
        $scale->account_id = $request->account_idd;
        $scale->account_desc = $request->account_descc;
        $scale->transactiondate = $request->transactiondate;
        $scale->amount = $request->amount;
        $scale->type = $request->type;
        $scale->campusid = $campusid;
        if ($scale->save()) {
            return response()->json(['result' => 'Employee is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountDetail  $accountDetail
     * @return \Illuminate\Http\Response
     */
    public function show(AccountDetail $accountDetail)
    {
        // dd("hello");
        return DB::select("
        SELECT ad.id, ad.account_id, ad.account_desc, ad.transactiondate,
        ad.amount, ad.type, ac.accountname FROM accounts ac INNER JOIN account_details ad ON ad.account_id = ac.id WHERE ad.campusid = ac.campusid and ad.campusid = ? and ad.transactiondate = curdate()
        ", [Auth::user()->campusid]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountDetail  $accountDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountDetail $accountDetail)
    {
        echo "asdfasdf";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountDetail  $accountDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $accountDetailid)
    {
        $campusid = Auth::user()->campusid;
        AccountDetail::where('campusid', $campusid)->where('id', $accountDetailid)->update([
            'account_id' => $request->account_idd,
            'account_desc' => $request->account_descc,
            'transactiondate' => $request->transactiondate,
            'amount' => $request->amount,
            'type' => $request->type,
        ]);

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountDetail  $accountDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountDetail $accountDetail)
    {
        //
    }
}
