@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="container col-sm-12 col-lg-6">
                <div class="card card-default">
                    <div class="card-header h3">Change password</div>

                    <div class="card-body">
                        <form class="form-horizontal"
                        id="password-form"
                         onsubmit="event.preventDefault(); submitPassword();"
                        method="POST" action="#">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">Current Password</label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control"
                                        name="current-password" required>

                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('current-password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">New Password</label>

                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control" name="new-password"
                                        required>

                                    @if ($errors->has('new-password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('new-password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new-password-confirm" class="col-md-4 control-label">Confirm New
                                    Password</label>

                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" class="form-control"
                                        name="new-password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <br>

                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container col-sm-12 col-lg-6">
                <div class="card card-default">
                    <div class="card-header h3">Change Settings</div>
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" id="updateProfileForm"
                            onsubmit="event.preventDefault(); submitProfile();" action="#">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="new-password" class="col-md-4 control-label">First Name</label>

                                <div class="col-md-12">
                                    <input type="text" value="{{ Auth::user()->fname }}" class="form-control"
                                        name="fname" id="fname" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new-password" class="col-md-4 control-label">Last Name</label>

                                <div class="col-md-12">
                                    <input type="text" value="{{ Auth::user()->lname }}" class="form-control"
                                        name="lname" id="lname" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new-password" class="col-md-4 control-label">Phone</label>

                                <div class="col-md-12">
                                    <input type="number" value="{{ Auth::user()->phone }}" class="form-control"
                                        name="phone" id="phone" required>
                                </div>
                            </div>



                            <div class="form-group">
                                <br>
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Settings
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        function submitProfile() {
            $.ajax("{{ url('api/update_user_profile_info/' . Auth::id()) }}", {
                dataType: 'json', // type of response data
                data: {
                    "fname": $("#fname").val(),
                    "lname": $("#lname").val(),
                    "phone": $("#phone").val(),
                },
                timeout: 30000, // timeout milliseconds
                type: 'POST',

                success: function(data, status, xhr) { // success callback function
                    console.log(data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                    })
                },
                error: function(jqXhr, textStatus, errorMessage) { // error callback 
                    console.log(errorMessage);
                }
            });
        }

        function getProfile() {
            $.ajax("{{ url('api/get_user_profile_info/' . Auth::id()) }}", {
                dataType: 'json', // type of response data
                timeout: 30000, // timeout milliseconds
                type: 'GET',
                success: function(data, status, xhr) { // success callback function
                    console.log(data);
                },
                error: function(jqXhr, textStatus, errorMessage) { // error callback 
                    console.log(errorMessage);
                }
            });
        }

        $(window).load(function() {
            getProfile();
        })
    </script>


    <script>
        function submitPassword() {
            $.ajax("{{ url('api/password-reset/' . Auth::id()) }}", {
                dataType: 'json', // type of response data
                data: {
                    "old_password": $("#current-password").val(),
                    "new_password": $("#new-password").val(),
                    "confirm_password": $("#new-password-confirm").val(),
                },
                timeout: 30000, // timeout milliseconds
                type: 'POST',

                success: function(data, status, xhr) { // success callback function
                    console.log(data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                    });

                    document.getElementById("password-form").reset();

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
