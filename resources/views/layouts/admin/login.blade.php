<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon-192x192.png') }}" sizes="192x192">

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-theme/css/app.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/toastr/toastr.min.css')}}">
    <!-- /global stylesheets -->
@yield('stylesheets')
</head>
<body class="log-in-page">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">
                @yield('content')
            </div> <!-- /Content area -->
        </div> <!-- /main content -->
    </div> <!-- /page content -->

    <!-- Core JS files -->
    <script src="{{asset('admin-theme/global_assets/js/main/jquery.min.js')}}"></script>
    <script src="{{asset('admin-theme/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{asset('admin-theme/js/app.js')}}"></script>
    <script src="{{asset('admin-theme/global_assets/js/demo_pages/login.js')}}"></script>
    <!-- /theme JS files -->

    <script>
        function togglePassword(inputId, eyeIconId) {
          var passwordInput = document.getElementById(inputId);
          var eyeIcon = document.getElementById(eyeIconId);

          if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("bi-eye-slash-fill");
            eyeIcon.classList.add("bi-eye-fill");
          } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("bi-eye-fill");
            eyeIcon.classList.add("bi-eye-slash-fill");
          }
        }

        /**
         * Toastr message
         */
        toastr.options.timeOut = 3000;
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
    </script>
</body>
</html>
