@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="table-responsive">
            <a class="btn btn-primary" href="{{ url('products/create') }}">Add Product</a>
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>User ID</th>
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
            $.ajax("{{ url('api/products') }}", {
                dataType: 'json', // type of response data
                processData: false,
                contentType: false,
                timeout: 30000, // timeout milliseconds
                type: 'GET',

                success: function(data, status, xhr) { // success callback function
                    console.log(data.data.data);

                    var tr = "";
                    $.each(data.data.data, function(index, value) {
                        var editbtn =
                            "<a class='btn btn-link text-success' href='{{ url('/products') }}/" + value
                            .id + "/edit'>edit</a>";

                        var deteleBtn =
                            "<form method='POST' action='{{ url('products/') }}/" + value.id +
                            "/delete'><input name='_method' type='hidden' value='delete'><button  class='btn btn-link text-danger'>delete</button></form>";
                        var linkbtn =
                            "<a class='btn btn-link text-primary' href='{{ url('/addUserToProduct') }}/" + value
                            .id + "'>assign user to product</a>";
                        tr +=
                            `<tr>
                        <td>${value.name}</td>
                        <td>${value.description}</td>
                        <td><img src="${value.image}" class="img-fluid" style="width: 50px" /></td>
                        <td>${value.user_id}</td>
                        <td>
                            ${editbtn}
                            ${deteleBtn}
                            ${linkbtn}
                            
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
