<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PDF;
use App;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = DB::table('subscriptions')
        ->join('patients','subscriptions.patientId','=','patients.id')
        ->join('subplans','subscriptions.subPlanId','=','subplans.id')
        ->join('users','patients.userId','=','users.id')
        ->get();
        return view('admin.subscriptions.index')->with('users', $subscriptions);
    }

    function gen(){
        set_time_limit(300);
        $subscriptions=DB::table('subscriptions')
            ->join('patients','subscriptions.patientId','=','patients.id')
            ->join('subplans','subscriptions.subPlanId','=','subplans.id')
            ->join('users','patients.userId','=','users.id')
            ->get();

        view()->share('users',$subscriptions);
        $pdf=PDF::loadView('admin.subscriptions.subscription_report',$subscriptions);
        //$pdf=App::make()
        return $pdf->download('Subscription_report.pdf');

    }
}
