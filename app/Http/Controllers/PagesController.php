<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagesRequest;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select("
            SELECT * FROM `pages` p, icons i WHERE p.icon_id = i.icon_id AND p.campusid = i.campusid AND p.campusid = ? 
        ", [Auth::user()->campusid]);
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
    public function store(PagesRequest $request)
    {
        $request->validated();

        $page = new Pages();
        $page->page_head = $request->page_head;
        $page->page_title = $request->page_title;
        $page->page_link = $request->page_link;
        $page->page_type = $request->page_type;
        $page->icon_id = $request->page_icon_id;
        $page->page_order = 100;
        $page->campusid = Auth::user()->campusid;

        if ($page->save()) {
            return response()->json(['result' => 'Employee is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function show(Pages $pages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function edit(Pages $pages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function update(PagesRequest $request, $id)
    {
        $request->validated();
        $campusid = Auth::user()->campusid;
        Pages::where('campusid', $campusid)->where('page_id', $id)->update([
            'page_head' => $request->page_head,
            'page_title' => $request->page_title,
            'page_link' => $request->page_link,
            'page_type' => $request->page_type,
            'icon_id' => $request->page_icon_id,
        ]);

        return response('', 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pages  $pages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pages $pages)
    {
        //
    }
}
