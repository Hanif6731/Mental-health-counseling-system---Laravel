@extends('layouts.doctor')

@section('content')
    <div class="container mt-2 text-center" >
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card shadow-sm">
                    <div class="card-img bg-secondary">
                        <img src="{{asset('img/'.$user->photo)}}" class="rounded mx-auto d-block img-thumbnail" style="width: auto;height: 200px">
                    </div>
                    <div class="card-body text-center">
                        <h3>{{$user->name}}</h3>
                        <div class="h5 text-left">
                            <div class="row">
                                <div class="col-6 text-right">Phone: </div>
                                <div class="col-6">{{$user->phone}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Specialty: </div>
                                <div class="col-6">{{$user->specialty}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Email: </div>
                                <div class="col-6">{{$user->email}}</div>
                            </div>

                            <div class="row">
                                <div class="col-6 text-right">License: </div>
                                <div class="col-6">{{$user->license}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Account Status: </div>
                                <div class="col-6">{{$user->docStatus}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Amount:</div>
                                <div class="col-6">{{$user->amount}} Taka</div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-right">Qualifications: </div>
                                <div class="col-6">{{$user->qualifications}}</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-auto">
            </div>
        </div>
{{--        <div class="row">--}}
{{--            <div class="col-12 col-md-8 offset-md-2">--}}
{{--                <%for(var i=0;i<reviews.length;i++){%>--}}
{{--                <div class="card mt-2 text-left text-capitalize">--}}
{{--                    <div class="card-header bg-info text-white "><strong class="h5"><%= reviews[i].name%></strong><i> Rated <%= reviews[i].review%> out of 5!!</i>--}}

{{--                    </div>--}}
{{--                    <div class="card-body font-weight-bold"><%=reviews[i].feedback%></div>--}}
{{--                </div>--}}
{{--                <%}%>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
