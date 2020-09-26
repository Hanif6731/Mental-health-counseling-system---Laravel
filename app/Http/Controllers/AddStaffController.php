<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminAddstaffRequests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=DB::table('users')
            ->get();
        return view('admin.addStaff.create')->with('users',$user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addStaff.create')->with(Auth::user()->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminAddstaffRequests $request)
    {
        $user=new user();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt(request('password'));
        $user->type=$request->type;
        $user->status=$request->status;
        $user->save();
        return redirect()->route('admin.addStaff.create',Auth::user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subplan  $subplan
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        $user=DB::table('users')
            ->get();
    }

}
