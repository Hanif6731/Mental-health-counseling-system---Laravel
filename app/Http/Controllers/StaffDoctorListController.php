<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\staffDoctorList;

class StaffDoctorListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $doctorList = DB::table('doctors')
            ->join('users','doctors.userId','=','users.id')
            ->get();
        //dd($doctorList);
        return view('staff.doctorList.index')->with('users', $doctorList);

    }
    public function ban(Request $request){
        $id=$request->docUId;
        $doctorList= DB::table('doctors')->where('userId', $id)->update(array('docStatus' => 'Banned'));

        return redirect()->route('staff.doctorList.index',Auth::user()->id);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\staffDoctorList  $staffDoctorList
     * @return \Illuminate\Http\Response
     */
    public function show(staffDoctorList $staffDoctorList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\staffDoctorList  $staffDoctorList
     * @return \Illuminate\Http\Response
     */
    public function edit(staffDoctorList $staffDoctorList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\staffDoctorList  $staffDoctorList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, staffDoctorList $staffDoctorList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\staffDoctorList  $staffDoctorList
     * @return \Illuminate\Http\Response
     */
    public function destroy(staffDoctorList $staffDoctorList)
    {
        //
    }
}
