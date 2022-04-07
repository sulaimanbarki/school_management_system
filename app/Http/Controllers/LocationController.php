<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function Locations()
    {
        return view('admin.locations');
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
    public function store(LocationRequest $request)
    {
        $request->validated();

        $campusid = Auth::user()->campusid;
        if (Location::where('campusid', $campusid)->where('locationname', $request->locationname)->first()){
            echo 'duplicate';
            exit;
        } else {
            $location = new Location();
            $location->locationname = $request->locationname;
            $location->sequence = $request->sequence;
            $location->isdisplay = $request->isdisplay;
            $location->campusid = $campusid;

            if($location->save()){
                return response('', 200);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return Location::where('campusid', Auth::user()->campusid)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(LocationRequest $request, $location)
    {
        $request->validated();
        $campusid = Auth::user()->campusid;
        if (Location::where('campusid', $campusid)->where('locationname', $request->locationname)->where('id', '<>', $location)->first()) {
            echo 'duplicate';
            exit;
        } else {
            $jobs = Location::where('campusid', $campusid)->where('id', $location)->update([
                'locationname' => $request->locationname,
                'sequence' => $request->sequence,
                'isdisplay' => $request->isdisplay,
            ]);
        }

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
