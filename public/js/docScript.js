$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $('#search').click(function (e) {
        e.preventDefault();
        var str=$('#searchText').val();
        if(str.length>0) {
            searchAppointment(str);
        }
    });

    function searchAppointment(str) {
        $.ajax({
            url:'http://localhost:8000/doctor/appointment/search/'+str,
            method:'GET',
            success:function (response) {
                console.log(response);
                $('#searchLabel').html(response.length+' results found.')
                var html='';
                if(response.length>0){

                    html+='<div class="card shadow-sm bg-dark">' +
                        '<table class="table table-dark table-hover table-striped text-center">' +
                        '<thead class="thead-dark">' +
                        '<tr>' +
                        '<th>Patient Name</th>' +
                        '<th>Description</th>' +
                        '<th>Status</th>' +
                        '<th>Schedule</th>' +
                        '<th>Your Note</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';

                    for(let i=0;i<response.length;i++){
                        if(response[i].schedule!=null){
                            var date=response[i].schedule;
                               date=new Date(date);
                            response[i].schedule=date.toLocaleString('en-US');
                        }
                        html+='<tr>' +
                            '<td>'+response[i].name+'</td>' +
                            '<td class="text-wrap">'+response[i].description+'</td>' +
                            '<td>'+response[i].reqStatus+'</td>' +
                            '<td>'+response[i].schedule+'</td>' +
                            '<td>'+response[i].docMsg+'</td>' +
                            '</tr>'
                    }

                    html+='</tbody>' +
                        '</table>' +
                        '</div>';
                }
                else {
                    html='<h4>No search result found!!!</h4>'
                }
                $('#appointmentItems').html(html);
                $('#searchModal').modal('show');
            },
            error:function (xhr) {

            }
        });
    }
});
