@extends('layouts.app')
@section('content')
    <div class="container">
        <form id="productForm" onsubmit="event.preventDefault(); submitForm()">
            <legend>Product Information</legend>
            @method('PUT')
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" required id="name" class="form-control" />
            </div>

            <div class="form-group">
                <label for="">Image</label>
                <input type="file" name="image" id="image" class="form-control" />
                <img src="" id="img-display" style="width: 100px; height:auto" alt="">

            </div>


            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" required id="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <br>
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>

        </form>
    </div>

    <script>
        function submitForm() {
            var formData = new FormData(document.getElementById('productForm'));

            $.ajax("{{ url('api/products/'. $product->id) }}", {
                dataType: 'json', // type of response data
                data: formData,
                processData: false,
                contentType: false,
                timeout: 30000, // timeout milliseconds
                type: 'POST',

                success: function(data, status, xhr) { // success callback function
                    console.log(data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                    });

                    
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

        function getData() {
            $.ajax("{{ url('api/products/' . $product->id) }}", {
                dataType: 'json', // type of response data
                processData: false,
                contentType: false,
                timeout: 30000, // timeout milliseconds
                type: 'GET',

                success: function(data, status, xhr) { // success callback function
                    console.log(data.data);
                    let product = data.data;
                    $("#name").val(product.name);
                    $("#description").val(product.description);
                    $("#img-display").attr('src', product.image);
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
