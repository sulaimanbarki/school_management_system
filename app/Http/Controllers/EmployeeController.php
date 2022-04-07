<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Scale;
use App\Models\StaffBasicPaySalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.AddEmployee');
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
        $campusid = Auth::user()->campusid;

        // validate
        if (!empty($request->addCampusAdmin)) {
            $campusid = $request->addCampusAdmin;
        }

        $request->validate([
            'name' => 'required|min:1|max:255',
            'fname' => 'required|min:1|max:255',
            'cnic' => 'required|unique:admins',
            'empRole' => 'required',
            'gender' => 'required|in:Male,Female,Transgender',
            'email' => 'required|unique:admins,email',
            'password' => 'required|min:8|max:255',
            'phone1' => 'required|min:10|max:11',
            'phone2' => '',
            'address1' => 'required',
            'address2' => '',
            'joindate' => 'required',
            'isactiveemployee' => 'required',
            'empindepartment' => 'required|exists:departments,id',
            'empscale' => 'required|exists:scales,id',
            'fixedsalary' => 'required|in:0,1',
            'profilepicture' => 'mimes:jpg,jpeg,png|max:2048',
            'busnumber' => '',
        ]);

        $imgname = "";
        if ($request->profilepicture) {
            $imgname =  "profilepicture-" . time() . "." . $request->profilepicture->extension();
            $request->profilepicture->move(public_path('profilepicture'), $imgname);
        }

        //store
        $emp = new Admin();

        $emp->name = $request->name;
        $emp->fname = $request->fname;
        $emp->cnic = $request->cnic;
        $emp->roleid = $request->empRole;
        $emp->gender = $request->gender;
        $emp->email = $request->email;
        $emp->password = Hash::make($request->password);
        $emp->phone1 = $request->phone1;
        $emp->phone2 = $request->phone2;
        $emp->address1 = $request->address1;
        $emp->address2 = $request->address2;
        $emp->joindate = $request->joindate;
        $emp->isactive = $request->isactiveemployee;
        $emp->departmentid = $request->empindepartment;
        $emp->scaleid = $request->empscale;
        $emp->fixedsalary = $request->fixedsalary;
        $emp->profile_photo_path = $imgname;
        $emp->campusid = $campusid;
        $emp->busnumber = $request->busnumber;

        if ($emp->save()) {
            $basicpaysalary = Scale::where('campusid', $campusid)->where('id', $request->empscale)->value('basicpay');
            try {
                $ebps = new StaffBasicPaySalary();
                $ebps->empid = $emp->id;
                $ebps->amount = $basicpaysalary;
                $ebps->date = date('Y-m-d');
                $ebps->status = 1;
                $ebps->campusid = $campusid;
                $ebps->save();
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }

            return response()->json(['result' => 'Employee is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
        }
    }

    public function show()
    {
        $campusid = Auth::user()->campusid;
        $superAdmin = Auth::user()->id;
        $emp = "";
        if ($superAdmin == 1) {
            $emp = DB::select("SELECT * FROM `admins` ad, configurations cm, roles r
            WHERE ad.campusid = cm.campusid and r.RoleId = ad.roleid");
            // $emp = Admin::all();
        } else {
            $emp = DB::select("SELECT * FROM `admins` ad, configurations cm, roles r
            WHERE ad.campusid = cm.campusid AND ad.campusid = ? and r.campusid = ? and r.campusid = cm.campusid", [$campusid, $campusid]);

            // $emp = Admin::where('campusid', $campusid)->get();
        }
        return response()->json(json_encode($emp));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $campusid = Auth::user()->campusid;

        if ($request->addCampusAdmin) {
            $campusid = $request->addCampusAdmin;
        }
        // dd($campusid);
        $request->validate([
            'name' => 'required|min:1|max:255',
            'fname' => 'required|min:1|max:255',
            'cnic' => 'required|min:1|unique:admins,cnic,' . $request->id,
            'empRole' => 'required',
            'gender' => 'required|in:Male,Female,Transgender',
            'email' => 'required|unique:admins,email,' . $request->id,
            'password' => 'required|min:8|max:255',
            'phone1' => 'required|min:10|max:11',
            'phone2' => '',
            'address1' => 'required',
            'address2' => '',
            'joindate' => 'required',
            'isactiveemployee' => 'required',
            'empindepartment' => 'required|exists:departments,id',
            'empscale' => 'required|exists:scales,id',
            'fixedsalary' => 'required|in:0,1',
            'profilepicture' => 'mimes:jpg,jpeg,png|max:2048',
            'busnumber' => '',
        ]);

        $imgname = Admin::where('id', $request->id)->value('profile_photo_path');

        if ($request->profilepicture) {
            if (File::exists("profilepicture/" . Admin::where('id', $request->id)->value('profile_photo_path'))) {
                File::delete("profilepicture/" . Admin::where('id', $request->id)->value('profile_photo_path'));
            }

            $imgname =  "profilepicture-" . time() . "." . $request->profilepicture->extension();
            $request->profilepicture->move(public_path('profilepicture'), $imgname);
        }

        if ($request->input('addCampusAdmin')) {
            try {
                Admin::where('id', $request->input('id'))->update([
                    'name' => $request->input('name'),
                    'fname' => $request->input('fname'),
                    'cnic' => $request->input('cnic'),
                    'roleid' => $request->input('empRole'),
                    'gender' => $request->input('gender'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->password),
                    'phone1' => $request->input('phone1'),
                    'phone2' => $request->input('phone2'),
                    'address1' => $request->input('address1'),
                    'address2' => $request->input('address2'),
                    'joindate' => $request->input('joindate'),
                    'isactive' => $request->input('isactiveemployee'),
                    'departmentid' => $request->input('empindepartment'),
                    'scaleid' => $request->input('empscale'),
                    'fixedsalary' => $request->input('fixedsalary'),
                    'profile_photo_path' => $imgname,
                    'campusid' => $campusid,
                    'busnumber' => $request->input('busnumber'),
                ]);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        } else {
            Admin::where('campusid', $campusid)->where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'fname' => $request->input('fname'),
                'cnic' => $request->input('cnic'),
                'roleid' => $request->input('empRole'),
                'gender' => $request->input('gender'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->password),
                'phone1' => $request->input('phone1'),
                'phone2' => $request->input('phone2'),
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'joindate' => $request->input('joindate'),
                'isactive' => $request->input('isactiveemployee'),
                'profile_photo_path' => $imgname,
                'busnumber' => $request->input('busnumber'),
            ]);
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
