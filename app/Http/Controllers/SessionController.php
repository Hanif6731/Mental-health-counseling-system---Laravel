<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Session;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
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
    public function index()
    {
        //
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
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$sid)
    {
        //dd($request);
        $appointment=Appointment::find($request->appointmentId);
        $appointment->reqStatus='Ended';
        $appointment->save();
        $session=Session::find($request->sessId);
        $session->endTime=Carbon::now()->toDateTimeString();
        $session->save();
        $sender=6;
        $receiver=Auth::user()->id;
        $senderInfo=User::find($sender);
        $receiverInfo=User::find($receiver);
        $senderInfo->amount-=500;
        $receiverInfo->amount+=500;
        $senderInfo->save();
        $receiverInfo->save();
        $transaction=new Transaction();
        $transaction->amount=500;
        $transaction->type='Transfer';
        $transaction->senderId=$sender;
        $transaction->receiverId=$receiver;
        $transaction->save();
        return redirect()->route('doctor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }
}
