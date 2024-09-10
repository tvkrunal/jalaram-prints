@extends('layouts.admin.master')
@section('title', 'Inquiry Details')
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
                                <h4 class="card-title">Inquiry Details</h4>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                        <a class="list-icons-item" data-action="remove"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @if(isset($inquiry))
                                    {{ Form::model($inquiry, ['route' => ['inquiry.store'], 'method' => 'POST']) }}
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
                                        <label class="col-form-label col-lg-1">Designing Details</label>
                                        <div class="col-lg-5">
                                            {{ Form::text('designing_details',Request::old('designing_details'),array('class'=>"form-control",'rows' => '2','disabled' => 'true')) }}
                                        </div>
                                        <label class="col-form-label col-lg-1">Pin Code</label>
                                        <div class="col-lg-5">
                                        {{ Form::text('pin_code',isset($inquiry) && !empty($inquiry->customer) && !empty($inquiry->customer->pin_code) ? $inquiry->customer->pin_code : '',array('class'=>"form-control",'id' => 'pin_code','disabled' => 'true')) }}
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

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Bill Type</label>
                                        <div class="col-lg-5">
                                        {{ Form::text('bill_type',isset($inquiry) && !empty($inquiry->billing) && !empty($inquiry->billing->bill_type) ? $inquiry->billing->bill_type : '',array('class'=>"form-control",'id' => 'bill_type','disabled' => 'true')) }}
                                        </div>
                                        <label class="col-form-label col-lg-1">Pin Code</label>
                                        <div class="col-lg-5">
                                        {{ Form::text('bill_no',isset($inquiry) && !empty($inquiry->billing) && !empty($inquiry->billing->bill_no) ? $inquiry->billing->bill_no : '',array('class'=>"form-control",'id' => 'bill_no','disabled' => 'true')) }}
                                        </div>
                                    </div> 



                                    <div class="form-group row d-none designing-details-print-container mb-0">
                                        @include('admin.inquiry.billing_price_naster_section')
                                    </div>
                                </fieldset>

                                <div class="text-right">
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
