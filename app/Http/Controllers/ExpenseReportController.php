<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\FeeGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.Reports.ExpenseAndIncomeReports');
    }
    
    public function ExpenseReport(Request $request)
    {
        $results = "";
        if(!empty($request->expensehead) and !empty($request->fromdate) and !empty($request->todate)){
            $results = DB::select("
                SELECT eh.expense_head, ex.expense_head_id, ex.id, ex.expense_desc, ex.expense_date, ex.expense_amount FROM `expenses` ex INNER JOIN expense_heads eh ON ex.expense_head_id = eh.id WHERE ex.campusid = eh.campusid and ex.expense_head_id = ? AND ex.expense_date BETWEEN ? AND ? and ex.campusid = ?
            ", [$request->expensehead, $request->fromdate, $request->todate, Auth::user()->campusid]);
        }else if(!empty($request->fromdate) and !empty($request->todate)){
            $results = DB::select("
                SELECT eh.expense_head, ex.expense_head_id, ex.id, ex.expense_desc, ex.expense_date, ex.expense_amount FROM `expenses` ex INNER JOIN expense_heads eh ON ex.expense_head_id = eh.id WHERE ex.campusid = eh.campusid AND ex.expense_date BETWEEN ? AND ? and ex.campusid = ?
            ", [$request->fromdate, $request->todate, Auth::user()->campusid]);
        }

        return view('admin.Reports.ExpenseReport', ['results' => $results, 'request' => $request]);
    }
    
    public function ExpensesGroupBy(Request $request)
    {
        $results = "";
        if(!empty($request->expensehead) and !empty($request->fromdate) and !empty($request->todate)){
            $results = DB::select("
            SELECT SUM(ex.expense_amount) AS summ, eh.expense_head, ex.expense_head_id, ex.id, ex.expense_desc, ex.expense_date, ex.expense_amount FROM `expenses` ex INNER JOIN expense_heads eh ON ex.expense_head_id = eh.id WHERE ex.campusid = eh.campusid and ex.expense_head_id = ? AND ex.expense_date BETWEEN ? AND ? and ex.campusid = ? GROUP BY ex.expense_head_id
            ", [$request->expensehead, $request->fromdate, $request->todate, Auth::user()->campusid]);
        }else if(!empty($request->fromdate) and !empty($request->todate)){
            $results = DB::select("
                SELECT SUM(ex.expense_amount) AS summ, eh.expense_head, ex.expense_head_id, ex.id, ex.expense_desc, ex.expense_date, ex.expense_amount FROM `expenses` ex INNER JOIN expense_heads eh ON ex.expense_head_id = eh.id WHERE ex.campusid = eh.campusid AND ex.expense_date BETWEEN ? AND ? and ex.campusid = ? GROUP BY ex.expense_head_id
            ", [$request->fromdate, $request->todate, Auth::user()->campusid]);
        }

        return view('admin.Reports.ExpensesGroupBy', ['results' => $results, 'request' => $request]);
    }
    
    public function AccountReport(Request $request)
    {
        $results = "";   
        if(!empty($request->accountid) and !empty($request->fromdate) and !empty($request->todate)){
            // dd("all");
            $results = DB::select("
                SELECT ad.account_desc, ad.transactiondate, ad.amount, ad.type, acc.accountname
                FROM `account_details` ad INNER JOIN accounts acc ON
                ad.account_id = acc.id WHERE ad.account_id = ? AND ad.transactiondate
                BETWEEN ? AND ? AND ad.campusid = acc.campusid AND ad.campusid = ?
            ", [$request->accountid, $request->fromdate, $request->todate, Auth::user()->campusid]);
        }else if(!empty($request->fromdate) and !empty($request->todate)){
            // dd("jsut date");
            $results = DB::select("
                SELECT ad.account_desc, ad.transactiondate, ad.amount, ad.type,
                acc.accountname FROM `account_details` ad INNER JOIN accounts acc ON
                ad.account_id = acc.id WHERE ad.transactiondate BETWEEN ? AND ? AND
                ad.campusid = acc.campusid AND ad.campusid = ?
                ", [$request->fromdate, $request->todate, Auth::user()->campusid]);
        }
        return view('admin.Reports.AccountReport', ['results' => $results, 'request' => $request]);
    }
    
    public function AccountsGroupBy(Request $request) 
    {
        $results = "";   
        if(!empty($request->accountid) and !empty($request->fromdate) and !empty($request->todate)){
            // dd("all");
            $results = DB::select("
                SELECT SUM(ad.amount) as summ, ad.account_desc, ad.transactiondate, ad.amount, ad.type, acc.accountname
                FROM `account_details` ad INNER JOIN accounts acc ON
                ad.account_id = acc.id WHERE ad.account_id = ? AND ad.transactiondate
                BETWEEN ? AND ? AND ad.campusid = acc.campusid AND ad.campusid = ? GROUP BY acc.id, ad.type
            ", [$request->accountid, $request->fromdate, $request->todate, Auth::user()->campusid]);
        }else if(!empty($request->fromdate) and !empty($request->todate)){
            // dd("jsut date");
            $results = DB::select("
                SELECT SUM(ad.amount) as summ, ad.account_desc, ad.transactiondate, ad.amount, ad.type, acc.accountname FROM `account_details` ad INNER JOIN accounts acc ON ad.account_id = acc.id WHERE ad.transactiondate BETWEEN ? AND ? AND ad.campusid = acc.campusid AND ad.campusid = ? GROUP BY acc.id, ad.type
            ", [$request->fromdate, $request->todate, Auth::user()->campusid]);
        }
        // dd($results);
        return view('admin.Reports.AccountsGroupBy', ['results' => $results, 'request' => $request]);
    }
    
    public function NetProfit(Request $request)
    {

        $profit = FeeGeneration::where('campusid', Auth::user()->campusid)->where('ispaid', 1)->whereBetween('recievedate', [$request->fromdate, $request->todate])->sum('feeamount');
        $expense = Expense::where('campusid', Auth::user()->campusid)->whereBetween('expense_date', [$request->fromdate, $request->todate])->sum('expense_amount');
        
        return view('admin.Reports.NetProfit', ['profit' => $profit, 'expense' => $expense, 'request' => $request]);
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
