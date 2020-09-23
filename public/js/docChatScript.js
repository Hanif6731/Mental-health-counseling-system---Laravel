$(document).ready(function () {
    var docUId=$('#docUId').val();
    var patientUId=$('#patientUId').val();
    var baseUri="http://localhost:8000/chat/"+patientUId+"/getMessages";
    var options = {
        year: 'numeric', month: 'numeric', day: 'numeric',
        hour: 'numeric', minute: 'numeric',
        hour12: true,
        timeZone: 'Asia/Dhaka'
    };
    loadMessages();

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('9319a5f60c4f65cfaa9f', {
        cluster: 'mt1'
    });

    var channel = pusher.subscribe('chatSession');
    channel.bind('patientSent', function(data) {
        //data=JSON.stringify(data);
        data=JSON.parse(data);
        alert(data);
        //console.log(JSON.stringify(data));
        htmlOld=$('#chatBody').html();
        html='';
        if(data.senderId==patientUId && data.receiverId==docUId){
            var date=new Date();
            date=new Intl.DateTimeFormat('en-US',options).format(date)
            html+="<div class='row mr-2 mb-2'>" +
                "<div class='col-6'>" +
                "<div class='rounded text-dark text-left bg-light'>" +
                "<p class='font-weight-bolder'>"+data.senderName+" | "+date+"</p>" +
                "<p class='card p-2 rounded-lg text-dark bg-light float-left shadow-sm text-wrap' style='width: fit-content'>"+data.text+"</p>" +
                "</div></div>" +
                "<div class='col-6'></div>" +
                "</div>"
        }
        $('#chatBody').html(html+htmlOld);
    });


    function loadMessages(){

        $.get(baseUri,{patientId:patientUId},function (data,status) {
            console.log(data)
            html='';
            for (let i=0;i<data.length;i++){
                var date= new Date(data[i].sent_at);
                data[i].sent_at=new Intl.DateTimeFormat('en-US',options).format(date);
                if(data[i].senderId==docUId && data[i].receiverId==patientUId){
                    html+="<div class='row mr-2 mb-2'><div class='col-6'></div>" +
                        "<div class='col-6'>" +
                        "<div class='rounded text-dark text-right bg-light'>" +
                        "<p class='font-weight-bolder'>"+data[i].sent_at+" | You</p>" +
                        "<p class='card p-2 rounded-lg text-white bg-primary float-right shadow-sm text-wrap' style='width: fit-content'>"+data[i].text+"</p>" +
                        "</div></div>" +
                        "</div>"
                }
                else if (data[i].senderId==patientUId && data[i].receiverId==docUId){
                    html+="<div class='row mr-2 mb-2'>" +
                        "<div class='col-6'>" +
                        "<div class='rounded text-dark text-left bg-light'>" +
                        "<p class='font-weight-bolder'>"+data[i].senderName+" | "+data[i].sent_at+"</p>" +
                        "<p class='card p-2 rounded-lg text-dark bg-light float-left shadow-sm text-wrap' style='width: fit-content'>"+data[i].text+"</p>" +
                        "</div></div>" +
                        "<div class='col-6'></div>" +
                        "</div>"
                }

            }
            $('#chatBody').html(html);
        }).fail(function (err) {
            console.log(err.responseText);
        })
    }


    // function sendMsg(msg) {
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.post(baseUri,{
    //         docUId:docUId,
    //         patientUId:patientUId,
    //         text:msg,
    //     },function (data,status) {
    //         console.log(data);
    //     }).fail(function (err) {
    //         console.log(err.responseText);
    //     }).done(function (data,status) {
    //         channel.trigger('client-docSent',data)
    //     });
    // }
});
