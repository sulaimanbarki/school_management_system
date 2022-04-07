<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Companies()
    {
        return view('admin.Inventory.Companies');
    }

    public function index()
    {
        $companies = Company::where('campusid', Auth::user()->campusid)->get();
        return Datatables::of($companies)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editCompany"><i class="fas fa-edit"  title="Edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
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
    public function store(CompanyRequest $request)
    {

        try {
            $request->validated();
            $imgname = "";
            if ($request->logo) {
                $imgname =  "companylogo-" . time() . "." . $request->logo->extension();
            }

            Company::updateOrCreate(['id' => $request->companyid], [
                'company_name' => $request->company_name,
                'address' => $request->address,
                'contact1' => $request->contact1,
                'contact2' => $request->contact2,
                'description' => $request->description,
                'date_of_registeration' => $request->date_of_registeration,
                'logo' => $imgname,
                'campusid' => Auth::user()->campusid,
            ]);

            if ($request->logo) {
                $request->logo->move(public_path('companylogo'), $imgname);
            }

        } catch (Exception $e) {
            return response()->json([
                'success' => 'Duplicate Entry.',
                // 'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Company::where('campusid', Auth::user()->campusid)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
