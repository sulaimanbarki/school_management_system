<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\addCampus;
use App\Models\addClass;
use Illuminate\Support\Facades\File;
use App\Models\Admin;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class Campus extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware(['admin']);
    // }
    public function index()
    {
        //
        // $UserID = Auth::admin()->id;

        return view('admin.AddCampus');
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
        $addCampus = new addCampus();

        $pattern = "/-$/i";

        if (!preg_match($pattern, $request->CampusPrefix)) {
            $request->CampusPrefix .= "-";
        }

        $request->validate([
            'CampusName' => 'required|min:1|max:255',
            'CampusEmail' => 'required|unique:configurations,CampusEmail',
            'CampusPrefix' => 'required|min:1|max:8|unique:configurations,CampusPrefix',
            'DefaultReligion' => 'required',
            'Phone' => 'required|min:1|max:11',
            'Phone1' => 'required|min:1|max:11',
            'DefaultAddress' => 'required|min:1|max:255',
            'DefaultAddress1' => 'min:1|max:255',
            'BankName' => '',
            'AccountNumber' => '',
            'RegistrationDate' => 'min:1|max:255',
            'SchoolStatus' => 'required|min:1|max:255',
            'image' => 'mimes:jpg,jpeg,png|max:5048',
            'banklogo' => 'mimes:jpg,jpeg,png|max:5048'
        ]);
        $imgname =  "CampusLogos-" . time() . "." . $request->image->extension();
        $request->image->move(public_path('CampusLogos'), $imgname);

        $banklogopath =  "banklogo-" . time() . "." . $request->banklogo->extension();
        $request->banklogo->move(public_path('banklogo'), $banklogopath);

        $addCampus->CampusPrefix = $request->CampusPrefix;
        $addCampus->CampusName = $request->CampusName;
        $addCampus->CampusEmail = $request->CampusEmail;
        $addCampus->DefaultBoard = $request->CampusName;
        $addCampus->DefaultReligion = $request->DefaultReligion;
        $addCampus->Phone = $request->Phone;
        $addCampus->Phone1 = $request->Phone1;
        $addCampus->DefaultAddress = $request->DefaultAddress;
        $addCampus->DefaultAddress1 = $request->DefaultAddress1;
        $addCampus->BankName = $request->BankName;
        $addCampus->AccountNumber = $request->AccountNumber;
        $addCampus->RegistraionDate = $request->RegistrationDate;
        $addCampus->Logo_photo_path = $imgname;
        $addCampus->banklogo = $banklogopath;
        $addCampus->SchoolStatus = $request->SchoolStatus;
        if ($addCampus->save()) {
            return response()->json(['result' => 'Campus is successfully added']);
        } else {
            return response()->json(['error' => 'Data is successfully added']);
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
        //ontact::all()
        // auth3

        $CampusData = addCampus::all();
        // dd($CampusData);

        return response()->json(json_encode($CampusData));
    }

    public function UpdateCampus()
    {

        $CampusData = addCampus::all();
        return response()->json(json_encode($CampusData));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!empty($request->CampusPrefix)) {
            $checking = addClass::where('campusid', $request->campusid)->first();
            if (!empty($checking)) {
                $request->validate([
                    'CampusName' => 'required|min:1|max:255',
                    // 'CampusEmail' => 'required|unique:configurations,CampusEmail,' . $request->campusid . 'campusid',
                    'CampusEmail' => ['required', Rule::unique('configurations')->ignore($request->campusid, 'campusid')],
                    // 'CampusPrefix' => ['required', Rule::unique('configurations')->ignore($request->campusid, 'campusid')],
                    'DefaultReligion' => 'required',
                    'DefaultBoard' => 'required',
                    'Phone' => 'required|min:1|max:255',
                    'Phone1' => '',
                    'DefaultAddress' => 'required|min:1|max:255',
                    'DefaultAddress1' => '',
                    'BankName' => 'min:1|max:255',
                    'AccountNumber' => 'min:1|max:255',
                    'SchoolStatus' => 'required|min:1|max:255',
                    'image' => 'mimes:jpg,jpeg,png|max:5048',
                    'banklogo' => 'mimes:jpg,jpeg,png|max:5048'
                ]);

                $imgname = addCampus::where('campusid', $request->campusid)->value('Logo_photo_path');

                if ($request->image) {
                    if (File::exists("CampusLogos/" . addCampus::where('campusid', $request->campusid)->value('Logo_photo_path'))) {
                        File::delete("CampusLogos/" . addCampus::where('campusid', $request->campusid)->value('Logo_photo_path'));
                    }

                    $imgname =  "CampusLogos-" . time() . "." . $request->image->extension();
                    $request->image->move(public_path('CampusLogos'), $imgname);
                }

                // take the default value which exists in database,,, if the user upload new logo, the old one will be replace
                $banklogopath = addCampus::where('campusid', $request->campusid)->value('banklogo');
                if ($request->banklogo) {
                    if (File::exists("banklogo/" . addCampus::where('campusid', $request->campusid)->value('banklogo'))) {
                        File::delete("banklogo/" . addCampus::where('campusid', $request->campusid)->value('banklogo'));
                    }
                    $banklogopath =  "banklogo-" . time() . "." . $request->banklogo->extension();
                    $request->banklogo->move(public_path('banklogo'), $banklogopath);
                }

                $pattern = "/-$/i";

                if (!preg_match($pattern, $request->CampusPrefix)) {
                    $request->CampusPrefix .= "-";
                }

                addCampus::where('campusid', $request->input('campusid'))->update([
                    'CampusName' => $request->input('CampusName'),
                    'CampusEmail' => $request->input('CampusEmail'),
                    // 'CampusPrefix' => $request->CampusPrefix,
                    'DefaultBoard' => $request->input('DefaultBoard'),
                    'DefaultReligion' => $request->input('DefaultReligion'),
                    'Phone' => $request->input('Phone'),
                    'Phone1' => $request->input('Phone1'),
                    'BankName' => $request->input('BankName'),
                    'AccountNumber' => $request->input('AccountNumber'),
                    'RegistraionDate' => $request->input('RegistrationDate'),
                    'Logo_photo_path' => $imgname,
                    'banklogo' => $banklogopath,
                    'banklogo' => $banklogopath,
                    'SchoolStatus' => $request->input('SchoolStatus'),
                    'DefaultAddress' => $request->input('DefaultAddress'),
                    'DefaultAddress1' => $request->input('DefaultAddress1'),
                ]);

                echo 'exists';
                exit;
            } else {
                $request->validate([
                    'CampusName' => 'required|min:1|max:255',
                    'CampusEmail' => 'required|unique:configurations,CampusEmail,' . $request->campusid . 'campusid',
                    'CampusEmail' => ['required', Rule::unique('configurations')->ignore($request->campusid, 'campusid')],
                    'CampusPrefix' => ['required', Rule::unique('configurations')->ignore($request->campusid, 'campusid')],
                    'DefaultReligion' => 'required',
                    'DefaultBoard' => 'required',
                    'Phone' => 'required|min:1|max:255',
                    'Phone1' => '',
                    'DefaultAddress' => 'required|min:1|max:255',
                    'DefaultAddress1' => '',
                    'BankName' => 'min:1|max:255',
                    'AccountNumber' => 'min:1|max:255',
                    'SchoolStatus' => 'required|min:1|max:255',
                    'image' => 'mimes:jpg,jpeg,png|max:5048',
                    'banklogo' => 'mimes:jpg,jpeg,png|max:5048'
                ]);

                $imgname = addCampus::where('campusid', $request->campusid)->value('Logo_photo_path');

                if ($request->image) {
                    if (File::exists("CampusLogos/" . addCampus::where('campusid', $request->campusid)->value('Logo_photo_path'))) {
                        File::delete("CampusLogos/" . addCampus::where('campusid', $request->campusid)->value('Logo_photo_path'));
                    }

                    $imgname =  "CampusLogos-" . time() . "." . $request->image->extension();
                    $request->image->move(public_path('CampusLogos'), $imgname);
                }

                // take the default value which exists in database,,, if the user upload new logo, the old one will be replace
                $banklogopath = addCampus::where('campusid', $request->campusid)->value('banklogo');
                if ($request->banklogo) {
                    if (File::exists("banklogo/" . addCampus::where('campusid', $request->campusid)->value('banklogo'))) {
                        File::delete("banklogo/" . addCampus::where('campusid', $request->campusid)->value('banklogo'));
                    }
                    $banklogopath =  "banklogo-" . time() . "." . $request->banklogo->extension();
                    $request->banklogo->move(public_path('banklogo'), $banklogopath);
                }

                $pattern = "/-$/i";

                if (!preg_match($pattern, $request->CampusPrefix)) {
                    $request->CampusPrefix .= "-";
                }

                addCampus::where('campusid', $request->input('campusid'))->update([
                    'CampusName' => $request->input('CampusName'),
                    'CampusEmail' => $request->input('CampusEmail'),
                    'CampusPrefix' => $request->CampusPrefix,
                    'DefaultBoard' => $request->input('DefaultBoard'),
                    'DefaultReligion' => $request->input('DefaultReligion'),
                    'Phone' => $request->input('Phone'),
                    'Phone1' => $request->input('Phone1'),
                    'BankName' => $request->input('BankName'),
                    'AccountNumber' => $request->input('AccountNumber'),
                    'RegistraionDate' => $request->input('RegistrationDate'),
                    'Logo_photo_path' => $imgname,
                    'banklogo' => $banklogopath,
                    'banklogo' => $banklogopath,
                    'SchoolStatus' => $request->input('SchoolStatus'),
                    'DefaultAddress' => $request->input('DefaultAddress'),
                    'DefaultAddress1' => $request->input('DefaultAddress1'),
                ]);
            }
        } else {
            $request->validate([
                'CampusName' => 'required|min:1|max:255',
                'CampusEmail' => 'required|unique:configurations,CampusEmail,' . $request->campusid . 'campusid',
                'CampusEmail' => ['required', Rule::unique('configurations')->ignore($request->campusid, 'campusid')],
                // 'CampusPrefix' => ['required', Rule::unique('configurations')->ignore($request->campusid, 'campusid')],
                'DefaultReligion' => 'required',
                'DefaultBoard' => 'required',
                'Phone' => 'required|min:1|max:255',
                'Phone1' => '',
                'DefaultAddress' => 'required|min:1|max:255',
                'DefaultAddress1' => '',
                'BankName' => 'min:1|max:255',
                'AccountNumber' => 'min:1|max:255',
                'SchoolStatus' => 'required|min:1|max:255',
                'image' => 'mimes:jpg,jpeg,png|max:5048',
                'banklogo' => 'mimes:jpg,jpeg,png|max:5048'
            ]);

            $imgname = addCampus::where('campusid', $request->campusid)->value('Logo_photo_path');

            if ($request->image) {
                if (File::exists("CampusLogos/" . addCampus::where('campusid', $request->campusid)->value('Logo_photo_path'))) {
                    File::delete("CampusLogos/" . addCampus::where('campusid', $request->campusid)->value('Logo_photo_path'));
                }

                $imgname =  "CampusLogos-" . time() . "." . $request->image->extension();
                $request->image->move(public_path('CampusLogos'), $imgname);
            }

            // take the default value which exists in database,,, if the user upload new logo, the old one will be replace
            $banklogopath = addCampus::where('campusid', $request->campusid)->value('banklogo');
            if ($request->banklogo) {
                if (File::exists("banklogo/" . addCampus::where('campusid', $request->campusid)->value('banklogo'))) {
                    File::delete("banklogo/" . addCampus::where('campusid', $request->campusid)->value('banklogo'));
                }
                $banklogopath =  "banklogo-" . time() . "." . $request->banklogo->extension();
                $request->banklogo->move(public_path('banklogo'), $banklogopath);
            }

            $pattern = "/-$/i";

            if (!preg_match($pattern, $request->CampusPrefix)) {
                $request->CampusPrefix .= "-";
            }

            addCampus::where('campusid', $request->input('campusid'))->update([
                'CampusName' => $request->input('CampusName'),
                'CampusEmail' => $request->input('CampusEmail'),
                // 'CampusPrefix' => $request->CampusPrefix,
                'DefaultBoard' => $request->input('DefaultBoard'),
                'DefaultReligion' => $request->input('DefaultReligion'),
                'Phone' => $request->input('Phone'),
                'Phone1' => $request->input('Phone1'),
                'BankName' => $request->input('BankName'),
                'AccountNumber' => $request->input('AccountNumber'),
                'RegistraionDate' => $request->input('RegistrationDate'),
                'Logo_photo_path' => $imgname,
                'banklogo' => $banklogopath,
                'banklogo' => $banklogopath,
                'SchoolStatus' => $request->input('SchoolStatus'),
                'DefaultAddress' => $request->input('DefaultAddress'),
                'DefaultAddress1' => $request->input('DefaultAddress1'),
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
