@extends('layouts.admin.master')
@section('title', 'Inquiry Billing')
<style>
    .btn-link-collapse[aria-expanded="false"] .fa-minus {
        display:none;
    }
    .btn-link-collapse[aria-expanded="true"] .fa-plus {
        display:none;
    }
</style>
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
                                <h4 class="card-title">Inquiry Billing</h4>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                        <a class="list-icons-item" data-action="remove"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @if(isset($inquiry))
                                    {{ Form::model($inquiry, ['route' => ['store.billing'], 'method' => 'POST']) }}
                                @endif
                                <fieldset>
                                {{ Form::hidden('inquiry_id', $inquiry->id)}}
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Customer</label>
                                        <div class="col-lg-5">
                                            <div class="d-flex align-items-center">
                                                {{ Form::select('customer_id', $customers, Request::old('customer_id'), array('class'=>"form-control select2", 'id' => "customer_id",'placeholder' => 'Select Customer','disabled' => 'true'))}}
                                            </div>
                                        </div>
                                        <label class="col-form-label col-lg-1">Date Of Delivery</label>
                                        <div class="col-lg-5">
                                            {{ Form::date('delivery_date',Request::old('delivery_date'),array('class'=>"form-control",'disabled' => 'true')) }}
                                        </div>
                                        
                                    </div>
                                    <div class="form-group row {{ isset($inquiry) && !empty($inquiry->customer) ? '' :'d-none customer-details'}}">
                                        <label class="col-form-label col-lg-1">First Name</label>
                                        <div class="col-lg-5">
                                            {{ Form::text('first_name',isset($inquiry) && !empty($inquiry->customer) && !empty($inquiry->customer->first_name) ? $inquiry->customer->first_name : '',array('class'=>"form-control", 'id' => 'first_name','disabled' => 'true')) }}
                                        </div>
                                        <label class="col-form-label col-lg-1">Last Name</label>
                                        <div class="col-lg-5">
                                            {{ Form::text('last_name',isset($inquiry) && !empty($inquiry->customer) && !empty($inquiry->customer->last_name) ? $inquiry->customer->last_name : '',array('class'=>"form-control",'id' => 'last_name','disabled' => 'true')) }}
                                        </div>
                                    </div>

                                    <div class="form-group row {{ isset($inquiry) && !empty($inquiry->customer) ? '' :'d-none customer-details'}}">
                                        <label class="col-form-label col-lg-1">Email</label>
                                        <div class="col-lg-5">
                                            {{ Form::text('email',isset($inquiry) && !empty($inquiry->customer) && !empty($inquiry->customer->email) ? $inquiry->customer->email : '',array('class'=>"form-control",'id' => 'email','disabled' => 'true')) }}
                                        </div>
                                        <label class="col-form-label col-lg-1">Contact No</label>
                                        <div class="col-lg-5">
                                            {{ Form::number('contact_no',isset($inquiry) && !empty($inquiry->customer) && !empty($inquiry->customer->contact_no) ? $inquiry->customer->contact_no : '',array('class'=>"form-control",'id' => 'contact_no','disabled' => 'true')) }}
                                        </div>
                                    </div>

                                    <div class="form-group row {{ isset($inquiry) && !empty($inquiry->customer) ? '' :'d-none customer-details'}}">
                                        <label class="col-form-label col-lg-1">Address</label>
                                        <div class="col-lg-5">
                                            {{ Form::text('address',isset($inquiry) && !empty($inquiry->customer) && !empty($inquiry->customer->address) ? $inquiry->customer->address : '',array('class'=>"form-control",'id' => 'address','disabled' => 'true')) }}
                                        </div>
                                        <label class="col-form-label col-lg-1">City</label>
                                        <div class="col-lg-5">
                                            {{ Form::text('city',isset($inquiry) && !empty($inquiry->customer) && !empty($inquiry->customer->city) ? $inquiry->customer->city : '',array('class'=>"form-control",'id' => 'city','disabled' => 'true')) }}
                                        </div>
                                    </div>

                                    <div class="form-group row customer-details d-none">
                                        <label class="col-form-label col-lg-1">Pin Code</label>
                                        <div class="col-lg-5">
                                            {{ Form::text('pin_code',Request::old('pin_code'),array('class'=>"form-control",'id' => 'pin_code','disabled' => 'true')) }}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Job Description</label>
                                        <div class="col-lg-5">
                                            {{ Form::textarea('job_description',Request::old('job_description'),array('class'=>"form-control",'rows' => '2','disabled' => 'true')) }}
                                        </div>
                                        <label class="col-form-label col-lg-1">Process</label>
                                        <div class="col-lg-5">
                                            {{ Form::select('processes[]', [ 'Print' => 'Print','Lamination' => 'Lamination', 'Half-Cut' => 'Half-Cut', 'Full-Cut' => 'Full-Cut','Binding' => 'Binding','Other Process' => 'Other Process'], old('processes', $processes ?? ''), [
                                                'class' => 'form-control select2',
                                                'id' => 'processes',
                                                'multiple' => 'multiple',
                                                'disabled' => 'true'
                                            ]) }}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Type of Job</label>
                                        <div class="col-lg-5">
                                            <span class="col-5 ml-3">
                                                {{ Form::radio('type_of_job', 'Design', old('type_of_job') == 'Design', ['class' => 'form-check-input', 'id' => 'job_design','disabled' => 'true']) }}
                                                {{ Form::label('job_design', 'Design', ['class' => 'form-check-label']) }}
                                            </span>
                                            <span class="col-5 ml-3">
                                                {{ Form::radio('type_of_job', 'Print', old('type_of_job') == 'Print', ['class' => 'form-check-input', 'id' => 'job_print', 'disabled' => 'true']) }}
                                                {{ Form::label('job_print', 'Print', ['class' => 'form-check-label']) }}
                                            </span>
                                            <span class="col-5 ml-3">
                                                {{ Form::radio('type_of_job', 'Design Print', old('type_of_job') == 'Design Print', ['class' => 'form-check-input', 'id' => 'job_design_print','disabled' => 'true']) }}
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
                                            {{ Form::text('designing_details',Request::old('designing_details'),array('class'=>"form-control",'disabled' => 'true')) }}
                                        </div>
                                    </div>
                                    <div class="form-group row d-none designing-details-print-container mb-0">
                                        @include('admin.inquiry.billing_price_naster_section')
                                    </div>
                                </fieldset>
                                
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-link-collapse btn-block text-left d-flex align-items-center text-dark px-0" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Inquiry Billing 
                                                    <i class="fa fa-plus ml-auto" aria-hidden="true"></i>
                                                    <i class="fa fa-minus ml-auto" aria-hidden="true"></i>
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-6">
                                                        <div class="row">
                                                            <label class="col-xl-3 col-lg-4">Bill type</label>
                                                            <div class="col-xl-9 col-lg-8 form-group">
                                                                <span class="mr-3">
                                                                    {{ Form::radio('bill_type', 'Cash', old('bill_type') == 'Cash', ['class' => '', 'id' => 'bill_type_cash']) }}
                                                                    {{ Form::label('bill_type_cash', 'Cash', ['class' => 'form-check-label']) }}
                                                                </span>
                                                                <span>
                                                                    {{ Form::radio('bill_type', 'Invoice', old('bill_type') == 'Invoice', ['class' => '', 'id' => 'bill_type_invoice']) }}
                                                                    {{ Form::label('bill_type_invoice', 'Invoice', ['class' => 'form-check-label']) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6">
                                                        <div class="row">
                                                            <label class="col-xl-3 col-lg-4">Dispatch Type</label>
                                                            <div class="col-xl-9 col-lg-8 form-group">
                                                                <span class="mr-3">
                                                                    {{ Form::radio('dispatch_type', 'Local Shipping', old('dispatch_type') == 'Local Shipping', ['class' => '', 'id' => 'dispatch_type']) }}
                                                                    {{ Form::label('dispatch_type', 'Local Shipping',['class' => 'form-check-label']) }}
                                                                </span>
                                                                <span>
                                                                    {{ Form::radio('dispatch_type', 'Pick-up', old('dispatch_type') == 'Local Shipping', ['class' => '', 'id' => 'dispatch_type']) }}
                                                                    {{ Form::label('dispatch_type', 'Pick-up', ['class' => 'form-check-label']) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-6">
                                                        <div class="row">
                                                            <label class="col-xl-3 col-lg-4">Delivery Status</label>
                                                            <div class="col-xl-9 col-lg-8 form-group">
                                                                <span class="mr-3">
                                                                    {{ Form::radio('delivery_status', 'In-Transits', old('delivery_status') == 'In-Transits', ['class' => '', 'id' => 'delivery_status']) }}
                                                                    {{ Form::label('delivery_status', 'In-Transits', ['class' => 'form-check-label']) }}
                                                                </span>
                                                                <span>
                                                                    {{ Form::radio('delivery_status', 'Delivered', old('delivery_status') == 'Delivered', ['class' => '', 'id' => 'delivery_status']) }}
                                                                    {{ Form::label('delivery_status', 'Delivered', ['class' => 'form-check-label']) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row d-none bill-type">
                                                    <div class="col-xl-4 col-lg-6">
                                                        <div class="row">
                                                            <label class="col-xl-3 col-lg-4">Enter Bill no.</label>
                                                            <div class="col-xl-9 col-lg-8 form-group">
                                                            {{ Form::text('bill_no', isset($inquiry) ? $inquiry->bill_no :Request::old('bill_no'), array('class'=>"form-control", 'id' => 'bill_no')) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none designing-details-print-container">
                                    <div class="col-4 mt-3 offset-8 mb-3">
                                        <label class="form-label">Cost Calculation</label>
                                        {{ Form::text('cost_calculation', isset($inquiry) ? $inquiry->cost_calculation :Request::old('cost_calculation'), array('class'=>"form-control", 'id' => 'total_cost','disabled' => 'true')) }}
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
            if (selectedJobType == 'Design' || selectedJobType == 'Design Print') {
                $('.designing-details-container').removeClass('d-none');
                $('.designing-details-print-container').addClass('d-none');
            } else if(selectedJobType == 'Print'){
                $('.designing-details-container').addClass('d-none');
                $('.designing-details-print-container').removeClass('d-none');
            }
        }

        // Initial check on page load
        toggleDesigningDetails();



        // Check when radio buttons are clicked
        $('input[name="bill_type"]').on('change', function() {
            let selectedBillType = $('input[name="bill_type"]:checked').val();
            if (selectedBillType == 'Invoice') {
                $('.bill-type').removeClass('d-none');
            } else {
                $('.bill-type').addClass('d-none');
            }
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
    });
</script>
@endsection
