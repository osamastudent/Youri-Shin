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
        <title>Youri & Co.</title> 
        <!-- This page CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/themify-icons/0.1.2/css/themify-icons.css">
        <!-- chartist CSS -->
        <link href="/assets/node_modules/morrisjs/morris.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="/assets/css/style.min.css" rel="stylesheet">
        <!-- Dashboard 1 Page CSS -->
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

        <link href="/assets/css/pages/dashboard1.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-results__option {
                color: #fff;
                background-color: #2B2B2B;
            }
            
            .select2-results__option--highlighted {
                color: #fff; 
                background-color: #01C0C8; 
            }
            
            .select2-container--default .select2-results__option[aria-selected=true] {
                background-color: #01C0C8; 
                color: #fff;
            }
        </style>

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
            @include('companyAdmin.layouts.header')
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            @include('companyAdmin.layouts.sidebar')
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
                                <h4 class="text-themecolor" style="padding-left: 33px;">Company Admin</h4>
                            </div>
                            <div class="col-md-7 align-self-center text-right">
                                <div class="d-flex justify-content-end align-items-center">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                        <li class="breadcrumb-item active">@yield('page-title')</li> 
                                    </ol>
                                </div>
                            </div>
                                <div id="notifications" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>
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
        <script src="{{ asset('js/app.js') }}"></script>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <!-- Include Laravel Echo -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#sale_id').select2({
                });
                $('#customer_id').select2({
                });
                $('#item_id').select2({
                });
            });
        </script>


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
        <script>
document.addEventListener('DOMContentLoaded', function() {
    let lastOrderId = null;
    let notifiedOrders = new Set(); // Track which orders have been notified

    function checkForNewOrders() {
        fetch('{{ route('company-sale.orders') }}')
            .then(response => response.json())
            .then(data => {
                if (!data || !data.id) return;

                // Only trigger for new (unseen) orders
                if (!notifiedOrders.has(data.id)) {
                    showNotification(data);
                    notifiedOrders.add(data.id);
                }

                lastOrderId = data.id;
            })
            .catch(error => console.error('Error fetching latest orders:', error));
    }

    function showNotification(order) {
        toastr.options = {
            "positionClass": "toast-top-right",
            "timeOut": 0,                    // ❌ Never auto-dismiss
            "extendedTimeOut": 0,            // ❌ Disable hover timeout
            "closeButton": true,             // ✅ Show close (X) button
            "tapToDismiss": true,            // ✅ User can click to close
            "progressBar": true,             // ✅ Show progress bar (optional)
            "preventDuplicates": true,       // Avoid duplicates
            "newestOnTop": true,             // Show latest on top
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // 🔔 Show persistent toast
        toastr.success(
            'You have a new order! <br><strong>Order ID:</strong> ' + order.id +
            '<br>'+
            'New Order Received!'
        );

        // 🔊 Play sound or voice
        speak('You have a new order!');
    }

    function speak(text) {
        // Stop any previous speech first
        window.speechSynthesis.cancel();

        const msg = new SpeechSynthesisUtterance();
        msg.text = text;
        msg.rate = 0.9;
        msg.pitch = 1;
        msg.volume = 1;
        window.speechSynthesis.speak(msg);
    }

    // 🔁 Check every 5 seconds for new orders
    setInterval(checkForNewOrders, 5000);
});
</script>



    </body>

    </html>