@extends('layouts.master')

@section('content')

    <!--suppress ALL -->
    <section id="sign-in">

        <!-- Background Bubbles -->
        <canvas id="bubble-canvas"></canvas>
        <!-- /Background Bubbles -->

        <!-- Sign In Form -->
        <form  id="login-form" data-parsley-excluded=".close, input[type=hidden], :hidden">

            <div class="row links">
                <div class="col s6 logo">
                    <img src="/assets/admin/assets/_con/images/logo-white.png" alt="">
                </div>
            </div>

            <div class="card-panel clearfix">
                <div id="login-error" class="alert alert-dismissible lighten-4 text-darken-2 hide">

                </div>
                <!-- Username -->
                <div class="input-field">
                    <input id="username-input"  placeholder=" " type="text" class="validate" name="user_name" required>
                    <label for="username-input"> {{ trans('client_input.user_name') }}</label>
                </div>
                <!-- /Username -->

                <!-- Password -->
                <div class="input-field">
                    <input id="password-input"  placeholder=" " type="password" class="validate" name="password" required>
                    <label for="password-input">{{ trans('client_input.password') }}</label>
                </div>
                <!-- /Password -->

                <div class="switch">
                    <label>
                        <input type="checkbox" checked />
                        <span class="lever"></span>
                        Remember
                    </label>
                </div>

                <button class="waves-effect waves-light btn-large z-depth-0 z-depth-1-hover" type="submit">Sign In</button>
            </div>
        </form>
        <!-- /Sign In Form -->

    </section>


@endsection
@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('#login-form')
                    .parsley()
                    .on('form:submit', function(e) {

                        var request = {
                            method : 'POST',
                            data : $('#login-form').serializeObject(),
                            url : 'dang-nhap',
                            success : function(response){
                                $('#login-error').addClass('show hide').html('');
                                window.location.href = response.intended;
                            },
                            error : function(error){
                                var json = error.responseJSON;
                                $('#login-error').toggleClass('hide show').html(json.message + '<button type="button" class="close">&times;</button>');
                            }
                        }
                        window.conApp.ajaxCall(request);
                        return false;

            });
        });
    </script>
@endsection
