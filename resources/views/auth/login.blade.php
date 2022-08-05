<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Finance | SMS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Muli'>
    <link rel="stylesheet" href="./style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <style>
        footer {
            width: 110%;
            height: 95px;
            background-image: url("{{asset('images/bg.jpg')}}");
            text-align: center;
        }

        .copyright {
            color: white;
        }
    </style>
</head>


<body style="overflow-x: hidden">
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-md">
            <div class="container">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <center>
                                <img src="{{asset('images/sms_login.png')}}" width="80%" height="80%" alt="SMS Logo">
                            </center>
                        </div>
                        <div class="col-sm-6">
                            <center>
                                <img src="{{asset('images/sms.png')}}" width="110" height="100"><br>
                            </center>
                            <br>
                            <br>
                            <form id="submitForm" action="{{ route('login') }}" method="post" data-parsley-validate="" data-parsley-errors-messages-disabled="true" novalidate="" _lpchecked="1"><input type="hidden" name="_csrf" value="7635eb83-1f95-4b32-8788-abec2724a9a4">
                                <div class="form-group required">
                                    <span for="username">User name</span>
                                    <input type="text" id="email" class="form-control" name="email" required autofocus>
                                    @if ($errors->has('email'))
                                    <strong><span class="text-danger">{{ $errors->first('email') }}</span></strong>
                                    @endif
                                </div>
                                <div class="form-group required">
                                    <span for="password">{{ __('Password') }}
                                    </span>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                    <strong><span class="text-danger">{{ $errors->first('password') }}</span><strong>
                                            @endif
                                </div>
                                <div class="form-group mt-4 mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remember-me" name="remember-me" data-parsley-multiple="remember-me">
                                        <span class="custom-control-label" for="remember-me">Remember me?</span>
                                    </div>
                                </div>
                                <div class="form-group pt-1">
                                    <button class="btn btn-primary btn-block" type="submit">Log In</button>
                                </div>
                                <center>
                                    <a class="ml-auto border-link small-xl"> <a href="/password/reset">Forgot password?</a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span>Not yet registered?</span>
                                        <a class="ml-auto border-link small-xl"> <a href="/register">Click here.</a></label>
                                </center>
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <br>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-sm">
            <footer>
                <br>
                <a style="color: white;"><strong>SMS | Copyright&copy;2022.</a></strong>
                <a style="color: white;">All rights reserved.</a>
            </footer>
        </div>
    </div>
    </div>

</body>

</html>