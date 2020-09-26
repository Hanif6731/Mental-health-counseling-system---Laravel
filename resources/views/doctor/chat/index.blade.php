@extends('layouts.doctor')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card bg-dark shadow-sm position-relative">
                    {{--                    <div class="card-header"></div>--}}
                    <div class="card-body text-center rounded">
                        <div class="row">
                            <div class="col-12 offset-sm-2 col-sm-8 text-danger">
                                @foreach($errors->all() as $err)
                                    {{$err}} <br>
                                @endforeach
                            </div>
                        </div>
                        <div class="row"><div class="col-12">
                        <form method="post" action="{{route('docChat.store',[$sess->patientUId,$sess->appointmentId])}}" class="form-inline mr-auto d-inline text-center text-nowrap w-100">
                            @csrf

                            <input type="hidden" id="docUId" name="docUId"  value="{{Auth::user()->id}}">
                            <input type="hidden" id="patientUId" name="patientUId" value="{{$sess->patientUId}}">
                            <input type="hidden" id="appointmentId" name="appointmentId" value="{{$sess->appointmentId}}">
                            <input type="hidden" id="sessId" name="sessId" value="{{$sess->seid}}">
                            <input type="hidden" id="patientId" name="patientId" value="{{session('patientId')}}">
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
                    <form method="post" action="{{route('doctor.chat.end',$sess->seid)}}" class="mr-auto text-center text-nowrap w-100">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="aid" name="appointmentId" value="{{$sess->appointmentId}}">
                        <input type="hidden" id="sid" name="sessId" value="{{$sess->seid}}">
                        <button type="button" id="btnHealthInfo" class="btn btn-outline-primary my-2 my-sm-0 m-1"
                                data-toggle="tooltip" data-placement="bottom" title="View Patient's Health info"><i class="fa fa-file-medical fa-lg"></i></button>
                        <button type="button" id="btnPrescribe" class="btn btn-outline-primary my-2 my-sm-0 m-1"
                                data-toggle="tooltip" data-placement="bottom" title="Prescribe medicine"><i class="fa fa-file-prescription fa-lg"></i></button>
                        <button type="submit" id="btnEndSession" class="btn btn-outline-danger my-2 my-sm-0 m-1"
                                data-toggle="tooltip" data-placement="bottom" title="End Session"><i class="fa fa-sign-out-alt fa-lg"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-md-8 offset-md-2">
                <div id="chatBody">

                </div>
            </div>

            <div class="modal fade" id="hrModal" tabindex="-1" aria-labelledby="hrModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="hrModalLabel">Patient Health Record</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="hrBody">
                            <div class="row">
                                <div class="col-6 text-right">Height:</div>
                                <div class="col-6" id="pHeight"></div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Weight:</div>
                                <div class="col-6" id="pWeight"></div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Blood Pressure:</div>
                                <div class="col-6" id="pBp"></div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Pulse Rate:</div>
                                <div class="col-6" id="pPr"></div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Mood:</div>
                                <div class="col-6" id="pMood"></div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Sleep Duration:</div>
                                <div class="col-6" id="pSd"></div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Description:</div>
                                <div class="col-6" id="pDesc"></div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Last update date:</div>
                                <div class="col-6" id="pUDate"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="prescriptionModalLabel">Prescribe medicine</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body bg-dark text-white" id="medBody">
                            <form method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="medName"><strong>Name:</strong></label>
                                            <input type="text" class="form-control" name="medName"
                                                   id="medName" placeholder="Medicine Name" value="{{old('medName')}}"/>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="medType"><strong>Type:</strong></label>
                                            <select class="form-control" name="medType" id="medType">
                                                <option selected>Tablet</option>
                                                <option>Capsule</option>
                                                <option>Liquid</option>
                                                <option>Suppository</option>
                                                <option>Drop</option>
                                                <option>Inhaler</option>
                                                <option>Injection</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="medQty"><strong>Quantity:</strong></label>
                                            <input type="number" min="1" class="form-control" name="medQty"
                                                   id="medQty" placeholder="Quantity" value="{{old('medQty')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="medDuration"><strong>Duration (in days):</strong></label>
                                            <input type="number" min="1" class="form-control" name="medDuration"
                                                   id="medDuration" placeholder="In days" value="{{old('medDuration')}}"/>
                                        </div>
                                    </div><div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="medTiming"><strong>Timing:</strong></label>
                                            <input type="text" class="form-control" name="medTiming"
                                                   id="medTiming" placeholder="i.e. 1-0-1" value="{{old('medTiming')}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="medNote"><strong>Notes:</strong></label>
                                    <textarea class="form-control" id="medNote" name="medNote" placeholder="Additional notes"></textarea>
                                </div>
                                <div class="row">
                                    <div class=" col-12 text-center">
                                        <input type="submit" class="btn btn-outline-primary pr-3 pl-3 font-weight-bold" value="Save" id="btnSaveMed"/>
                                        <input type="reset" class="btn btn-outline-warning pr-3 pl-3 font-weight-bold" value="Clear" id="clear"/>
                                    </div>
                                </div>
                                <div class="text-danger text-center font-weight-bold" id="errMsg">

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="{{asset('js/pusher.js')}}" defer type="application/javascript"></script>
    <script src="{{asset('js/docChatScript.js')}}" defer type="application/javascript"></script>
@endsection
