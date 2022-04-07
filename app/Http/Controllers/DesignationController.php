<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
        $campusid = Auth::user()->campusid;
        $request->validate([
            'name' => 'required|min:1|max:255',
            'bps' => 'required',
            'isactive' => 'boolean',
            'sequence' => 'required|integer|between:1,20'
        ]);

        $data_array = Designation::where('campusid', $campusid)->where('name', $request->name)->first();
        if (empty($data_array)) {
            $des = new Designation();
            $des->name = $request->name;
            $des->bps = $request->bps;
            $des->isactive = $request->isactive;
            $des->sequence = $request->sequence;
            $des->campusid = $campusid;

            if ($des->save()) {
                return response()->json(['result' => 'Employee is successfully added']);
            } else {
                return response()->json(['error' => 'Data is successfully added']);
            }
        } else {
            echo 'duplicate';
            exit;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $campusid = Auth::user()->campusid;
        $des = Designation::where('campusid', '=', $campusid)->get();
        return response()->json(json_encode($des));
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
    public function update(Request $request)
    {
        //
        $campusid = Auth::user()->campusid;
        $request->validate([
            'name' => 'required|min:1|max:255',
            'bps' => 'required',
            'isactive' => 'boolean',
            'sequence' => 'required|integer|between:1,20'
        ]);

        $data_array = Designation::where('campusid', $campusid)->where('name', $request->name)->where('id', '<>', $request->input('id'))->first();
        if (empty($data_array)) {
            $jobs = Designation::where('campusid', $campusid)->where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'bps' => $request->input('bps'),
                'isactive' => $request->input('isactive'),
                'sequence' => $request->input('sequence')
            ]);
        } else {
            echo 'duplicate';
            exit;
        }
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
