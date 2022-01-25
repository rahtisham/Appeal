<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="description" content="" />
	<meta property="og:title" content="Registration |AppealLab" />
	<meta property="og:description" content="" />
	<meta property="og:image" content="https://davur.dexignzone.com/dashboard/social-image.png" />
	<meta name="format-detection" content="telephone=no">
    <title>AppealLab</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
<style type="text/css">
    .login-logo {
    font-size: 2.1rem;
    font-weight: 300;
    margin-bottom: .9rem;
    text-align: center;
}
</style>
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="{{ route('user_register') }}"><img src="{{ asset('./images/logo.png') }}"  width="180px" /></a>
                                    </div>

                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form method="POST" action="{{ route('user_register') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Username</strong></label>
                                            <input type="text" name="name" class="form-control" placeholder="" required>
                                        </div>
                                        @if ($errors->has('name'))
                                        <span class="error text-danger">{{ $errors->first('name') }}</span>
                                        @endif 
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" placeholder="" required>
                                        </div>
                                            @if ($errors->has('email'))
                                            <span class="error text-danger">{{ $errors->first('email') }}</span>
                                            @endif 
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control" value="" required>
                                        </div>

                                        @if ($errors->has('password'))
                                        <span class="error text-danger">{{ $errors->first('password') }}</span>
                                        @endif 

                                        <!-- <div class="form-group">
                                            <label class="mb-1"><strong>Confirm Password</strong></label>
                                            <input type="password" name="password_confirmation" class="form-control" value=""
                                            required>
                                        </div> -->


                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                                        </div>



                                        
                                    </form>

                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="{{ route('login') }}">Sign in</a></p>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('js/global/global.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/deznav-init.js') }}"></script>

</body>

</html>