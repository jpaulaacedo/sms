
<body style="overflow-x: hidden">
    <a href="{{ route('home') }}" class="brand-link"> </a>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="row wrapper fadeInDown">
        <div class="col-md-6">
            <div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <!-- <img src="{{asset('images/psrti_logo.png')}}" width="105" height="100" alt="PSRTI Logo" class="brand-image img-circle elevation-2"> -->
                <img src="{{asset('images/vamrs_login.png')}}" width="480" height="600" alt="PSRTI Logo" class="brand-image img-circle elevation-2">

            </div>
        </div>

        <div class="col-sm">
            <div class="container">
                <div class="col-md-7">
                    <div class="card card-body">
                        <center>
                            <img src="{{asset('images/truck2.gif')}}" alt="test" width="160" height="100"><br>
                        </center>
                        <br>
                        <br>
                        <form id="submitForm" action="{{ route('login') }}" method="post" data-parsley-validate="" data-parsley-errors-messages-disabled="true" novalidate="" _lpchecked="1"><input type="hidden" name="_csrf" value="7635eb83-1f95-4b32-8788-abec2724a9a4">
                            <div class="form-group required">
                                <lSabel for="Email">Email address</lSabel>
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
                                    <label class="custom-control-label" for="remember-me"> Remember me?</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
<br><br>
    <hr>
    <footer class="main-footer">
        <center>
            <strong>Copyright &copy; 2022 <a href="http://psrti.gov.ph">psrti.gov.ph</a>.</strong> All rights
            reserved.
            <!-- <img src="{{asset('images/footer.png')}}" width="160" height="100"><br> -->

        </center>
    </footer>

</body>
