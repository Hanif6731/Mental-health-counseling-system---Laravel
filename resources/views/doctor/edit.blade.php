@extends('layouts.doctor')

@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <div class="text-center">
                            <div class="h5">
                                Edit Profile
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('doctor.update',Auth::User()->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name"><strong>Name:</strong></label>
                                        <input type="text" class="form-control" name="name"
                                               id="name" placeholder="name" value="{{$user->name}}"/>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="phone"><strong>Phone:</strong></label>
                                        <input type="text" class="form-control" name="phone"
                                               id="phone" placeholder="Phone" value="{{$user->phone}}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="new_password"><strong>New Password:</strong></label>
                                        <input type="text" class="form-control" name="new_password"
                                               id="new_password" placeholder="New Password"/>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="password"><strong>Current Password:</strong></label>
                                        <input type="text" class="form-control" name="password"
                                               id="password" placeholder="Current Password"/>

                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="gender"><strong>Gender:</strong></label>
                                        <select class="form-control" name="gender" id="gender">
                                            <option selected hidden>{{$user->gender}}</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="license"><strong>License:</strong></label>
                                        <input type="text" class="form-control" name="license"
                                               id="license" placeholder="License Number" value="{{$user->license}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="qualifications"><strong>Qualifications:</strong></label>
                                <textarea class="form-control" name="qualifications"
                                          id="qualifications" placeholder="Educational Qualifications">{{$user->qualifications}}</textarea>
                            </div>
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="specialty"><strong>Specialty:</strong></label>
                                        <select class="form-control" name="specialty" id="specialty">
                                            <option selected hidden>{{$user->specialty}}</option>
                                            <option>Addiction Psychology</option>
                                            <option>Biopsychology</option>
                                            <option>Cognitive Psychology</option>
                                            <option>Counseling Psychology</option>
                                            <option>Developmental Psychology</option>
                                            <option>Educational Psychology</option>
                                            <option>Experimental Psychology</option>
                                            <option>Forensic Psychology</option>
                                            <option>Health Psychology</option>
                                            <option>Human Factors Psychology</option>
                                            <option>Industrial Psychology</option>
                                            <option>Media Psychology</option>
                                            <option>Military Psychology</option>
                                            <option>Pediatric Psychology</option>
                                            <option>Social Psychology</option>
                                            <option>Sport Psychology</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="photo"><strong>Profile Picture:</strong></label>
                                <input type="file" class="form-control-file" name="photo" id="photo" accept="image/*">
                            </div>
                            <div class="row">
                                <div class=" col-12 text-center">
                                    <input type="submit" class="btn btn-primary pr-3 pl-3" value="Submit" id="submit"/>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>

            </div>
            <div class="col-auto">
                <div class="text-danger">
                    @foreach($errors->all() as $err)
                        {{$err}} <br>
                    @endforeach
                    {{session('msg')}}
                </div>
            </div>
        </div>
    </div>
@endsection
