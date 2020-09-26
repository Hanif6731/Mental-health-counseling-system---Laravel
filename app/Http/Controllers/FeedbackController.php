<?php

namespace App\Http\Controllers;


use App\Models\feedback;
use App\Models\User;
use Carbon\Carbon;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PDF;
use App;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedback = DB::table('feedback')
        ->join('users','feedback.userId','=','users.id')
        ->get();
        return view('admin.feedback.index')->with('users', $feedback);

    }

 function gen(){
        set_time_limit(300);
     $feedback = DB::table('feedback')
         ->join('users','feedback.userId','=','users.id')
         ->get();

//        dd($feedback);
        view()->share('users',$feedback);
        $pdf=PDF::loadView('admin.feedback.feedback_report',$feedback);
        //$pdf=App::make()
        return $pdf->download('Feedback_report.pdf');

    }
}
