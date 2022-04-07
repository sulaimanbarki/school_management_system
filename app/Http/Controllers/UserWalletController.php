<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserWalletRequest;
use App\Models\UserWallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // join the user_wallets table with admins table to get the user name
        $userwallets = UserWallet::join('admins', 'user_wallets.user_id', '=', 'admins.id')
            ->select('user_wallets.*', 'admins.name')
            ->where('user_wallets.campusid', Auth::user()->campusid)
            ->get();
        return DataTables::of($userwallets)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edituserwallet"><i class="fas fa-edit"  title="Edit"></i></a>';
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
    public function store(UserWalletRequest $request)
    {
        try {
            $request->validated();
            UserWallet::updateOrCreate(['id' => $request->userwalletid], [
                'user_id' => $request->user_id,
                'wallet_type' => 'user_paid',
                'amount' => $request->amount,
                'description' => $request->description,
                'date' => $request->date,
                'campusid' => Auth::user()->campusid,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => 'Duplicate Entry.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserWallet  $userWallet
     * @return \Illuminate\Http\Response
     */
    public function show(UserWallet $userWallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserWallet  $userWallet
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = UserWallet::find($id);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserWallet  $userWallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserWallet $userWallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserWallet  $userWallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserWallet $userWallet)
    {
        //
    }
}
