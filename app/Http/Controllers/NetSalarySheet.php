<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NetSalarySheet extends Controller
{
    //
    public function index()
    {
        return view('admin.Salary.SalarySheet');
    }
    
    public function index2(Request $r)
    {
        return view('admin.Salary.SalarySheet', ['request' => $r]);
    }

}
