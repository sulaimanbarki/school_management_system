<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvanceSalaryRequest;
use App\Models\AdvanceSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdvanceSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AdvanceSalary::where('campusid', Auth::user()->campusid)->get();
        $data = DB::select("
            SELECT *, sal.id as salid FROM `advance_salaries` sal, admins ad 
            WHERE ad.id = sal.empid AND ad.campusid = sal.campusid AND sal.campusid = ?
        ",[Auth::user()->campusid]);

        return response()->json(json_encode($data));
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
    public function store(AdvanceSalaryRequest $request)
    {
        $request->validated();

        $advance = new AdvanceSalary();
        $advance->empid = $request->employeeidadvancesalary;
        $advance->campusid = Auth::user()->campusid;
        $advance->debitamount = $request->debitamount;
        $advance->date = $request->advancesalarydate;
        $advance->status = $request->status;
        if ($advance->save()) {
            return response()->json(['result' => 'Employee is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdvanceSalary  $advanceSalary
     * @return \Illuminate\Http\Response
     */
    public function show(AdvanceSalary $advanceSalary)
    {
        // return response()->json(json_encode(AdvanceSalary::where('campusid', Auth::user()->campusid)->get()));
        // return $advanceSalary;
        dd($advanceSalary);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdvanceSalary  $advanceSalary
     * @return \Illuminate\Http\Response
     */
    public function edit(AdvanceSalary $advanceSalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdvanceSalary  $advanceSalary
     * @return \Illuminate\Http\Response
     */
    public function update(AdvanceSalaryRequest $request, AdvanceSalary $advanceSalary)
    {
        $request->validated();
        $advanceSalary->update([
            'empid' => $request->employeeidadvancesalary,
            'debitamount' => $request->debitamount,
            'date' => $request->advancesalarydate,
            'status' => $request->status,
        ]);
        //$advanceSalary->update($request->validated());
        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdvanceSalary  $advanceSalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdvanceSalary $advanceSalary)
    {
        $advanceSalary->delete();

        return response('', 204);
    }
}
