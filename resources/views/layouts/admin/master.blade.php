<!-- master.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-theme/global_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-theme/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-theme/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-theme/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-theme/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-theme/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-theme/css/custom.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-theme/css/fullcalendar.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-theme/css/cropper.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.svg') }}">

@yield('stylesheets')
<style>
    .switch input
    {
        display: none;
    }

    .switch 
    {
        display: inline-block;
        width: 32px;
        height: 16px;
        margin-top: 11px;
        margin-left: 8px;
        position: relative;
    }

    .slider
    {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        border-radius: 30px;
        box-shadow: 0 0 0 2px #777, 0 0 4px #777;
        cursor: pointer;
        border: 4px solid transparent;
        overflow: hidden;
        transition: 0.2s;
    }

    .slider:before
    {
        position: absolute;
        content: "";
        width: 100%;
        height: 100%;
        background-color: #777;
        border-radius: 30px;
        transform: translateX(-30px); /*translateX(-(w-h))*/
        transition: 0.2s;
    }

    input:checked + .slider:before
    {
        transform: translateX(16px); /*translateX(w-h)*/
    }

    input:checked + .slider
    {
        box-shadow: 0 0 0 2px limeGreen, 0 0 8px limeGreen;
    }

    .switch200 .slider:before
    {
        width: 200%;
        transform: translateX(-43px); /*translateX(-(w-h))*/
    }

    .switch200 input:checked + .slider:before
    {
        background-color: #BA2127;
    }

    .switch200 input:checked + .slider
    {
        box-shadow: 0 0 0 2px #BA2127, 0 0 8px #BA2127;
    }

</style>
</head>
<body>
<div class="wrapper">
    @include('layouts.admin.header')
    <!-- Page content -->
        <div class="page-content" id="main-page-content">
            @include('layouts.admin.sidebar')
            <!-- Main content -->
            @yield('content')
            <!-- /main content -->
        </div>

    <!-- /page content -->


</div>
<!-- Delete modal -->
<div id="modal_delete_warning" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h6 class="modal-title">Warning!!</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <h6 class="font-weight-semibold">Are you sure you want to delete this record ?</h6>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" class="btn bg-warning modal-delete-confirm">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- /delete modal -->

<!-- View Modal -->
<div id="modal_for_view" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-teal-300 view-table-bg">
            <div class="modal-header">
                <h5 class="modal-title">Details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <table class="table table_for_view">
                    <tbody  id="modal-table-data">

                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link text-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /view modal -->

<!-- /Wallet connection modal -->
<div class="modal fade crop-img-model" id="crop-img-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Adjust your image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-10">
                            <img id="image" src="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary"  id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade crop-gallery-img-model" id="crop-gallery-img-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Adjust your image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-10">
                            <img id="gallery_image" src="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary"  id="cropGallery">Crop</button>
            </div>
        </div>
    </div>
</div>

<div id="loader" class="lds-dual-ring-full hidden overlay"></div>

<!-- Core JS files -->
<script src="{{asset('admin-theme/global_assets/js/main/jquery.min.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/plugins/ui/ripple.min.js')}}"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script src="{{asset('admin-theme/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>

<script src="{{asset('admin-theme/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/plugins/pickers/anytime.min.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('admin-theme/global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key={{env('GOOGLE_MAP_KEY')}}&sensor=true"></script>
@yield('theme_js')
<script src="{{asset('admin-theme/js/cropper.js') }}"></script>
<script src="{{asset('admin-theme/js/app.js')}}"></script>
<script src="{{asset('admin-theme/js/custom.js?ver=')}}{{env('JS_VERSION')}}"></script>
<script src="{{asset('admin-theme/js/chart.js')}}"></script>
<script src="https://cdn.tiny.cloud/1/{{env('TINY_MCE_KEY')}}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{asset('admin-theme/js/fullcalendar.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>


<!-- Cookies -->
<script src="{{ asset('admin-theme/js/moment/moment_locales.min.js?ver=')}}{{env('JS_VERSION')}}"></script>
<script src="{{ asset('admin-theme/js/moment/moment.min.js?ver=')}}{{env('JS_VERSION')}}"></script>
<script src="{{ asset('admin-theme/js/moment/moment-timezone-with-data-10-year-range.min.js?ver=')}}{{env('JS_VERSION')}}"></script>
<script src="{{asset('admin-theme/js/js.cookie.min.js')}}"></script>

<!-- Form Repeater Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js" integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- /theme JS files -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function (){
        if($('.select2').length){
            $('.select2').select2({
                allowClear: true
            });
        }
        if($('#datepicker').length){
            $( "#datepicker" ).datepicker({
                dateFormat: 'd/m/Y',
                changeMonth: true,
                changeYear: true
            });
        }
        if($('#datepicker').length){
          $("[rel=tooltip]").tooltip({ placement: 'top'});
        }
    });
</script>
</script>
@yield('scripts')
</body>
</html>
