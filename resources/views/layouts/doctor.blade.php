<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

{{--    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">--}}
{{--    <script src="{{asset('js/jquery.js')}}" defer type="application/javascript"></script>--}}
{{--    <script src="{{asset('js/popper.js')}}" defer type="application/javascript"></script>--}}
{{--    <script src="{{ asset('js/bootstrap.js') }}" type="application/javascript"></script>--}}
    <script src="{{asset('js/app.js')}}" defer></script>
    <script src="{{asset('js/docScript.js')}}" defer type="application/javascript"></script>
{{--    <script src="{{asset('js/docForumScript.js')}}" defer type="application/javascript"></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/all.css')}}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md sticky-top text-white bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ route('doctor.index') }}">
                {{ config('app.name', 'Mental Health Counseling System') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>



            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->

                <form class="form-inline mr-auto d-inline text-center w-75">
                    @csrf
                    <input class="form-control mr-sm-2 w-75" type="search" id="searchText" placeholder="Search Appointments by patient" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" id="search" data-toggle="tooltip" data-placement="bottom" title="Search"><i class="fa fa-search"></i></button>
                </form>

                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item text-nowrap">
                            <a class="nav-link text-white" href="{{ route('login') }}"><i class="fa fa-sign-in"></i> {{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item text-nowrap">
                                <a class="nav-link text-white" href="{{ route('register') }}"><i class="fa fa-sign"></i> {{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item text-nowrap">
                            <a class="nav-link text-white" href="{{route('doctor.index')}}"><i class="fa fa-home"></i> Home</a>
                        </li>
                        <li class="nav-item text-nowrap">
                            <a class="nav-link text-white" href="{{route('doctor.appointment.index',Auth::user()->id)}}"><i class="fa fa-list"></i> Appointments</a>
                        </li>
                        <li class="nav-item text-nowrap dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-user"></i> {{ Auth::user()->name }}
                            </a>


                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a id="ddDropdown" class="dropdown-item dropdown-toggle text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-user-cog"></i> {{ __('Profile settings') }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ddDropdown">
                                    <a class="dropdown-item text-dark" href="{{route('doctor.edit',Auth::User()->id)}}"><i class="fa fa-user-edit"></i> {{__('Edit Profile')}}</a>
                                    <a class="dropdown-item text-dark" href="#"><i class="fa fa-user-minus"></i> {{__('Delete Profile')}}</a>
                                </div>
                                <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out-alt"></i> {{ __('Logout') }}
                                </a>


                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li class="nav-item dropdown text-nowrap">
                            <a id="moreDropdown" class=" nav-link dropdown-toggle text-white" href="#"
                               role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false"
                               v-pre>
                                <i class="fas fa-ellipsis-h" data-toggle="tooltip" data-placement="right" title="More options"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="moreDropdown">
                                <a class="dropdown-item text-dark" href="#"><i class="fa fa-comment"></i> {{__('Chat')}}</a>
                                <a class="dropdown-item text-dark" href="{{route('doctor.forum.index',Auth::user()->id)}}"><i class="fa fa-sticky-note"></i> {{__('Forum')}}</a>
                            </div>
                        </li>

                    @endguest
                </ul>
            </div>
        </div>
    </nav>


                <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-secondary text-white">
                                <h5 class="modal-title" id="searchLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-left">
                                <div id="appointmentItems" class="text-center">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


    <main class="py-4">
        @yield('content')
    </main>

</div>
</body>
</html>
