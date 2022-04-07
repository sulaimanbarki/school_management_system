<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Echo_;

class RolesAndPages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {


        $response = '';
        $response = $next($request);
        $a = $request->path();
        if ($a != "admin/login") {
            $authId = auth()->id();

            if (empty($authId)) {
                return redirect("admin/login");
            }
            $generateFee = DB::select("select * from admins where id = ?", [$authId]);
            $roleid = $generateFee[0]->roleid;

            $campusid = $generateFee[0]->campusid;
            $a = $request->path();

            $generateFee = DB::select("SELECT * FROM pages p , role_pages r
            where r.campusid='$campusid' and role_id='$roleid' and r.campusid=p.campusid
            and p.page_id=r.pages_id and p.page_link='$a'");
            if (empty($generateFee)) {
                //dd("plz");
                //  return redirect("NewAdmission");

            } else {
                return $response;
            }
        }
        return $response;
        //  dd($authId);




        // print_r($generateFee);
        // return $next($request);
    }
}
