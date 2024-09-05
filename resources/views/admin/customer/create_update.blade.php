@extends('layouts.admin.master')
@section('title', isset($user)?'Update'. ' '.'('.$user->first_name.')'.'('.$user->last_name.')':'Create Customer')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.page_header',['breadcrumb'=>[route('customer.index')=>'Customer']])
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
                                <h6 class="card-title">@if(isset($user)) Update @else Create @endif Customer</h6>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                        <a class="list-icons-item" data-action="remove"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @if(isset($user))
                                    {{ Form::model($user, ['route' => ['customer.update', $user->id], 'method' => 'patch' , 'enctype'=>'multipart/form-data']) }}
                                @else
                                    {{ Form::open(['route' => 'customer.store' , 'enctype'=>'multipart/form-data']) }}
                                    @csrf
                                @endif
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">First Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('customer_first_name',Request::old('customer_first_name'),array('class'=>"form-control")) }}
                                            @if ($errors->has('customer_first_name'))
                                                <span class="text-danger">{{ $errors->first('customer_first_name') }}</span>
                                            @endif
                                        </div>
                                        <label class="col-form-label col-lg-1">Last Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('customer_last_name',Request::old('customer_last_name'),array('class'=>"form-control")) }}
                                            @if ($errors->has('customer_last_name'))
                                                <span class="text-danger">{{ $errors->first('customer_last_name') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Email <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('email',Request::old('email'),array('class'=>"form-control")) }}
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <label class="col-form-label col-lg-1">Contact No <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::number('customer_contact_no',Request::old('customer_contact_no'),array('class'=>"form-control")) }}
                                            @if ($errors->has('customer_contact_no'))
                                                <span class="text-danger">{{ $errors->first('customer_contact_no') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Address <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('address',Request::old('address'),array('class'=>"form-control")) }}
                                            @if ($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                        <label class="col-form-label col-lg-1">City <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('city',Request::old('city'),array('class'=>"form-control")) }}
                                            @if ($errors->has('city'))
                                                <span class="text-danger">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Pin Code <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('pin_code',Request::old('pin_code'),array('class'=>"form-control")) }}
                                            @if ($errors->has('pin_code'))
                                                <span class="text-danger">{{ $errors->first('pin_code') }}</span>
                                            @endif
                                        </div>
                                        <label class="col-form-label col-lg-1">Date Of Delivery <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::date('delivery_date',Request::old('delivery_date'),array('class'=>"form-control")) }}
                                            @if ($errors->has('delivery_date'))
                                                <span class="text-danger">{{ $errors->first('delivery_date') }}</span>
                                            @endif
                                        </div>
                                   </div>
                                    
                                </fieldset>

                                <div class="text-right">
                                    {{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
                                    <a href="{{ route('customer.index') }}" class="btn btn-primary">Cancel</a>
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
