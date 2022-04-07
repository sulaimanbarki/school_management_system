<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Admin;
use App\Models\Item;
use App\Models\Role;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddStock extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AddStock()
    {
        return view('admin.Inventory.AddStock');
    }

    public function StockStatistics()
    {
        return view('admin.Inventory.StockStatistics');
    }

    public function CounterSale()
    {
        return view('admin.Inventory.CounterSale');
    }

    public function Payments()
    {
        return view('admin.Inventory.Payments');
    }

    public function InventoryReports()
    {
        return view('admin.Inventory.InventoryReports');
    }

    public function index()
    {
    }

    public function loadUsers()
    {
        $roleid = Role::where('campusid', Auth::user()->campusid)->where('Role', 'teacher')->value('RoleId');
        $users = Admin::where('campusid', Auth::user()->campusid)->where('roleid', $roleid)->get(['id', 'name']);
        return response()->json($users);
    }

    public function getUserBillNumber()
    {
        $billno = DB::table('users_bills')->where('campusid', Auth::user()->campusid)->max('bill_number');
        if ($billno == null) {
            $billno = 1;
        } else {
            $billno = $billno + 1;
        }
        return response()->json($billno);
    }

    public function PrintDispatch()
    {
        return view('admin.Inventory.PrintDispatch');
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
        $itemslists = $request->itemslists;
        $user = $request->user;
        $paid = $request->paid;
        $date = $request->date;
        // get maximum bill_number from users_bills table
        $billno = DB::table('users_bills')->where('campusid', Auth::user()->campusid)->max('bill_number');
        $size = count($itemslists);
        if ($billno == null) {
            $billno = 1;
        } else {
            $billno = $billno + 1;
        }
        for ($i = 0; $i < $size; $i++) {
            try {
                Transaction::updateOrCreate(['id' => -2], [
                    'billno' => $billno,
                    'itemcode' => $itemslists[$i]['itemcode'],
                    'campusid' => Auth::user()->campusid,
                    'company_id' => Item::firstWhere('itemcode', $itemslists[$i]['itemcode'])->where('campusid', Auth::user()->campusid)->value('company_id'),
                    'user_id' => Auth::user()->id,
                    'saleman_id' => 1,
                    'purchase_price' => $itemslists[$i]['purchase_price'],
                    'sale_price' => $itemslists[$i]['sale_price'],
                    'qty' => $itemslists[$i]['qty'],
                    // transaction_type: 1-purchase, 2-sale, 3-transfer, 4-return
                    'transaction_type' => 2,
                    'date' => $date,
                    'sequence' => 1,
                    'isdisplay' => 1,
                    'isdelete' => 0,
                ]);
                Item::where('itemcode', $itemslists[$i]['itemcode'])->where('campusid', Auth::user()->campusid)->decrement('qty', $itemslists[$i]['qty']);
            } catch (Exception $e) {
                return response()->json([
                    'success' => 'Duplicate Entry.',
                    // 'error' => $e->getMessage(),
                ], 400);
            }
        }
        try {
            DB::table('users_bills')->insert([
                'bill_number' => $billno,
                'campusid' => Auth::user()->campusid,
                'date' => $date,
            ]);
            // insert into user_wallets table
            DB::table('user_wallets')->insert([
                'user_id' => $user,
                'wallet_type' => 'counter',
                'description' => 'Counter Sale',
                'amount' => $paid,
                'date' => $date,
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
