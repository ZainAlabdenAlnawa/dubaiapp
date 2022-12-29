@extends('layouts.app')
@section('content')
<div class="container">

            <form id="productForm" onsubmit="event.preventDefault(); submitForm()">
                <div class="form-group">
                    <label for="">Users List</label>
                    <select name="user" id="user" class="form-control">
                        
                        @foreach ($users as $item)
                            <option value="{{$item->id}}">{{$item->fname}} {{$item->lname}}</option>
                        @endforeach
                    </select>
                </div>
                <br><br>
                <button class="btn btn-primary">Attach User to Product {{$product_id}}</button>
            </form>
</div>


    <script>
        function submitForm() {
            var formData = new FormData(document.getElementById('productForm'));

            $.ajax("{{ url('api/product/addUserToProduct') }}/"+$("#user").val()+"/"+"{{$product_id}}", {
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