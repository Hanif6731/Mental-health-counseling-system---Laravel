$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $('#search').click(function (e) {
        e.preventDefault();
        var str=$('#searchText').val();
        if(str.length>0) {
            searchUser(str);
        }
    });

    function searchUser(str) {
        $.ajax({
            url:'http://localhost:8000/admin/userList/search/'+str,
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
                        '<th>User Name</th>' +
                        '<th>Email</th>' +
                        '<th>User Type</th>' +
                        '<th>Status</th>'  +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';

                    for(let i=0;i<response.length;i++){
                        html+='<tr>' +
                            '<td>'+response[i].name+'</td>' +
                            '<td>'+response[i].email+'</td>' +
                            '<td>'+response[i].type+'</td>' +
                            '<td>'+response[i].status+'</td>' +
                            '</tr>'
                    }

                    html+='</tbody>' +
                        '</table>' +
                        '</div>';
                }
                else {
                    html='<h4>No search result found!!!</h4>'
                }
                $('#users').html(html);
                $('#searchModal').modal('show');
            },
            error:function (xhr) {

            }
        });
    }
});