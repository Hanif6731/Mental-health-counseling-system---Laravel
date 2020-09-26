$(document).ready(function () {
    var base_uri='http://localhost:8000/';
    var adminId=$('#adminId').val();
    var csrfVar = $('meta[name="csrf-token"]').attr('content');
    loadPost();

    $(document).on('click','.btnComment',function (e){
        e.preventDefault();
        var id = $(this).val();
        //alert(id);
        //alert(id);
        loadComment(id);
    });

    $(document).on('click','.btnCommentDone',function (e) {
        e.preventDefault();
        var id=$(this).val();
        var comment=$('input[id^="comment'+id+'"]').val();
        console.log(comment);
        if(comment!=''){
            createComment(comment,id);
        }
    });

    $(document).on('click','.btnPostComment',function (e) {
        e.preventDefault();
        var id=$(this).val();
        var comment=$('input[id^="postComment'+id+'"]').val();
        console.log(id);
        if(comment!=''){
            createComment(comment,id);
        }
    });

    $('#send').click(function (e) {
        e.preventDefault();
        var post=$('#post').val();
        console.log(post);
        if(post!='') {
            createPost();
        }
    });

    function createComment(comment,id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(base_uri+'admin/'+adminId+'/forum/'+id+'/comment', {
            comment: comment,
            postId:id
            }
            , function (data, status) {
                loadPost();
                loadComment(id);

            }).fail(function (error) {
            console.log(error.responseText);
        }).done(function (data) {
            console.log(data);
        });
    }

    function createPost(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(base_uri+'admin/'+adminId+'/forum/',{
                post:$('#post').val()}
            ,function (data,status){
                loadPost();

            });


    }


    function loadPost(){
        var html='';
        var date;
        var options = {
            year: 'numeric', month: 'numeric', day: 'numeric',
            hour: 'numeric', minute: 'numeric',
            hour12: true,
            timeZone: 'Asia/Dhaka'
        };
        $.get(base_uri+'admin/'+adminId+'/forum/all',function (post,status){
            var data=post;
            $("#content").html('');
            //console.log(JSON.stringify(data));
            console.log(data);
            for(var i=0; i<data.length;i++){
                data[i].comments=0
                date = new Date(data[i].post_created_at);
                data[i].post_created_at=new Intl.DateTimeFormat('en-US',options).format(date);
                //console.log(data[i].date);
                html=$("#content").html();
                //console.log(html);
                html+="<div class='card mt-3 rounded border-secondary shadow-sm'>" +
                    "<div class='card-header bg-secondary text-white'>" +
                    "<div class='row'>" +
                    "<div class='col-5 offset-1'>" +
                    "<strong>"+data[i].name+"</strong> posted in forum" +
                    "</div>" +
                    "<div class='col-5 text-right'>" +data[i].post_created_at+
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "<div class='card-body'><div class='row'><div class='col-10 offset-1'> " + data[i].post+
                    "</div></div></div>" +
                    "<div class='card-footer'>"+
                    "<div class='row'>" +
                    "<div class='col-10 offset-1'>" +
                    "<button class='btn btn-link my-2 my-sm-0 font-weight-bold text-decoration-none btnComment ' id='"+data[i].fpid+"' value='"+data[i].fpid+"'>" +
                    "<i class='fa fa-comments fa-lg'></i> " +data[i].cnt+
                    "</button>" +
                    "</div> " +
                    "</div>" +
                    "<form method='post' class='w-100' >" +
                    "<input name='_token' value='"+csrfVar+"' type='hidden'>" +
                    "<div class='row'>" +
                    "<div class='col-9 offset-1'>" +
                    "<input type='text' placeholder='Comment' required name='comment' id='postComment"+data[i].fpid+"' class='form-control border-primary'>" +
                    "</div>" +
                    "<div class='col-1'><button type='submit' class='btn btn-outline-primary my-2 my-sm-0 btnPostComment'  value='"+data[i].fpid+"'>" +
                    "<i class='fa fa-comment-alt fa-lg'></i></button></div> " +
                    "</div></form>" +
                    "</div></div>";
                $("#content").html(html);


            }
        }).fail(function (e) {
            console.log(e.responseText);
        });
    }

    function loadComment(id){
        var options = {
            year: 'numeric', month: 'numeric', day: 'numeric',
            hour: 'numeric', minute: 'numeric',
            hour12: true,
            timeZone: 'Asia/Dhaka'
        };
        $.get(base_uri+'admin/'+adminId+'/forum/'+id+'/comment',{postId:id},function (comments,status){
            console.log(comments);
            var html='';
            for(var j=0; j<comments.length;j++){
                var date= new Date(comments[j].comment_created_at);
                comments[j].comment_created_at=new Intl.DateTimeFormat('en-US',options).format(date);
                html+="<form method='post'>" +
                    "<div class='row mt-1'>" +
                    "<div class='col-5 offset-1'>" +
                    "<strong>" +comments[j].name+
                    "</strong>" +
                    "</div>" +
                    "<div class='col-5 text-right'>" +comments[j].comment_created_at+
                    "</div> " +
                    "</div>" +
                    "<div class='row'>" +
                    "<div class='col-8 offset-2' >" + comments[j].comment+
                    "</div>"+
                    "</div>" +
                    "</div>";
            }
            //html+="<form method='post' action='/forum/post/"+id+"/comment' >" +
            html+="<div class='row p-2'>" +
                "<div class='col-8 offset-1'>" +
                "<input name='_token' value='"+csrfVar+"' type='hidden'>" +
                "<input type='text' placeholder='Comment' required name='comment' id='comment"+id+"' class='form-control border-primary'>" +
                "</div>" +
                "<div class='col-1'><button type='submit' class='btn btn-outline-primary my-2 my-sm-0  btnCommentDone'  value='"+id+"'>Done</button></div> " +
                "</div>"+
                "</form> " //+
            //"</form>"
            $("#commentBody").html(html);
            $('#commentModal').modal('show');

        });
    }
});
