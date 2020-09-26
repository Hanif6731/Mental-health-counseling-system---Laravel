<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequests;
use App\Http\Requests\AdminUpdateRequests;
use App\Models\admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $admin=DB::table('admins')
            ->join('users','admins.userId','=','users.id')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($admin)) {

            return view('admin.index')->with('user', $admin[0]);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('admin.create');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
         $admin=DB::table('admins')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($admin)==0){
            $request->session()->flash('msg','Please Complete Your Profile');
            return view('admin.create');
        }
        else{
            return redirect()->route('admin.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        public function store(AdminRequests $request)
    {
        $admin=new Admin();
        $admin->phone=$request->phone;
        $admin->gender=$request->gender;
        $admin->userId=Auth::user()->id;

        if($request->hasFile('photo')){
            $file=$request->file('photo');
//            echo "File Name: ". $file->getClientOriginalName()."<br>";
//            echo "File Extension: ". $file->getClientOriginalExtension()."<br>";
//            echo "File Size: ". $file->getSize()."<br>";
//            echo "File Mime Type: ". $file->getMimeType();
            $filename=$file->getClientOriginalName();

            if($file->move('img', $filename)){
                $admin->photo=$filename;
                $admin->save();
                return redirect()->route('admin.index');
            }
            else{
                return redirect()->route('admin.create');
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
    public function show(Request $request,Admin $admin)
    {
        $admin=DB::table('admins')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($admin)) {

            return view('admin.index')->with('user', $admin[0]);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('admin.create');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request,$admin)
    {
        $admin=DB::table('admins')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($admin)) {
            $admin=DB::table('admins')
            ->where('userId','=',Auth::user()->id)
            ->get();
            return view('admin.edit')->with('user', $admin[0]);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('admin.create');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(AdmminUpdateRequests $request, $admin)
    {
        $admin=DB::table('admins')
            ->where('userId','=',Auth::user()->id)
            ->get();
        $admin->phone=$request->phone;
        $admin->gender=$request->gender;

        if($request->hasFile('photo')){
            $file=$request->file('photo');
//            echo "File Name: ". $file->getClientOriginalName()."<br>";
//            echo "File Extension: ". $file->getClientOriginalExtension()."<br>";
//            echo "File Size: ". $file->getSize()."<br>";
//            echo "File Mime Type: ". $file->getMimeType();
            $filename=$file->getClientOriginalName();

            if($file->move('img', $filename)){
                $admin->photo=$filename;

            }

        }
        $admin->save();
        return redirect()->route('admin.index');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin $admin)
    {
        //
    }
}
