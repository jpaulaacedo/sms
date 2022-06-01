<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PSRTI | VAMRS</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Muli'>
    <link rel="stylesheet" href="./style.css">

</head>
<!-- <div class="pt-4" style ="background-image: url('/images/samplebg.jpg');
  background-repeat: no-repeat; 
  background-position:auto;
  background-attachment:auto;
  background-attachment: scroll;
  background-size: cover
"> -->

<body>

    <!-- @extends('partials._header') -->

    <!-- background -->


    <a href="{{ route('home') }}" class="brand-link">

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">

                    <div class="card card-body">
                        <center><img src="{{asset('images/psrti_logo.png')}}" width="105" height="100" alt="PSRTI Logo" class="brand-image img-circle elevation-2" style="opacity: .8"></center>
    </a>
    <br>
    <h3 class="text-center" style="font-family:Calibri;"> Vehicle and Messengerial Request System</h3>
    <br>
    <form id="submitForm" action="{{ route('login') }}" method="post" data-parsley-validate="" data-parsley-errors-messages-disabled="true" novalidate="" _lpchecked="1"><input type="hidden" name="_csrf" value="7635eb83-1f95-4b32-8788-abec2724a9a4">
        <div class="form-group required">
            <lSabel for="Email">Email Address</lSabel>
            <input type="text" id="email" class="form-control" name="email" required autofocus>
            @if ($errors->has('email'))
            <strong><span class="text-danger">{{ $errors->first('email') }}</span></strong>
            @endif
        </div>
        <div class="form-group required">
            <label for="password" class="d-flex flex-row align-items-center">{{ __('Password') }}
                <a class="ml-auto border-link small-xl"> <a href="/password/reset">Forgot Password?</a></label>

            <input id="password" type="password" class="form-control" name="password" required>
            @if ($errors->has('password'))
            <strong><span class="text-danger">{{ $errors->first('password') }}</span><strong>
                    @endif


        </div>
        <div class="form-group mt-4 mb-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="remember-me" name="remember-me" data-parsley-multiple="remember-me">
                <label class="custom-control-label" for="remember-me">Remember me?</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>Not yet registered?</label>
            <a class="ml-auto border-link small-xl"> <a href="/register">Click here.</a></label>

            </div>
        </div>
        <div class="form-group pt-1">
            <button class="btn btn-primary btn-block" type="submit">Log In</button>
        </div>
        @csrf
    </form>

    </div>
    </div>
    </div>
    </div>
    </div>


</body>

</html>