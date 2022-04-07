<?php

namespace App\Http\Controllers;

use App\Http\Requests\MainCategoryRequest;
use App\Models\MainCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maincategories = DB::select("
            SELECT mc.*, co.company_name FROM `main_categories` mc INNER JOIN companies co ON co.id = mc.company_id WHERE mc.campusid = co.campusid AND mc.campusid = ?
            ", [Auth::user()->campusid]);
            return DataTables::of($maincategories)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editMainCategory"><i class="fas fa-edit"  title="Edit"></i></a>';
                return $btn;
            })
            ->editColumn('isdisplay', function($row) {
                return ($row->isdisplay == 1 ? 'Yes' : 'No');
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
    public function store(MainCategoryRequest $request)
    {
        try {
            $request->validated();

            MainCategory::updateOrCreate(['id' => $request->maincategoryid], [
                'main_category_name' => $request->main_category_name,
                'company_id' => $request->company_id,
                'date' => $request->date,
                'isdisplay' => $request->isdisplay,
                'sequence' => $request->sequence,
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
     * @param  \App\Models\MainCategory  $mainCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::select("
        SELECT id, main_category_name FROM `main_categories` WHERE company_id = ? AND campusid = ?
        ", [$id, Auth::user()->campusid]);
        if ($id != 0) {
        }else{
            return MainCategory::where('campusid', Auth::user()->campusid)->get();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = MainCategory::find($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MainCategory  $mainCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MainCategory $mainCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MainCategory  $mainCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MainCategory $mainCategory)
    {
        //
    }
}
