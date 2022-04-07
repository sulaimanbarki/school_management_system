<?php

namespace App\Http\Controllers;

use App\Models\RoleWisePages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPages extends Controller
{
    //

    public function index()
    {
        //
        // $UserID = Auth::admin()->id;

        return view('admin.AdminPages.AdminPages');
    }
    public function index1()
    {
        //
        // $UserID = Auth::admin()->id;

        return view('admin.Res');
    }
    public function PagesRoleWise()
    {
        return view('admin.AdminPages.PagesRoleWise');
    }


    public function PagesRoleWiseLoad(Request $request)
    {





        $role_id = $request->role_id;

        $cid = Auth::user()->campusid;
        $AllPages = DB::select("
        SELECT p.*, il.icon_fa,r.role_id,r.pages_id FROM icons il INNER JOIN pages p ON
        p.icon_id = il.icon_id and il.campusid=p.campusid Left JOIN role_pages r ON
        p.page_id=r.pages_id and p.campusid=r.campusid and p.campusid=? and role_id=?
         ORDER BY p.page_order, p.page_title
        ",[$cid,$role_id]);

        return response()->json(json_encode($AllPages));
    }

    public function UpdatePagesRole(Request $request)
    {
        $cid = Auth::user()->campusid;
        $checkStatus = $request->checkStatus;
        $role_id = $request->role_id;
        $page_id = $request->page_id;
        for ($i=0; $i < count($checkStatus); $i++) {
            if($checkStatus[$i]){
                //if exists then do not duplicate
                if(RoleWisePages::where('campusid', $cid)->where('role_id', $role_id[$i])->where('pages_id', $page_id[$i])->first()){

                }else{
                    // echo $checkStatus[$i];
                    $role = new RoleWisePages();
                    $role->role_id = $role_id[$i];
                    $role->pages_id = $page_id[$i];
                    $role->campusid = $cid;
                    $role->save();
                }
            }else{
                RoleWisePages::where('campusid', $cid)->where('role_id', $role_id[$i])->where('pages_id', $page_id[$i])->delete();
            }
        }
    }
}
