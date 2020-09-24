<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use App;

class DocReportGenController extends Controller
{
    //
    function gen(){
        set_time_limit(300);
        $transaction=DB::table('transactions')
            ->where('senderId',Auth::user()->id)
            ->orWhere('receiverId',Auth::user()->id)
            ->orderByDesc('created_at')
            ->get();

        view()->share('info',$transaction);
        $pdf=PDF::loadView('doctor.reports.earning_report',$transaction);
        //$pdf=App::make()
        return $pdf->download('Doctor_earning_report.pdf');

//        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadView('doctor.reports.earning_report',$transaction);
//        return $pdf->stream();
    }
}
