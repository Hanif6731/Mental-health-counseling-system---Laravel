<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequests;
use App\Models\admin;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*$doctor=DB::table('staff')
            ->rightJoin('users','staff.s_id','=','users.id')
            ->where('userId','=',Auth::user()->id)
            ->get();
    print_r($staff);
    return view('staff.profile')->with('users',$users);*/
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {   $staff=DB::table('staff')
        ->join('users','staff.userId','=','users.id')
        ->where('userId','=',Auth::user()->id)
        ->get();
        //print_r($doctor);
        if(count($staff)) {

            return view('staff.index')->with('user', $staff[0]);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('staff.create');
        }
        return view('staff.index')->with('user',$staff[0]);

    }
    /*public function profile(Request $request)
    {
        $staff=DB::table('staff')
            ->join('users','staff.userId','=','users.id')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($staff)) {

            return view('staff.index')->with('user', $staff[0]);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('staff.create');
        }
        return view('staff.profile')->with('user',$staff[0]);
    }*/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $staff=DB::table('staff')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($staff)==0){
            $request->session()->flash('msg','Please Complete Your Profile');
            return view('staff.create');
        }
        else{
            return redirect()->route('staff.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffRequests $request)
    {
        $staff=new Staff();
        $staff->phone=$request->phone;
        $staff->gender=$request->gender;
        $staff->userId=Auth::user()->id;

        if($request->hasFile('photo')){
            $file=$request->file('photo');
        //  echo "File Name: ". $file->getClientOriginalName()."<br>";
        //  echo "File Extension: ". $file->getClientOriginalExtension()."<br>";
        //   echo "File Size: ". $file->getSize()."<br>";
        //  echo "File Mime Type: ". $file->getMimeType();
            $filename=$file->getClientOriginalName();

            if($file->move('img', $filename)){
                $staff->photo = $filename;
                $staff->save();
                return redirect()->route('staff.index');
            }
            else{
                return redirect()->route('staff.create');
            }
        }
        else{
            echo 'Profile photo is not selected';
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Staff $staff)
    {
        $staff=DB::table('staff')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($staff)) {

            return view('staff.index')->with('user', $staff[0]);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('staff.create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$staff)
    {
        $staff=DB::table('staff')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($staff)) {
            $staff=DB::table('staff')
                ->where('userId','=',Auth::user()->id)
                ->get();
            return view('staff.edit')->with('user', $staff[0]);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('staff.create');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(StaffUpdateRequests $request, $staff)
    {
        $staff=DB::table('staff')
            ->where('userId','=',Auth::user()->id)
            ->get();
        $staff->phone=$request->phone;
        $staff->gender=$request->gender;

        if($request->hasFile('photo')){
            $file=$request->file('photo');
//            echo "File Name: ". $file->getClientOriginalName()."<br>";
//            echo "File Extension: ". $file->getClientOriginalExtension()."<br>";
//            echo "File Size: ". $file->getSize()."<br>";
//            echo "File Mime Type: ". $file->getMimeType();
            $filename=$file->getClientOriginalName();

            if($file->move('img', $filename)){
                $staff->photo=$filename;

            }

        }
        $staff->save();
        return redirect()->route('staff.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //
    }
}
