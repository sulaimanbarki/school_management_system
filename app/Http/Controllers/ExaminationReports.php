<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExaminationReports extends Controller
{
    public function index()
    {
        return view('admin.Examination.ExaminationReports');
    }
    public function ClassAndSectionWiseResult(Request $r)
    {


        //  DD($r->input());
        return view('admin.Examination.ClassWiseResultDMC',['request' => $r]);
    }
    
}
