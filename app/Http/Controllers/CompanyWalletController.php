<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyWalletRequest;
use App\Models\CompanyWallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CompanyWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select all from company wallet and company name from company table
        $companyWallets = CompanyWallet::join('companies', 'companies.id', '=', 'company_wallets.company_id')
            ->select('company_wallets.*', 'companies.company_name')
            ->where('company_wallets.campusid', Auth::user()->campusid)
            ->get();
        return DataTables::of($companyWallets)
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
    public function store(CompanyWalletRequest $request)
    {
        try {
            $request->validated();
            CompanyWallet::updateOrCreate(['id' => $request->walletid], [
                'company_id' => $request->company_id,
                'wallet_type' => 'advanced',
                'amount' => $request->amount,
                'description' => $request->description,
                'date' => $request->date,
                'campusid' => Auth::user()->campusid,
            ]);
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
     * @param  \App\Models\CompanyWallet  $companyWallet
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyWallet $companyWallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyWallet  $companyWallet
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = CompanyWallet::find($id);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyWallet  $companyWallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyWallet $companyWallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyWallet  $companyWallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyWallet $companyWallet)
    {
        //
    }
}
