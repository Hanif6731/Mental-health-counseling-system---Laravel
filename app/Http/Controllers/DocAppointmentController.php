<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocAppointmentController extends Controller
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
        $docId=$request->session()->get('docId');
        //echo 'appointment';
        $appointments=DB::table('appointments','a')
            ->join('patients','a.patientId','=','patients.id')
            ->join('users','patients.userId','=','users.id')
            ->where('docId',$docId)->get();
        //dd($appointments);

        for($i=0;$i<count($appointments);$i++){
            $value=$appointments[$i];
            $value->accept='';
            $value->decline='';
            $value->start='';
            $req=strtolower($value->reqStatus);
            if($req==strtolower('requested')){
                $value->start='disabled';
                $value->start='disabled';
            }
            elseif($req==strtolower('accepted')){
                $value->decline='disabled';
            }
            elseif ($req==strtolower('declined') || $req==strtolower('ended')){
                $value->decline='disabled';
                $value->accept='disabled';
                $value->start='disabled';
            }
            $appointments[$i]=$value;

        }
        //dd($appointments);
        return view('doctor.appointment.index')->with('info',$appointments);
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
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
