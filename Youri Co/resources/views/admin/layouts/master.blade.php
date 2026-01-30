    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="JMS (Jal Management System) is a smart water delivery solution for shops, helping manage customer orders, bottle returns, and subscriptions with ease. It reduces losses, builds customer loyalty, and makes daily operations efficient.">
        <meta name="author" content="">
        <meta property="og:image" content="/assets/images/ogimage.png"/>

        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
        <title>JMS</title>
        <!-- This page CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css">
        <!-- chartist CSS -->
        <link href="/assets/node_modules/morrisjs/morris.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="/assets/css/style.min.css" rel="stylesheet">
        <!-- Dashboard 1 Page CSS -->
        <link href="/assets/css/pages/dashboard1.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">


    </head>

    <body class="skin-default-dark fixed-layout">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="loader">
                <div class="loader__figure"></div>
                <p class="loader__label">JMS</p>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            @include('admin.layouts.header')
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            @include('admin.layouts.sidebar')
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
                <div class="page-wrapper">
                    <div class="container-fluid">
                        <div class="row page-titles">
                            <div class="col-md-5 align-self-center">
                             <h4 class="text-themecolor">
                                @if(Auth::user()->user_type !== 4)
                                    Super Admin
                                @else
                                    Deactivate Mobile User
                                @endif
                            </h4>
                            </div>
                            <div class="col-md-7 align-self-center text-right">
                                <div class="d-flex justify-content-end align-items-center">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item active">@yield('page-title')</li> 
                                    </ol>
                                </div>
                            </div>
                        </div>
            
                         @yield('main-content')
                    </div>
                </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2025 Designed By BSS
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap popper Core JavaScript -->
        <script src="/assets/node_modules/popper/popper.min.js"></script>
        <script src="/assets/node_modules/bootstrap//assets/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="/assets/js/perfect-scrollbar.jquery.min.js"></script>
        <!--Wave Effects -->
        <script src="/assets/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="/assets/js/sidebarmenu.js"></script>
        <!--Custom JavaScript -->
        <script src="/assets/js/custom.min.js"></script>
        <!-- ============================================================== -->
        <!-- This page plugins -->
        <!-- ============================================================== -->
        <!--morris JavaScript --> 
        <script src="/assets/node_modules/raphael/raphael-min.js"></script>
        <script src="/assets/node_modules/morrisjs/morris.min.js"></script>
        <script src="/assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
        <!-- Chart JS -->
        <script src="/assets/js/dashboard1.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script>
            $(function() {
                $('.toggle-status').bootstrapToggle();
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        @if(session('success'))
            <script>
                toastr.options = {
                    "positionClass": "toast-top-right",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.success("{{ session('success') }}", "Success!");
            </script>
        @endif
        
        @if(session('error'))
            <script>
                toastr.options = {
                    "positionClass": "toast-top-right",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr.error("{{ session('error') }}", "Error!");
            </script>
        @endif

    </body>

    </html>