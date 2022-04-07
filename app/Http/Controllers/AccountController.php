<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Accounts()
    {
        return view('admin.Accounts');
    }

    public function index()
    {
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
    public function store(AccountRequest $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validated();
        $data_array = Account::where('campusid', $campusid)->where('accountname', $request->accountname)->first();

        if (empty($data_array)) {
            $class = new Account();
            $class->accountname = $request->accountname;
            $class->accountnumber = $request->accountnumber;
            $class->account_desc = $request->account_desc;
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
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return Account::where('campusid', Auth::user()->campusid)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(AccountRequest $request,$account)
    {
        $request->validated();
        $campusid = Auth::user()->campusid;
        $data_array = Account::where('campusid', $campusid)->where('accountname', $request->accountname)->where('id', '<>', $account)->first();
        if (empty($data_array)) {
            $jobs = Account::where('campusid', $campusid)->where('id', $account)->update([
                'accountname' => $request->accountname,
                'accountnumber' => $request->accountnumber,
                'account_desc' => $request->account_desc,
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
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
