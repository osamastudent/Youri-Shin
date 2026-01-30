<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>JMS - Login</title>
    
    <!-- page css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


<style>
    @media (max-width: 576px) {
    .login-box {
        margin-top: 20px !important;
    }

    .card-body {
        padding: 20px !important;
    }

    h2.box-title {
        font-size: 20px;
    }

    h5.box-title {
        font-size: 16px;
    }
}

</style>

</head>

<body>
  
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== --> 
    <section id="wrapper" class="login-register login-sidebar d-flex justify-content-center align-items-center">
        <!--style="background-image: url('/assets/images/background/weatherbg.jpg');"--> 
<div class="login-box shadow card col-12 col-sm-10 col-md-6 col-lg-4 mt-5 mx-auto">
            <div class="card-body">
                <!-- Error Messages -->
                @if (session('error'))
                    <div class="alert alert-danger alert-sm">
                        <b>{!! session('error') !!}</b>
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h2 class="box-title m-b-20 fw-bolder text-center">Youri & Co.</h2>
                    <h5 class="box-title m-b-20">Sign In</h5>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" id="email"  type="email" name="email" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" id="password" type="password" name="password" required="" placeholder="Password">
                        </div>
                    </div>
                    
                    @if ($errors->any())
                    <p style="color: #dc3545;">
                        <strong>Oops!</strong> Invalid email or password. Please try again.
                    </p>
                    @endif

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="form-group text-center">
                        <div class="col-xs-12 p-b-20">
                            <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">Log In</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                            <!--<div class="social">-->
                            <!--    <a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a>-->
                            <!--    <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a>-->
                            <!--</div>-->
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <!--<div class="col-sm-12 text-center">-->
                        <!--    Don't have an account? <a href="/register" class="text-info m-l-5"><b>Sign Up</b></a>-->
                        <!--</div>-->
                    </div>
                </form>
            </div>
       
        </div>
    </section>
   
    
     
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/node_modules/popper/popper.min.js"></script>
    <script src="../assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
    
</body>

</html>
