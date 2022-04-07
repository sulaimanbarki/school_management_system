<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategory = DB::select("
                SELECT sb.*, mc.main_category_name, co.company_name FROM `sub_categories` sb INNER JOIN main_categories mc ON sb.main_category_id = mc.id INNER JOIN companies co ON sb.company_id = co.id WHERE sb.campusid = mc.campusid AND sb.campusid = co.campusid AND sb.campusid = ?
            ", [Auth::user()->campusid]);
            return DataTables::of($subcategory)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editSubCategory"><i class="fas fa-edit"  title="Edit"></i></a>';
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
    public function store(SubCategoryRequest $request)
    {
        try {
            $request->validated();

            SubCategory::updateOrCreate(['id' => $request->subcategoryid], [
                'sub_category_name' => $request->sub_category_name,
                'company_id' => $request->company_id,
                'main_category_id' => $request->main_category_id,
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
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = SubCategory::where('main_category_id', $id)->where('campusid', Auth::user()->campusid)->get();
        return response()->json($subcategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = SubCategory::find($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}
