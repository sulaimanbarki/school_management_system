<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.AddRole');
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
        //
        $campusid = Auth::user()->campusid;
        $request->validate([
            'Role' => 'required|min:1|max:255',
            'IsActive' => 'boolean',
            'Sequence' => 'required|integer|between:1,20',
        ]);
        $data_array = Role::where('campusid', $campusid)->where('Role', $request->Role)->first();
        if (empty($data_array)) {
            $session = new Role();
            $session->Role = $request->Role;
            $session->CampusID = $campusid;
            $session->IsActive = $request->IsActive;
            $session->Sequence = $request->Sequence;
            if ($session->save()) {
                return response()->json(['result' => 'save']);
            } else {
                return response()->json(['error' => 'Data is successfully added']);
            }
        } else {
            return response()->json(['result' => 'true']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
        $campusid = Auth::user()->campusid;
        $RoleData = Role::where('CampusID', '=', $campusid)->get();

        return response()->json(json_encode($RoleData));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'Role' => 'required|min:1|max:255',
            'IsActive' => 'boolean',
            'Sequence' => 'required|integer|between:1,20',
        ]);

        $campusid = Auth::user()->campusid;
        if(1 == (int)$request->input('RoleId')){
            return response()->json(['result' => 'superadmin']);
            exit;
        }
        $data_array = Role::where('CampusID', Auth::user()->campusid)->where('Role', $request->input('Role'))->where("RoleId", '<>', $request->input('RoleId'))->first();
        if (empty($data_array)) {
            Role::where('CampusID', $campusid)->where('RoleId', $request->input('RoleId'))->update([
                'Role' => $request->input('Role'),
                'IsActive' => $request->input('IsActive'),
                'Sequence' => $request->input('Sequence')
            ]);
        } else {
            return "Error";
        }
        return response()->json(['result' => 'save']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
