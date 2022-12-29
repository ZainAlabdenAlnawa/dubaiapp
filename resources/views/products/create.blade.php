@extends('layouts.app')
@section('content')
    <div class="container">
        <form id="productForm" onsubmit="event.preventDefault(); submitForm()">
            <legend>Product Information</legend>
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" required id="name" class="form-control" />
            </div>

            <div class="form-group">
                <label for="">Image</label>
                <input type="file" name="image" required id="image" class="form-control" />
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

            $.ajax("{{ url('api/products') }}", {
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
                          timer: 1500,

                    }).then(function() {
                    window.location.href = "{{ url('products') }}"
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

       
    </script>
@endsection
