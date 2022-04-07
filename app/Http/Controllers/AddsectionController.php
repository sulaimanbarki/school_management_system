<?php

namespace App\Http\Controllers;

use App\Models\addClass;
use App\Models\addsection;
use App\Models\classwisesection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddsectionController extends Controller
{
    public function store(Request $request)
    {
        $campusid = Auth::user()->campusid;
        // check campus wise
        $request->validate([
            // 'slug' => 'unique:pages,slug,NULL,id,category,' . $catid,
            'SectionName' => 'required',
            'SectionSequence' => 'required|integer|between:1,20'
        ]);
        $data_array = addsection::where('campusid', $campusid)->where('SectionName', $request->SectionName)->first();

        if (empty($data_array)) {
            $class = new addsection();
            $class->SectionName = $request->SectionName;
            $class->SectionSequence = $request->SectionSequence;
            $class->campusid = Auth::user()->campusid;

            if ($class->save()) {
                return response()->json(['result' => 'save']);
            } else {
                return response()->json(['error' => 'issuein structure']);
            }
        } else {
            return response()->json(['result' => 'true']);
        }
    }



    public function show()
    {
        //ontact::all()
        $campusid = Auth::user()->campusid;
        $SectionData = addsection::where('campusid', '=', $campusid)->get();
        // dd($CampusData);

        return response()->json(json_encode($SectionData));
    }


    public function showSectionForClass(Request $request)
    {
        //ontact::all()
        $campusid = Auth::user()->campusid;
        $cid = $request->classId;
        $SectionData = DB::select("
            SELECT * from `classwisesection` cw, sections s
            where cw.classid = ? and cw.sectionid = s.sec_id
            and cw.campusid = s.campusid and cw.campusid = ?
            and cw.isdisplay = 1

        ", [$cid, $campusid]);

        return response()->json(json_encode($SectionData));
    }
    public function update(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validate([
            'SectionSequence' => 'required|integer|between:1,20'
        ]);

        $data_array = addsection::where('campusid', $campusid)->where('SectionName', $request->input('SectionName'))->where('Sec_ID', '<>', $request->input('SectionId'))->first();
        if (empty($data_array)) {
            addsection::where('campusid', $campusid)->where('Sec_ID', $request->input('SectionId'))->update([
                'SectionName' => $request->input('SectionName'),
                'SectionSequence' => $request->input('SectionSequence'),
            ]);
        } else {
            return response()->json(['result' => 'true']);
        }
    }
}
