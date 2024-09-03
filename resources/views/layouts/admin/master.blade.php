<!-- master.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon-192x192.png') }}" sizes="192x192">

    <!-- Global stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" />
    <link rel="stylesheet" type="text/css" href="{{asset('admin-theme/global_assets/css/icons/icomoon/styles.css')}}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('admin-theme/css/components.min.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-theme/css/app.min.css?ver=')}}{{env('CDN_VERSION') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    @yield('stylesheets')
</head>

<body>
    <div class="d-flex flex-column flex-lg-row h-lg-full min-h-screen bg-surface-secondary vstack">
        @include('layouts.admin.sidebar')
        <div class="flex-lg-1 h-lg-screen overflow-y-lg-auto">
            @include('layouts.admin.header')
            <div class="container-fluid py-6 gx-12" id="main-page-content">
                @yield('content')
            </div>
        </div>
    </div>
    <div id="modal_delete_warning" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                <i class="bi bi-exclamation-circle h1 text-danger"></i>
                    <p class="modal-text mt-3"></p>  
                </div>
                <div class="p-6 d-flex gap-2 justify-content-end border-top">
                    <button type="button" class="btn btn-sm btn-neutral" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-danger modal-delete-confirm m-0">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_for_view" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content view-table-bg">
                <div class="modal-header">
                    <h5 class="modal-title modal-view-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered table_for_view">
                        <tbody id="modal-table-data">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS files -->
    <script src="{{asset('admin-theme/global_assets/js/main/jquery.min.js')}}"></script>
    <script src="{{asset('admin-theme/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('admin-theme/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admin-theme/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('admin-theme/global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script src="{{asset('admin-theme/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('admin-theme/js/jquery-ui.js')}}"></script>
    </script>
    
    @yield('theme_js')
    <script src="{{asset('admin-theme/js/app.js?ver=')}}{{env('CDN_VERSION') }}"></script>
    <script src="{{asset('admin-theme/js/custom.js?ver=')}}{{env('CDN_VERSION') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- /theme JS files -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            if ($('.select2').length) {
                $('.select2').each(function () {
                    $(this).select2({
                        dropdownParent: $(this).parent(),
                    });
                });
            }
        });


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
    @yield('scripts')
</body>

</html>