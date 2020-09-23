@extends('layouts.doctor')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card bg-dark shadow-sm position-relative">
                    {{--                    <div class="card-header"></div>--}}
                    <div class="card-body text-center rounded">
                        <div class="row"><div class="col-12">
                        <form method="post" action="{{route('docChat.store',$sess->patientUId)}}" class="form-inline mr-auto d-inline text-center text-nowrap w-100">
                            @csrf
                            <input type="hidden" id="docUId" name="docUId"  value="{{Auth::user()->id}}">
                            <input type="hidden" id="patientUId" name="patientUId" value="{{$sess->patientUId}}">
                                    <input type="text" class="form-control border-primary pr-1 w-75" name="msg" id="msg" placeholder="Message"/>
                                        <button type="submit" id="send" class="btn btn-outline-primary my-2 my-sm-0"
                                                data-toggle="tooltip" data-placement="right" title="Send"><i class="fa fa-paper-plane fa-lg"></i></button>


                        </form>
                        </div></div>
                    </div>
                    {{--                    <div class="card-footer"></div>--}}
                </div>
            </div>
            <div class="col-md-2 justify-content-center" >
                <div class="card shadow-sm bg-light rounded p-3 position-fixed">
                    <form class="mr-auto text-center text-nowrap w-100">
                        <button type="button" id="btnHealthInfo" class="btn btn-outline-primary my-2 my-sm-0 m-1"
                                data-toggle="tooltip" data-placement="bottom" title="View Patient's Health info"><i class="fa fa-file-medical fa-lg"></i></button>
                        <button type="button" id="btnPrescribe" class="btn btn-outline-primary my-2 my-sm-0 m-1"
                                data-toggle="tooltip" data-placement="bottom" title="Prescribe medicine"><i class="fa fa-file-prescription fa-lg"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-md-8 offset-md-2">
                <div id="chatBody">

                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/pusher.js')}}" defer type="application/javascript"></script>
    <script src="{{asset('js/docChatScript.js')}}" defer type="application/javascript"></script>
@endsection
