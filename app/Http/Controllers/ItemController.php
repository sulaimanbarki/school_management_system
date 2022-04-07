<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // join items with main categories, sub categories, and companies
        $items = DB::select("
            SELECT i.*, mc.main_category_name AS maincategory, sc.sub_category_name AS subcategory, co.company_name AS company
            FROM items i
            INNER JOIN main_categories mc ON mc.id = i.main_category_id and mc.campusid = i.campusid
            INNER JOIN sub_categories sc ON sc.id = i.sub_category_id and sc.campusid = i.campusid
            INNER JOIN companies co ON co.id = i.company_id and co.campusid = i.campusid

            WHERE i.campusid = co.campusid AND i.campusid = ?
            ", [Auth::user()->campusid]);
        return DataTables::of($items)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fas fa-edit"  title="Edit"></i></a>';
                return $btn;
            })
            ->editColumn('isdisplay', function ($row) {
                return ($row->isdisplay == 1 ? 'Yes' : 'No');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function ItemsPage()
    {
        return view('admin.Inventory.Items');
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
    public function store(ItemRequest $request)
    {
        try {
            $request->validated();
            // store item code from item table based on d
            $itemcode = DB::select("
                SELECT itemcode FROM items WHERE id = ? and campusid = ?
            ", [$request->itemid, Auth::user()->campusid]);
            // alter table drop foriegn key
            DB::statement('ALTER TABLE transactions DROP FOREIGN KEY transactions_itemcode_foreign');
            Item::updateOrCreate(['id' => $request->itemid], [
                'itemcode' => $request->itemcode,
                'item_name' => $request->item_name,
                'company_id' => $request->company_id,
                'main_category_id' => $request->main_category_id,
                'sub_category_id' => $request->sub_category_id,
                'unit' => $request->unit,
                'purchase_price' => $request->purchase_price,
                'sale_price' => $request->sale_price,
                'added_date' => date('Y-m-d'),
                // 'qty' => 0,
                'isdisplay' => $request->isdisplay,
                'sequence' => $request->sequence,
                'campusid' => Auth::user()->campusid,
            ]);
            if (!empty($itemcode)) {
                DB::update("
                UPDATE transactions SET itemcode = ? WHERE itemcode = ? and campusid = ?
                ", [$request->itemcode, $itemcode[0]->itemcode, Auth::user()->campusid]);
            }
            // alter table add foriegn key transactions_itemcode_foreign on transactions(itemcode)
            DB::statement('ALTER TABLE transactions ADD FOREIGN KEY transactions_itemcode_foreign(itemcode) REFERENCES items(itemcode) ON DELETE CASCADE ON UPDATE CASCADE');
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
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        //fetch item details
        $item = Item::firstWhere('itemcode', $item);
        return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $item = Item::find($item->id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
