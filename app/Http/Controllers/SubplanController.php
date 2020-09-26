<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminSubplanRequests;
use App\Models\subplan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubplanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subplan=DB::table('subplans')
            ->get();
        return view('admin.subPlan.create')->with('subPlans',$subplan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subPlan.create')->with(Auth::user()->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminSubplanRequests $request)
    {
        $subplan=new subplan();
        $subplan->name=$request->name;
        $subplan->duration=$request->duration;
        $subplan->features=$request->features;
        $subplan->price=$request->price;

        if($request->hasFile('subplanPic')){
            $file=$request->file('subplanPic');
            $filename=$file->getClientOriginalName();

            if($file->move('img', $filename)){
                $subplan->subplanPic=$filename;
                $subplan->save();
                return redirect()->route('admin.subPlan.create',Auth::user()->id);
            }
            else{
                return redirect()->route('admin.subPlan.create',Auth::user()->id);
            }
        }
        else{
            echo 'Profile photo is not selected';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subplan  $subplan
     * @return \Illuminate\Http\Response
     */
    public function show(subplan $subplan)
    {
        $subplan=DB::table('subplans')
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subplan  $subplan
     * @return \Illuminate\Http\Response
     */
    public function edit(subplan $subplan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subplan  $subplan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subplan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subplan  $subplan
     * @return \Illuminate\Http\Response
     */
    public function destroy( $subplan)
    {
        //
    }
}
