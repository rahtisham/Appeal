
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <meta name="robots" content="" />
  <meta name="description" content="Davur - Restaurant Bootstrap Admin Dashboard + FrontEnd" />
  <meta property="og:title" content="Davur - Restaurant Bootstrap Admin Dashboard + FrontEnd" />
  <meta property="og:description" content="Davur - Restaurant Bootstrap Admin Dashboard + FrontEnd" />
  <meta property="og:image" content="https://davur.dexignzone.com/dashboard/social-image.png" />
  <meta name="format-detection" content="telephone=no">
    <title>AppealLab </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/apealLogo.png') }}">
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
                                    <h4 class="text-center mb-4">Forget Password</h4>
                                     <main class="login-form">
  <div class="cotainer">
      <div class=" justify-content-center">
          <div class="">
              <div class="card">
                  <!-- <div class="card-header">Reset Password</div> -->
                  <div class="card-body">
  
                    @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
  
                      <form action="{{ route('forget.password.post') }}" method="POST">
                          @csrf
                          <div class="form-group">
                              <label for="email_address" class="col-form-label text-md-right">E-Mail Address</label>
                              
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                             
                          </div>
                          <div class="">
                              <button type="submit" class="btn btn-primary">
                                  Send Password Reset Link
                              </button>
                          </div>
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>

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









