@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="table-responsive">
            <a class="btn btn-primary" href="{{ url('admin/user/create') }}">Add User</a>
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Fname</th>
                        <th>LName</th>
                        <th>email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>
        </div>
    </div>

    <script>
        function getData() {
            $.ajax("{{ url('api/admin/user/') }}", {
                dataType: 'json', // type of response data
                processData: false,
                contentType: false,
                timeout: 30000, // timeout milliseconds
                type: 'GET',

                success: function(data, status, xhr) { // success callback function
                    console.log(data);

                    var tr = "";
                    $.each(data.data, function(index, value) {
                        var editbtn =
                            "<a class='btn btn-link text-success' href='{{ url('admin/user') }}/" + value
                            .id + "/edit'>edit</a>";

                        var deteleBtn =
                            "<form method='POST' action='{{ url('/admin/user/') }}/" + value.id +
                            "/delete'><input name='_method' type='hidden' value='delete'><button  class='btn btn-link text-danger'>delete</button></form>";
                       
                        tr +=
                            `<tr>
                        <td>${value.fname}</td>
                        <td>${value.lname}</td>
                       
                        <td>${value.email}</td>
                        <td>
                            ${editbtn}
                            ${deteleBtn}
                           
                            
                            </td>
                        </tr>`
                    });

                    $("#tbody").append(tr);


                },
                error: function(jqXhr, textStatus, errorMessage) { // error callback 
                    console.log(errorMessage);

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: errorMessage,
                    })
                },
            });
        }

        $(window).ready(function() {
            getData();
        })
    </script>
@endsection
