@extends('layouts.app')
@section('content')
    <div class="container">
        <form id="userForm" onsubmit="event.preventDefault(); submitForm()">
                        @csrf
                        @method("PUT")
                        <div class="row mb-3">
                            <label for="fname" class="col-md-4 col-form-label text-md-end">{{ __('Frist Name') }}</label>

                            <div class="col-md-6">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autocomplete="fname" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lname" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required autocomplete="lname" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                     

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
    </div>

    <script>
        function submitForm() {
            var formData = new FormData(document.getElementById('userForm'));

            $.ajax("{{ url('api/admin/'.$user->id.'/user') }}", {
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
                    window.location.href = "{{ url('admin/users') }}"
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
            $.ajax("{{ url('api/admin/user/' . $user->id) }}", {
                dataType: 'json', // type of response data
                processData: false,
                contentType: false,
                timeout: 30000, // timeout milliseconds
                type: 'GET',

                success: function(data, status, xhr) { // success callback function
                    console.log(data.data);
                    let user = data.data;
                    $("#lname").val(user.lname);
                    $("#fname").val(user.fname);
                    $("#phone").val(user.phone);
                    $("#email").val(user.email);
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
