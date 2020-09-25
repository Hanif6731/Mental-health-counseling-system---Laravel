<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

{{--    <title>{{ config('app.name', 'Laravel') }}</title>--}}

    <!-- Scripts -->

{{--        <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">--}}
{{--        <script src="{{asset('js/jquery.js')}}" defer type="application/javascript"></script>--}}
{{--        <script src="{{asset('js/popper.js')}}" defer type="application/javascript"></script>--}}
{{--        <script src="{{ asset('js/bootstrap.js') }}" type="application/javascript"></script>--}}
{{--    <script src="{{asset('js/app.js')}}" defer></script>--}}
{{--    <script src="{{asset('js/docScript.js')}}" defer type="application/javascript"></script>--}}
{{--    <script src="{{asset('js/docForumScript.js')}}" defer type="application/javascript"></script>--}}

<!-- Fonts -->
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
{{--    <link href="{{asset('css/all.css')}}" rel="stylesheet">--}}

</head>

<body>
<div class="container mt-2 text-center ">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
            <div class="card shadow-sm bg-light">
                <div class="card-header"><h4 class=""><strong>Doctor Appointment statistics</strong></h4></div>
                <div class="card-body">
                    <table border="1" class="table table-light table-striped table-hover table-striped text-center">

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
        </div>
    </div>

</div>
</body>

</html>
