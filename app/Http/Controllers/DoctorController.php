<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequests;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //print_r(Auth::user());
        $doctor=DB::table('doctors')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($doctor)) {

            return view('doctor.index')->with('user', $doctor[0]);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('doctor.create');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $doctor=DB::table('doctors')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($doctor)==0){
            $request->session()->flash('msg','Please Complete Your Profile');
            return view('doctor.create');
        }
        else{
            return redirect()->route('doctor.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorRequests $request)
    {
        $doctor=new Doctor();
        $doctor->phone=$request->phone;
        $doctor->gender=$request->gender;
        $doctor->license=$request->license;
        $doctor->qualifications=$request->qualifications;
        $doctor->specialty=$request->specialty;
        $doctor->userId=Auth::user()->id;

        if($request->hasFile('photo')){
            $file=$request->file('photo');
//            echo "File Name: ". $file->getClientOriginalName()."<br>";
//            echo "File Extension: ". $file->getClientOriginalExtension()."<br>";
//            echo "File Size: ". $file->getSize()."<br>";
//            echo "File Mime Type: ". $file->getMimeType();
            $filename=$file->getClientOriginalName();

            if($file->move('img', $filename)){
                $doctor->photo=$filename;
                $doctor->save();
                return redirect()->route('doctor.index');
            }
            else{
                return redirect()->route('doctor.create');
            }
        }
        else{
            echo 'Profile photo is not selected';
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Doctor $doctor)
    {
        $doctor=DB::table('doctors')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($doctor)) {

            return view('doctor.index')->with('user', $doctor[0]);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('doctor.create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Doctor $doctor)
    {
        $doctor=DB::table('doctors')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($doctor)) {

            return view('doctor.index')->with('user', $doctor[0]);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('doctor.create');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
