<?php

namespace App\Http\Controllers;

use App\Models\ExpenseHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ExpenseHead::where('campusid', Auth::user()->campusid)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $campusid = Auth::user()->campusid;
        // check campus wise
        $request->validate([
            'expense_head' => 'required',
            'expense_desc' => ''
        ]);
        $data_array = ExpenseHead::where('campusid', $campusid)->where('expense_head', $request->expense_head)->first();

        if (empty($data_array)) {
            $class = new ExpenseHead();
            $class->expense_head = $request->expense_head;
            $class->expense_desc = $request->expense_desc;
            $class->campusid = Auth::user()->campusid;

            if ($class->save()) {
                return response()->json(['result' => 'save']);
            } else {
                return response()->json(['error' => 'issuein structure']);
            }
        } else {
            return response()->json(['result' => 'true']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpenseHead  $expenseHead
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseHead $expenseHead)
    {
        // return ExpenseHead::where('campusid', Auth::user()->campusid)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseHead  $expenseHead
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseHead $expenseHead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseHead  $expenseHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'expense_head' => 'required',
            'expense_desc' => ''
        ]);
        $campusid = Auth::user()->campusid;
        $data_array = ExpenseHead::where('campusid', $campusid)->where('expense_head', $request->expense_head)->where('id', '<>', $id)->first();
        if (empty($data_array)) {
            $jobs = ExpenseHead::where('campusid', $campusid)->where('id', $id)->update([
                'expense_head' => $request->expense_head,
                'expense_desc' => $request->expense_desc,
            ]);
        } else {
            echo 'duplicate';
            exit;
        }

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpenseHead  $expenseHead
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseHead $expenseHead)
    {
        //
    }
}
