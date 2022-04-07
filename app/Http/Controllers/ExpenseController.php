<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        // return view("admin.Expenses");
        abort(404);
    }

    public function Expenses() 
    {
        return view("admin.Expenses");
    }

    public function searchExpenses(Request $request)
    {
        if(!empty($request->expense_head_idd) and !empty($request->fromdate) and !empty($request->todate)){
            return DB::select("
                SELECT eh.expense_head, ex.expense_head_id, ex.id, ex.expense_desc, ex.expense_date, ex.expense_amount FROM `expenses` ex INNER JOIN expense_heads eh ON ex.expense_head_id = eh.id WHERE ex.campusid = eh.campusid and ex.expense_head_id = ? AND ex.expense_date BETWEEN ? AND ? and ex.campusid = ?
            ", [$request->expense_head_idd, $request->fromdate, $request->todate, Auth::user()->campusid]);
        }else if(!empty($request->fromdate) and !empty($request->todate)){
            return DB::select("
                SELECT eh.expense_head, ex.expense_head_id, ex.id, ex.expense_desc, ex.expense_date, ex.expense_amount FROM `expenses` ex INNER JOIN expense_heads eh ON ex.expense_head_id = eh.id WHERE ex.campusid = eh.campusid AND ex.expense_date BETWEEN ? AND ? and ex.campusid = ?
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
    public function store(ExpenseRequest $request)
    {   
        $request->validated();
        
        $campusid = Auth::user()->campusid;
        $scale = new Expense();
        $scale->expense_head_id = $request->expense_head_idd;
        $scale->expense_desc = $request->expense_desc;
        $scale->expense_date = $request->expense_date;
        $scale->expense_amount = $request->expense_amount;
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
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        // return Expense::where('campusid', Auth::user()->campusid)->get();
        return DB::select("
            SELECT eh.expense_head, ex.expense_head_id, ex.id, ex.expense_desc, ex.expense_date, ex.expense_amount FROM expense_heads eh INNER JOIN `expenses` ex ON ex.expense_head_id = eh.id WHERE ex.campusid = eh.campusid AND ex.campusid = eh.campusid and ex.campusid = ? and ex.expense_date = CURDATE()
        ", [Auth::user()->campusid]);
        // return DB::table('expenses')->rightJoin('expense_heads', 'expense_heads.id', '=', 'expenses.expense_head_id')
        // ->select('expenses.*', 'expense_heads.expense_head')->where('expense_heads.id', 'expenses.expense_head_id')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $request, $id)
    {
        $campusid = Auth::user()->campusid;
        Expense::where('campusid', $campusid)->where('id', $id)->update([
            'expense_head_id' => $request->expense_head_idd,
            'expense_desc' => $request->expense_desc,
            'expense_date' => $request->expense_date,
            'expense_amount' => $request->expense_amount,
        ]);

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
