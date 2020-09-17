@extends('layouts.doctor')

@section('content')
    <div class="container-fluid mt-2 text-center">
        <div class="row">
            <div class="col-12 col-md-12 offset-md-0">
                <div class="card shadow-sm bg-dark">
                    <table class="table table-dark table-hover table-striped text-center">
                        <thead class="thead-dark">
                        <tr>
                            <th>Patient Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Schedule</th>
                            <th colspan="2">Action</th>
                            <th>Session options</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($info->all() as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->description}}</td>
                            <td>{{$item->reqStatus}}</td>
                            <td>{{$item->schedule}}</td>
                            <td colspan="2"><button class="btn btn-outline-success my-2 my-sm-0 {{$item->accept}}> accept" {{$item->accept}}
                                name="accept" id="accept" data-toggle="modal" data-target="#accept{{$item->aid}}"><i class="fa fa-check fa-lg"></i> Accept</button>
                                <button class="btn btn-outline-danger my-2 my-sm-0 {{$item->decline}} decline" {{$item->decline}} name="decline"
                                        id="decline"data-toggle="modal" data-target="#decline{{$item->aid}}"><i class="fa fa-times fa-lg"></i> Decline</button> </td>
                            <td>

                                <a class="btn btn-outline-primary my-2 my-sm-0 chat_session {{$item->start}}" {{$item->start}} href="#"><i class="fa fa-comment fa-lg"></i> Start Chat Session</a>

                            </td>
                            <td><button class="btn btn-outline-primary my-2 my-sm-0 viewProfile" id="viewProfile" name="viewProfile"
                                        data-toggle="modal" data-target="#profile{{$item->patientId}}"><i class="fa fa-eye fa-lg"></i> View Profile</button>  </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-auto">
            </div>
        </div>
        @foreach($info->all() as $item)
        <div class="modal fade" id="accept{{$item->aid}}" tabindex="-1" aria-labelledby="accept{{$item->aid}}Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="accept{{$item->aid}}Label">Schedule the session</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <form method="post" action="#">
                            @csrf
                            <div class="form-group">
                                <label for="schedule">Date:</label>
                                <input type="datetime-local" name="schedule" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="docMsg">Note:</label>
                                <input type="text" name="docMsg" class="form-control"/>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-secondary my-2 my-sm-0" data-dismiss="modal"><i class="fa fa-times fa-lg"></i> Close</button>
                                <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="Done"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @foreach($info->all() as $item)
        <div class="modal fade" id="decline{{$item->aid}}" tabindex="-1" aria-labelledby="decline{{$item->aid}}Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="decline{{$item->aid}}Label">Are you sure to decline?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a  class="btn btn-primary text-decoration-none" href="#">Decline</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @foreach($info->all() as $item)
        <div class="modal fade" id="profile{{$item->patientId}}" tabindex="-1" aria-labelledby="profile{{$item->patientId}}Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title" id="profile{{$item->patientId}}Label">Patient Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div id="profileContent">
                            <div class="row">
                                <div class="col-12 text-center"><img src="{{asset('img/'.$item->photo)}}" class="rounded mx-auto d-block img-thumbnail" style="width: auto;height: 200px" /></div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Patient ID:</div>
                                <div class="col-6">{{$item->patientId}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Name:</div>
                                <div class="col-6">{{$item->name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Gender:</div>
                                <div class="col-6">{{$item->gender}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Blood Group:</div>
                                <div class="col-6">{{$item->bloodType}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Phone:</div>
                                <div class="col-6">{{$item->phone}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Email:</div>
                                <div class="col-6">{{$item->email}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
