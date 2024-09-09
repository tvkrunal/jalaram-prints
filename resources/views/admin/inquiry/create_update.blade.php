@extends('layouts.admin.master')
@section('title', isset($inquiry)?'Update Inquiry':'Create Inquiry')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.page_header',['breadcrumb'=>[route('inquiry.index')=>'Inquiry']])
        <!-- Content area -->
            <div class="content">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title">@if(isset($inquiry)) Update @else Create @endif Inquiry</h6>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                        <a class="list-icons-item" data-action="remove"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @if(isset($inquiry))
                                    {{ Form::model($inquiry, ['route' => ['inquiry.update', $inquiry->id], 'method' => 'patch' , 'enctype'=>'multipart/form-data']) }}
                                @else
                                    {{ Form::open(['route' => 'inquiry.store' , 'enctype'=>'multipart/form-data']) }}
                                @endif
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Customer <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            <div class="d-flex align-items-center">
                                                {{ Form::select('customer_id', $customers, Request::old('customer_id'), array('class'=>"form-control select2", 'id' => "customer_id",'placeholder' => 'Select Customer'))}}
                                                @if ($errors->has('customer_id'))
                                                    <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                                                @endif
                                                <button type="button" class="ml-3 btn btn-primary fa-2x py-0 modal-popup-add-customer">+</button>
                                            </div>
                                        </div>
                                        <label class="col-form-label col-lg-1">Date Of Delivery <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::date('delivery_date',Request::old('delivery_date'),array('class'=>"form-control")) }}
                                            @if ($errors->has('delivery_date'))
                                                <span class="text-danger">{{ $errors->first('delivery_date') }}</span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                    <div class="form-group row d-none customer-details">
                                        <label class="col-form-label col-lg-1">First Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('first_name','',array('class'=>"form-control", 'id' => 'first_name','disabled' => 'true')) }}
                                        </div>
                                        <label class="col-form-label col-lg-1">Last Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('last_name',Request::old('last_name'),array('class'=>"form-control",'id' => 'last_name','disabled' => 'true')) }}
                                            @if ($errors->has('last_name'))
                                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row d-none customer-details">
                                        <label class="col-form-label col-lg-1">Email <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('email',Request::old('email'),array('class'=>"form-control",'id' => 'email','disabled' => 'true')) }}
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <label class="col-form-label col-lg-1">Contact No <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::number('contact_no',Request::old('contact_no'),array('class'=>"form-control",'id' => 'contact_no','disabled' => 'true')) }}
                                            @if ($errors->has('contact_no'))
                                                <span class="text-danger">{{ $errors->first('contact_no') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row d-none customer-details">
                                        <label class="col-form-label col-lg-1">Address <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('address',Request::old('address'),array('class'=>"form-control",'id' => 'address','disabled' => 'true')) }}
                                            @if ($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                        <label class="col-form-label col-lg-1">City <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('city',Request::old('city'),array('class'=>"form-control",'id' => 'city','disabled' => 'true')) }}
                                            @if ($errors->has('city'))
                                                <span class="text-danger">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row customer-details d-none">
                                        <label class="col-form-label col-lg-1">Pin Code <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('pin_code',Request::old('pin_code'),array('class'=>"form-control",'id' => 'pin_code','disabled' => 'true')) }}
                                            @if ($errors->has('pin_code'))
                                                <span class="text-danger">{{ $errors->first('pin_code') }}</span>
                                            @endif
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Job Description <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::textarea('job_description',Request::old('job_description'),array('class'=>"form-control",'rows' => '2')) }}
                                            @if ($errors->has('job_description'))
                                                <span class="text-danger">{{ $errors->first('job_description') }}</span>
                                            @endif
                                        </div>
                                            <label class="col-form-label col-lg-1">Process <span class="text-danger">*</span></label>
                                            <div class="col-lg-5">
                                                {{ Form::select('processes[]', [ 'Print' => 'Print','Lamination' => 'Lamination', 'Half-Cut' => 'Half-Cut', 'Full-Cut' => 'Full-Cut','Binding' => 'Binding','Other Process' => 'Other Process'], old('processes', $processes ?? ''), [
                                                    'class' => 'form-control select2',
                                                    'id' => 'processes',
                                                    'multiple' => 'multiple'
                                                ]) }}
                                            @if ($errors->has('processes'))
                                                <span class="text-danger">{{ $errors->first('processes') }}</span>
                                            @endif
                                        </div>
                                   </div>

                                   <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Type of Job <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            <span class="col-5 ml-3">
                                                {{ Form::radio('type_of_job', 'Design', old('type_of_job') == 'Design', ['class' => 'form-check-input', 'id' => 'job_design']) }}
                                                {{ Form::label('job_design', 'Design', ['class' => 'form-check-label']) }}
                                            </span>
                                            <span class="col-5 ml-3">
                                                {{ Form::radio('type_of_job', 'Print', old('type_of_job') == 'Print', ['class' => 'form-check-input', 'id' => 'job_print']) }}
                                                {{ Form::label('job_print', 'Print', ['class' => 'form-check-label']) }}
                                            </span>
                                            <span class="col-5 ml-3">
                                                {{ Form::radio('type_of_job', 'Design Print', old('type_of_job') == 'Design Print', ['class' => 'form-check-input', 'id' => 'job_design_print']) }}
                                                {{ Form::label('job_design_print', 'Design Print', ['class' => 'form-check-label']) }}
                                            </span>
                                            @if ($errors->has('type_of_job'))
                                                <span class="text-danger">{{ $errors->first('type_of_job') }}</span>
                                            @endif
                                        </div>
                                   </div>

                                   <div class="form-group row d-none designing-details-container">
                                        <label class="col-form-label col-lg-1">Designing Details</label>
                                        <div class="col-lg-5">
                                            {{ Form::text('designing_details',Request::old('designing_details'),array('class'=>"form-control")) }}
                                            @if ($errors->has('designing_details'))
                                                <span class="text-danger">{{ $errors->first('designing_details') }}</span>
                                            @endif
                                        </div>
                                   </div>

                                    <div class="form-group row d-none designing-details-print-container">
                                        @include('admin.inquiry.price_master_section')
                                    </div>
                                    
                                </fieldset>
                                <div class="row d-none designing-details-print-container">
                                    <div class="col-4 mt-3 offset-8 mb-3">
                                        <label class="form-label">Cost Calculation</label>
                                        {{ Form::text('cost_calculation', isset($inquiry) ? $inquiry->cost_calculation :Request::old('cost_calculation'), array('class'=>"form-control", 'id' => 'total_cost')) }}
                                        @if ($errors->has('cost_calculation'))
                                            <span class="text-danger">{{ $errors->first('cost_calculation') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    {{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
                                    <a href="{{ route('inquiry.index') }}" class="btn btn-primary">Cancel</a>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Modal -->
                <div id="modal_for_add_customer" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content bg-teal-300 view-table-bg">
                            <div class="modal-header">
                                <h5 class="modal-title">Create Customer</h5>
                                <button type="button" class="close">&times;</button>
                            </div>

                            <div class="modal-body">
                                {{ Form::open(['route' => 'store.customer' ,'id'=>'customer-form', 'enctype'=>'multipart/form-data']) }}
                                @csrf
                                <fieldset class="mb-3 row gy-4">
                                    <div class="form-group col-lg-6">
                                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                                        <div class="mb-4">
                                            {{ Form::text('first_name',Request::old('first_name'),array('class'=>"form-control")) }}
                                            <span class="text-danger print-error-msg print-msg-first_name"
                                                    style="display:none"></span>
                                        </div>
                                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <div>
                                            {{ Form::text('last_name',Request::old('last_name'),array('class'=>"form-control")) }}
                                            <span class="text-danger print-error-msg print-msg-last_name"
                                            style="display:none"></span>
                                        </div>
                                    </div>


                                    <div class="form-group col-lg-6">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <div class="mb-4">
                                            {{ Form::text('email',Request::old('email'),array('class'=>"form-control")) }}
                                            <span class="text-danger print-error-msg print-msg-email"
                                            style="display:none"></span>
                                        </div>
                                        <label class="form-label">Contact No <span class="text-danger">*</span></label>
                                        <div>
                                            {{ Form::text('contact_no',Request::old('contact_no'),array('class'=>"form-control")) }}
                                            <span class="text-danger print-error-msg print-msg-contact_no"
                                            style="display:none"></span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label class="form-label">Address <span class="text-danger">*</span></label>
                                        <div class="mb-4">
                                            {{ Form::text('address',Request::old('address'),array('class'=>"form-control")) }}
                                            <span class="text-danger print-error-msg print-msg-address"
                                            style="display:none"></span>
                                        </div>
                                        <label class="form-label">City <span class="text-danger">*</span></label>
                                        <div>
                                            {{ Form::text('city',Request::old('city'),array('class'=>"form-control")) }}
                                            <span class="text-danger print-error-msg print-msg-city"
                                            style="display:none"></span>
                                        </div>
                                    </div>


                                    <div class="form-group col-lg-6">
                                        <label class="form-label">Pin Code <span class="text-danger">*</span></label>
                                        <div>
                                            {{ Form::text('pin_code',Request::old('pin_code'),array('class'=>"form-control")) }}
                                            <span class="text-danger print-error-msg print-msg-pin_code"
                                            style="display:none"></span>
                                        </div>
                                   </div>
                                    
                                </fieldset>

                                <div class="text-right">
                                    {{ Form::submit('Submit',array('class'=>'btn btn-primary', 'id' => 'customer-btn')) }}
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /view modal -->
        <!-- /content area -->
        @include('layouts.admin.page_footer')
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Function to show/hide the Designing Details field based on the selected radio button
        $('.designing-details-container').addClass('d-none');
        $('.designing-details-print-container').addClass('d-none');
        setTimeout(() => {
           $('.alert').hide(); 
        }, 700);
        
        function toggleDesigningDetails() {
            let selectedJobType = $('input[name="type_of_job"]:checked').val();
            if (selectedJobType === 'Design' || selectedJobType === 'Design Print') {
                $('.designing-details-container').removeClass('d-none');
                $('.designing-details-print-container').addClass('d-none');
            } else if(selectedJobType === 'Print'){
                $('.designing-details-container').addClass('d-none');
                $('.designing-details-print-container').removeClass('d-none');
            }
        }

        // Initial check on page load
        toggleDesigningDetails();

        // Check when radio buttons are clicked
        $('input[name="type_of_job"]').on('change', function() {
            toggleDesigningDetails();
        });

        $('#main-page-content').on('click','.modal-popup-add-customer',function () {
            $('#modal_for_add_customer').modal('show');
        });

        $('#customer_id').on('change', function() {
            let customerId = $(this).val();
            let customerUrl= "{{ route('get.customer','')}}";
            $('.customer-details').addClass('d-none');
            if(customerId != '') {
                $.ajax({
                    url: customerUrl + '/' + customerId,
                    type: 'GET',
                    success: function (response) {
                        if(response.status) {
                            $('.customer-details').removeClass('d-none');
                            if(response.customer) {
                                $('#first_name').val(response.customer.first_name);
                                $('#last_name').val(response.customer.last_name);
                                $('#email').val(response.customer.email);
                                $('#contact_no').val(response.customer.contact_no);
                                $('#address').val(response.customer.address);
                                $('#city').val(response.customer.city);
                                $('#pin_code').val(response.customer.pin_code);                      
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        
                    }
                });
            }
        });

        $('.close').on('click', function() {
            $('.print-error-msg').css('display', 'none');
            $('#modal_for_add_customer').modal('hide');
        });


        $('#customer-form').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var formAction = $(this).attr('action');
            $("#customer-btn").prop("disabled", true);
            $.ajax({
                url: formAction,
                method: $(this).attr('method'),
                data: formData,
                success: function(response) {
                    $("#customer-form")[0].reset();
                    $("#customer-btn").prop("disabled", false);
                    $('#modal_for_add_customer').modal('hide');
                    window.location.reload();
                },
                error: function(data) {
                    $("#customer-btn").prop("disabled", false);
                    $.each(data.responseJSON.errors, function (key, value) {
                        $(".print-msg-" + key + "").css("display", "block");
                        $(".print-msg-" + key + "").html(value[0]);
                    });
                }
            });
        });

        /* Price master repeater */
        $(".price-master-repeater").repeater({
            initEmpty: false,
            show: function () {
                var selfRepeaterItem = this;
                $(selfRepeaterItem).slideDown();
                $(selfRepeaterItem).find('.select2-container').remove();
                // Initialize select2 on the newly added repeater item
                $(selfRepeaterItem).find('.select2').select2();

                var repeaterItems = $("div[data-repeater-item] > div.inquiry-price-itemsfaq-items");
                $(selfRepeaterItem).attr('data-index', repeaterItems.length - 1);
                $(selfRepeaterItem).find('span.repeaterItemNumber').text(repeaterItems.length);
                $(selfRepeaterItem).find('.price-master-delete').attr('data-id', null);
            },
            hide: function (deleteElement) {
                if (confirm("Are you sure you want to delete this element?")) {
                    $(this).slideUp(deleteElement);
                }
            },
        });

        $(document).on('input', 'input[name^="inquiryPriceItemSection"][name$="[qty]"], input[name^="inquiryPriceItemSection"][name$="[cost]"]', function() {
            calculateTotalCost();
        });

        /**
         *  Delete inquiry item 
         */
        $('body').on('click', '.inquiry-item-delete', function (event) {
            event.preventDefault();
            var id = $(this).data("id");
            var inquiryItem = $(this).closest('[data-repeater-item]');
            var destroy = "{{ route('inquiry.priceitem.destroy','') }}"
            if(id) {
                $.ajax({
                    type: 'GET',
                    url: destroy + '/' + id,
                    success: function (data) {
                        if(data.status) {
                            inquiryItem.remove();
                            calculateTotalCost();
                        }
                    }
                });
            } else {
                if(confirm('Are you sure you want to delete this element?')) {
                    inquiryItem.remove();
                }
            }
        });
    });

    $(document).on('change', '.select2', function () {
        var selectedItem = $(this).val(); // Get the selected value from the dropdown
        
        // Find the specific repeater item where the dropdown was changed
        var repeaterItem = $(this).closest('[data-repeater-item]');
        var itemTypeDetailsRoute = "{{ route('get.price.master.details','') }}";

        if (selectedItem) {
            $.ajax({
                url: itemTypeDetailsRoute + '/' + selectedItem, // URL to fetch the item details
                method: 'GET',
                success: function (response) {
                    repeaterItem.find('input[name^="inquiryPriceItemSection"][name$="[media]"]').val(response.priceMaster.media);
                    repeaterItem.find('input[name^="inquiryPriceItemSection"][name$="[gsm]"]').val(response.priceMaster.gsm);
                    repeaterItem.find('input[name^="inquiryPriceItemSection"][name$="[qty]"]').val(response.priceMaster.qty);
                    repeaterItem.find('input[name^="inquiryPriceItemSection"][name$="[cost]"]').val(response.priceMaster.max_cost);
                    calculateTotalCost(); 
                },
                error: function (xhr) {
                    console.error(xhr);
                }
            });
        }
    });

    // Function to calculate the total cost
    function calculateTotalCost() {
        let totalCost = 0;

        $('[data-repeater-item]').each(function () {
            let itemCost = $(this).find('input[name^="inquiryPriceItemSection"][name$="[cost]"]').val();
            let itemQty = $(this).find('input[name^="inquiryPriceItemSection"][name$="[qty]"]').val();
            console.log(itemCost);
            if (itemCost || itemQty) {
                if(itemQty) {
                    totalCost += parseFloat(itemCost) * parseFloat(itemQty);
                } else{
                    totalCost += parseFloat(itemCost);
                }
            }
        });

        // Update the total cost field
        $('#total_cost').val(totalCost.toFixed(2));  // Format to 2 decimal places
    }
</script>
@endsection
