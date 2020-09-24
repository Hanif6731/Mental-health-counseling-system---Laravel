@extends('layouts.doctor')

@section('content')
    <div class="container mt-2 text-center">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card shadow-sm bg-light">
                    <div class="card-header"><h4 class=""><strong>Doctor Earning Report</strong></h4></div>
                    <div class="card-body">
                        <table class="table table-light table-striped table-hover table-striped text-center">

                            <thead class="thead-dark">

                            <tr>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Transaction Type</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($info->all() as $item)
                                <tr>
                                    <td>{{$item->tid}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->type}}</td>
                                    <td>{{date('d-m-Y h:i A',strtotime($item->created_at))}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-2 justify-content-center" >
                <div class="card shadow-sm bg-transparent  rounded p-3 position-fixed">

                    <a class="btn btn-outline-primary font-weight-bold my-2 my-sm-0 m-1" href="{{URL::to(route('doc.report.gen',Auth::user()->id))}}"
                                data-toggle="tooltip" data-placement="bottom" title="Download Report"><i class="fa fa-print fa-lg"></i> Print</a>
                </div>
            </div>
        </div>

    </div>
@endsection
