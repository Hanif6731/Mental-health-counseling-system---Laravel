@extends('layouts.doctor')

@section('content')
    <div class="container mt-2 text-center">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card shadow-sm bg-light">
                    <div class="card-header"><h4 class=""><strong>Doctor Appointment statistics</strong></h4></div>
                    <div class="card-body">
                        <table class="table table-light table-striped table-hover table-striped text-center">

                            <thead class="thead-dark">

                            <tr>
                                <th>Total</th>
                                <th>Accepted</th>
                                <th>Declined</th>
                                <th>Pending</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$data['total']}}</td>
                                <td>{{$data['accepted']}}</td>
                                <td>{{$data['declined']}}</td>
                                <td>{{$data['pending']}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-2 justify-content-center" >
                <div class="card shadow-sm bg-transparent  rounded p-3 position-fixed">

                    <a class="btn btn-outline-primary font-weight-bold my-2 my-sm-0 m-1" href="{{URL::to(route('doc.stat.gen',Auth::user()->id))}}"
                       data-toggle="tooltip" data-placement="bottom" title="Download Report"><i class="fa fa-print fa-lg"></i> Print</a>
                </div>
            </div>
        </div>

    </div>
@endsection
