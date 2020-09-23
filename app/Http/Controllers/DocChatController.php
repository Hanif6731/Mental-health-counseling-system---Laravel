<?php

namespace App\Http\Controllers;

use App\Events\docSentEvent;
use App\Models\Chat;
use App\Models\Patient;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Array_;

class DocChatController extends Controller
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
    public function index(Request $request,$patient)
    {
        //dd($doctor,$patient);
        $session=new Session();
        $session->sessionType='chat';
        $session->startTime=Carbon::now()->toDateTimeString();
        $session->docUId=Auth::user()->id;
        $session->patientUId=$patient;
        //dd($session);
        $patient=User::find($patient);
        $request->session()->put('patientName',$patient->name);

        return view('doctor.chat.index')->with('sess',$session);
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
        $chat=new Chat();
        $chat->text=$request->msg;
        $chat->senderId=Auth::user()->id;
        $chat->receiverId=$request->patientUId;
        $chat->senderName=Auth::user()->name;
        $chat->receiverName=$request->session()->get('patientName');
        $chat->sent_at=Carbon::now()->toDateTimeString();
        $chat->save();
        event(new docSentEvent($chat));
        //return redirect()->route('doctor.pati')
        $session=new Session();
        $session->docUId=Auth::user()->id;
        $session->patientUId=$request->patientUId;
        //dd($session);
        return view('doctor.chat.index')->with('sess',$session);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }

    public function getMessages(Request $request){
//        $chat=DB::table('chats')
//            ->where('receiverId','=',$request->patientId)
//            ->where('senderId','=',$request->patientId)
//            ->orWhere('receiverId','=',Auth::user()->id)
//            ->where('senderId','=',Auth::user()->id)
//            ->get();
        $d=Auth::user()->id;
        $p=$request->patientId;
        $chat=DB::select(DB::raw('SELECT * FROM chats WHERE (receiverId='.$d.' and senderId ='.$p.') or (receiverId = '.$p.' AND senderId = '.$d.') order by sent_at desc'));
        return response()->json($chat);
    }

}
