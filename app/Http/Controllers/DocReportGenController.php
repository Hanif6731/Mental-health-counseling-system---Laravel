<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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

    function genStat(Request $request){
        set_time_limit(300);
        //$total=DB::select(DB::Raw('select count(*) from appointments where docId ='+))
        $appointments=DB::table('appointments')
            ->join('patients','appointments.patientId','=','patients.id')
            ->where('docId',$request->session()->get('docId'))
            ->get();
        $accepted=0;
        $declined=0;
        $pending=0;
        foreach ($appointments as $appointment){
            if(strtolower($appointment->reqStatus)=='requested'){
                $pending+=1;
            }
            elseif(strtolower($appointment->reqStatus)=='declined'){
                $declined+=1;
            }
            else{
                $accepted+=1;
            }
        }
        $total=count($appointments);

        $data=array(
            "accepted"=>$accepted,
            "declined"=>$declined,
            "pending"=>$pending,
            "total"=>$total
        );

        view()->share('data',$data);
        $pdf=PDF::loadView('doctor.reports.appointments_stat',$data);
        //$pdf=App::make()
        return $pdf->download('Appointments_statistics.pdf');

//        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadView('doctor.reports.earning_report',$transaction);
//        return $pdf->stream();
    }
}
