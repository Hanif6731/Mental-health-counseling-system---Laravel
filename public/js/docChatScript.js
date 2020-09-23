$(document).ready(function () {
    var docUId=$('#docUId').val();
    var patientUId=$('#patientUId').val();
    var patientId=$('#patientId').val();
    var aid=$('#appointmentId').val();
    var sessId=$('#sessId').val();
    var baseUri="http://localhost:8000/";
    var options = {
        year: 'numeric', month: 'numeric', day: 'numeric',
        hour: 'numeric', minute: 'numeric',
        hour12: true,
    };
    loadMessages();

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;

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

    $('#btnHealthInfo').click(function () {
        loadHealthRecord();
    });

    $('#btnPrescribe').click(function () {
        $('#prescriptionModal').modal('show');
    });

    $('#btnSaveMed').click(function (e) {
        e.preventDefault();
        var medicine={
            medName:$('#medName').val(),
            quantity:$('#medQty').val(),
            medType:$('#medType').val(),
            duration:$('#medDuration').val(),
            timing:$('#medTiming').val(),
            notes:$('#medNote').val(),
            patientId:patientId,
            sessId:sessId,
        };
        var flag=true;
        for(var key in medicine){
            //console.log(val);
            if(medicine[key]=="" || medicine[key]==null){
                flag=false;
                break;
            }
        }
        if(flag) {
            $('#errMsg').html('');
            postMed(medicine);
        }
        else {
            $('#errMsg').html('All fields are required');
        }

    });

    function postMed(medicine){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(baseUri+'doctor/'+docUId+'/prescription',medicine,function (data,status) {
            alert(status);
            console.log(data);
        }).fail(function (e) {
           console.log(e.responseText);
        });
    };


    function loadMessages(){

        $.get(baseUri+"chat/"+patientUId+"/getMessages",{patientId:patientUId},function (data,status) {
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

    function loadHealthRecord() {
        $.get(baseUri+"doctor/chatSession/patient/"+patientId+"/healthRecord",
            {patientId:patientId,},
            function (data,status) {
            var date=new Date(data.updated_at);
            data.updated_at=new Intl.DateTimeFormat('en-US',options).format(date);
               console.log(data);
                $('#pHeight').html(data.height+" cm.");
                $('#pWeight').html(data.weight+" kg.");
                $('#pBp').html(data.bp+" mmHg");
                $('#pPr').html(data.pulseRate+" bpm");
                $('#pMood').html(data.mood);
                $('#pDesc').html(data.description);
                $('#pSd').html(data.sleepDuration+" Hours");
                $('#pUDate').html(data.updated_at);
                $('#hrModal').modal('show');
            }).fail(function (data) {
            console.log(data.responseText);
        });
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
