<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Item;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // join transactions with items on itemcode
        $transactions = DB::select("
            SELECT t.*, i.item_name
            FROM transactions t
            INNER JOIN items i ON i.itemcode = t.itemcode
            WHERE t.campusid = ? and t.campusid = i.campusid and t.transaction_type = 1
            ", [Auth::user()->campusid]);
        return DataTables::of($transactions)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editTransaction"><i class="fas fa-edit"  title="Edit"></i></a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="edit btn btn-danger btn-sm deleteTransaction"><i class="fas fa-trash"  title="Edit"></i></a>';
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
    public function store(TransactionRequest $request)
    {
        $request->request->add([
            'company_id' => Item::firstWhere('itemcode', $request->itemcode)->where('campusid', Auth::user()->campusid)->value('company_id'),
            'sequence' => rand(1, 20),
            'isdisplay' => 1,
        ]);
        try {
            $request->validated();
            Transaction::updateOrCreate(['id' => $request->stockid], [
                'billno' => 1,
                'itemcode' => $request->itemcode,
                'campusid' => Auth::user()->campusid,
                'company_id' => $request->company_id,
                'user_id' => Auth::user()->id,
                'saleman_id' => 1,
                'purchase_price' => $request->purchase_price,
                'sale_price' => $request->sale_price,
                'qty' => $request->qty,
                // transaction_type: 1-purchase, 2-sale, 3-transfer, 4-return
                'transaction_type' => 1,
                'date' => $request->date,
                'sequence' => $request->sequence,
                'isdisplay' => $request->isdisplay,
                'isdelete' => 0,
            ]);
            // increas quantity of items table
            Item::where('itemcode', $request->itemcode)->where('campusid', Auth::user()->campusid)->increment('qty', $request->qty);
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
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // join transactions with items on itemcode and id
        try {
            $transaction = DB::select("
            SELECT t.*, i.item_name
            FROM transactions t
            INNER JOIN items i ON i.itemcode = t.itemcode
            WHERE t.id = ? and t.campusid = i.campusid and t.campusid = ?
            ", [$id, Auth::user()->campusid]);
            return response()->json($transaction);
        } catch (Exception $e) {
            return response()->json([
                'success' => 'Duplicate Entry.',
                // 'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        // update transaction
        try {
            $request->validate([
                'itemcode' => 'required',
                'purchase_price' => 'required',
                'sale_price' => 'required',
                'qty' => 'required',
                'date' => 'required',
            ]);
            $transaction->update([
                'purchase_price' => $request->purchase_price,
                'sale_price' => $request->sale_price,
                // 'qty' => $request->qty,
                'date' => $request->date,
            ]);
            Transaction::where('id', $request->id)->increment('qty', $request->qty);
            Item::where('itemcode', $request->itemcode)->where('campusid', Auth::user()->campusid)->increment('qty', $request->qty);
        } catch (Exception $e) {
            return response()->json([
                'success' => 'Duplicate Entry.',
                // 'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($transaction)
    {
        try {
            // decrease qty of item based on transaction id
            $qty = Transaction::where('id', $transaction)->value('qty');
            Item::where('itemcode', Transaction::where('id', $transaction)->value('itemcode'))->where('campusid', Auth::user()->campusid)->decrement('qty', $qty);
            Transaction::where('id', $transaction)->delete();
        } catch (Exception $e) {
            return response()->json([
                'success' => 'Duplicate Entry.',
                // 'error' => $e->getMessage(),
            ], 400);
        }
    }
}
