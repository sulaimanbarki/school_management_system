<?php

namespace App\Http\Controllers;

use App\Models\addClass;
use App\Models\addsection;
use App\Models\ClassWiseSection as ModelsClassWiseSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Buses;
use App\Models\StudentInfo;
use ClassWiseSection;
use Illuminate\Validation\Rule;

class AddClass_Section extends Controller
{
    public function index()
    {

        return view('admin.ClassAndSection');
    }

    public function FetchClasses()
    {
        $campusid = Auth::user()->campusid;
        $ClassData = addClass::where('CampusID', $campusid)->get();
        return response()->json(json_encode($ClassData));
    }

    public function ViewSections()
    {
        $campusid = Auth::user()->campusid;
        $SectionData = addsection::where('CampusID', $campusid)->get();
        return response()->json(json_encode($SectionData));
    }
    public function showclasswisesection()
    {
        $campusid = Auth::user()->campusid;
        $ClasswiseSectionData = ModelsClassWiseSection::where('CampusID', $campusid)->get();
        return response()->json(json_encode($ClasswiseSectionData));
    }

    public function ViewClasssWiseSection()
    {
        $campusid = Auth::user()->campusid;
        $ViewClasssWiseSection = DB::select("
        select * from classwisesection cw 
        inner join classes c
        on cw.classid=c.c_id inner join sections s on cw.sectionid=sec_id
        where cw.campusid=c.campusid and cw.campusid=s.campusid
        and cw.campusid = ?
        order by c.sequence asc, s.SectionSequence
        ", [$campusid]);
        // DB::select('select * from users where active = ?', [1])
        return response()->json(json_encode($ViewClasssWiseSection));
    }

    // assign sections to class
    public function SectionAssign(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $check = ModelsClassWiseSection::where('campusid', $campusid)->where('ClassID', $request->CWSectionClass)->where('SectionID', $request->CWSectionSection)->first();
        if (empty($check)) {
            //  return $check;
            $request->validate([
                'CWSectionClass' => 'required',
                'CWSectionSection' => 'required',
                'CWSectionSequence' => 'required|integer|between:1,20',
                'IsDisplay' => 'boolean',
                'CWSectionDate' => 'required|date'
            ]);

            $assignSection = new ModelsClassWiseSection();

            $assignSection->ClassID = $request->CWSectionClass;
            $assignSection->SectionID = $request->CWSectionSection;
            $assignSection->Sequence = $request->CWSectionSequence;
            $assignSection->isDisplay = $request->IsDisplay;
            $assignSection->campusid = $campusid;
            $assignSection->Date = $request->CWSectionDate;

            if ($assignSection->save()) {
                return response()->json(['result' => 'save']);
            } else {
                return response()->json(['error' => 'error']);
            }
        } else {
            return response()->json(['result' => 'Exist']);
        }
    }
    //ViewSections
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validate([
            'ClassName' => 'required|min:1|max:255',
            'ClassSequence' => 'required|integer|between:1,20'
        ]);
        $data_array = addClass::where('campusid', $campusid)->where('ClassName', $request->ClassName)->first();
        if (empty($data_array)) {
            // DB::unprepared('SET IDENTITY_INSERT Classes ON');
            $class = new addClass();
            $class->C_id = $request->Classid;
            $class->ClassName = $request->ClassName;
            $class->Campusid = $campusid;
            $class->IsDisplay = 1;
            $class->Sequence = $request->ClassSequence;
            if ($class->save()) {
                return response()->json(['result' => 'save']);
            } else {
                return response()->json(['result' => 'Error While Adding Campus']);
            }
        } else {
            return response()->json(['result' => 'true']);
        }
    }

    public function storeBus(Request $request)
    {

        $campusid = Auth::user()->campusid;
        $request->validate([
            'busnumber' => 'required|unique:buses,busnumber',
            'drivername' => 'required',
            'drivercontact' => 'required|min:11',
            'conductorname' => 'required',
            'route' => 'required',
            'busisdisplay' => 'boolean',
            'bussequence' => 'required|integer|between:1,20',
        ]);
        $bus = new Buses();
        $bus->busnumber = $request->busnumber;
        $bus->drivername = $request->drivername;
        $bus->drivercontact = $request->drivercontact;
        $bus->conductorname = $request->conductorname;
        $bus->route = $request->route;
        $bus->busisdisplay = $request->busisdisplay;
        $bus->bussequence = $request->bussequence;
        $bus->campusid = $campusid;
        if ($bus->save()) {
            return response()->json(['result' => 'Bus is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
        }
    }

    public function show()
    {
        //ontact::all()
        $campusid = Auth::user()->campusid;
        $ClassData = addClass::where('campusid', $campusid)->get();
        return response()->json(json_encode($ClassData));
    }

    // show buses
    public function showBuses()
    {
        $campusid = Auth::user()->campusid;
        $buses = Buses::where('campusid', $campusid)->get();

        return response()->json(json_encode($buses));
    }

    public function update(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validate([
            'ClassName' => ['required'],
            'ClassSequence' => 'required|integer|between:1,20'
        ]);

        $data_array = addClass::where('campusid', $campusid)->where('ClassName', $request->ClassName)->where('C_id', '<>', $request->Classid)->first();
        if (empty($data_array)) {
            addClass::where('C_id', $request->input('Classid'))->update([
                'ClassName' => $request->input('ClassName'),
                'Sequence' => $request->input('ClassSequence'),
            ]);
        } else {
            return response()->json(['result' => 'true']);
        }
    }

    // update bus
    public function updateBus(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $request->validate([
            'busnumber' => 'required',
            'drivername' => 'required',
            'drivercontact' => 'required|min:11',
            'conductorname' => 'required',
            'route' => 'required',
            'busisdisplay' => 'boolean',
            'bussequence' => 'required|integer|between:1,20',
        ]);
        // dd($request->input('oldbusname'));

        $checkbusInStudent = StudentInfo::where('campusid', $campusid)->where('busnumber', $request->input('oldbusnumber'))->first();
        $checkbusInEmployee = Admin::where('campusid', $campusid)->where('busnumber', $request->input('oldbusnumber'))->first();
        
        if(empty($checkbusInEmployee) and empty($checkbusInStudent)){
            $check = Buses::where('campusid', $campusid)->where('id', '<>', $request->input('busid'))->where('busnumber', $request->input('busnumber'))->first();
            if(empty($check)){
                Buses::where('campusid', $campusid)->where('id', $request->input('busid'))->update([
                    'busnumber' => $request->input('busnumber'),
                    'drivername' => $request->input('drivername'),
                    'drivercontact' => $request->input('drivercontact'),
                    'conductorname' => $request->input('conductorname'),
                    'route' => $request->input('route'),
                    'busisdisplay' => $request->input('busisdisplay'),
                    'bussequence' => $request->input('bussequence'),
                ]);
            }else{
                echo "duplicate";
                exit;
            }
        }else{
            Buses::where('campusid', $campusid)->where('id', $request->input('busid'))->update([
                'drivername' => $request->input('drivername'),
                'drivercontact' => $request->input('drivercontact'),
                'conductorname' => $request->input('conductorname'),
                'route' => $request->input('route'),
                'busisdisplay' => $request->input('busisdisplay'),
                'bussequence' => $request->input('bussequence'),
            ]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $campusid = Auth::user()->campusid;
        $check = StudentInfo::where('admissioninclass', $request->classid)->where('admissioninsection', $request->sectionid)->where('campusid', $campusid)->first();
        if (!empty($check)) {
            echo "exists";
            exit;
        }
        DB::table('classwisesection')->where('id', $request->classwisesectionid)->delete();
        return "Class Deleted Successfully";
        exit;
    }
}
