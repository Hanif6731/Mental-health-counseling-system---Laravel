@extends('layouts.doctor')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <!--            <form method="post" action="/forum/post">-->
                <div class="card bg-dark shadow-sm">
{{--                    <div class="card-header"></div>--}}
                    <div class="card-body rounded">
                        <form method="post">
                            @csrf
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" id="docId" value="{{Auth::user()->id}}">
                                <textarea class="form-control border-primary" name="post" id="post" placeholder="What's on your mind?"></textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="text-right">
                                    <input type="submit" id="send" class="btn btn-outline-primary my-2 my-sm-0" value="Post"/>

                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
{{--                    <div class="card-footer"></div>--}}
                </div>
                <!--            </form>-->
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div id="content">

                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="commentModalLabel">Comments</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="commentBody">

                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <script src="{{asset('js/jquery.js')}}" defer type="application/javascript"></script>--}}
    <script src="{{asset('js/docForumScript.js')}}" defer type="application/javascript"></script>
@endsection
