<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocAppRequests;
use App\Models\Appointment;
use Carbon\Carbon;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
            ->where('docId',$docId)
            ->orderByDesc('aid')
            ->get();
        //dd($appointments);

        for($i=0;$i<count($appointments);$i++){
            $value=$appointments[$i];
            $value->accept='';
            $value->decline='';
            $value->start='';
            $value->btnAccept='Accept';
            $req=strtolower($value->reqStatus);
            if($req==strtolower('requested')){
                $value->start='disabled';
                $value->start='disabled';
            }
            elseif($req==strtolower('accepted')){
                $value->decline='disabled';
                $value->btnAccept='Change Schedule';
            }
            elseif ($req==strtolower('declined') || $req==strtolower('ended')){
                $value->decline='disabled';
                $value->accept='disabled';
                $value->start='disabled';
            }
            if($value->schedule!=null){
                $value->schedule=date('Y-m-d h:i A',strtotime($value->schedule));
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

    public function accept(DocAppRequests $requests,$id){
        $appointment=Appointment::find($id);
        $appointment->schedule=$requests->schedule;
        $appointment->docMsg=$requests->docMsg;
        $appointment->reqStatus='Accepted';
        $appointment->save();
        return redirect()->route('doctor.appointment.index',Auth::user()->id);
        //dd((new \DateTime($requests->schedule))->format('yyyy-MM-dd HH:mm:ss'));
    }
    public function decline($id){
        $appointment=Appointment::find($id);
        $appointment->reqStatus='Declined';
        $appointment->save();
        return redirect()->route('doctor.appointment.index',Auth::user()->id);
    }

    public function search(Request $request,$str){
        //$client=new \GuzzleHttp\Client();
        $docId=$request->session()->get('docId');
        //$response=$client->request('GET','http://localhost:3000/search/'.$docId.'/'.$str);
        //dd($response->getBody());
        $response=Http::get('http://localhost:3000/search/'.$docId.'/'.$str);
        return $response->json();
    }
}
