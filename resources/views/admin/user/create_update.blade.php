@extends('layouts.admin.master')
@section('title', isset($user)?'Update'. ' '.'('.$user->first_name.')'.'('.$user->last_name.')':'Create User')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.page_header',['breadcrumb'=>[route('users.index')=>'Users']])
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
                                <h6 class="card-title">@if(isset($user)) Update @else Create @endif User</h6>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                        <a class="list-icons-item" data-action="remove"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @if(isset($user))
                                    {{ Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch' , 'enctype'=>'multipart/form-data']) }}
                                @else
                                    {{ Form::open(['route' => 'users.store' , 'enctype'=>'multipart/form-data']) }}
                                @endif
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">First Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('first_name',Request::old('first_name'),array('class'=>"form-control")) }}
                                            @if ($errors->has('first_name'))
                                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                            @endif
                                        </div>
                                        <label class="col-form-label col-lg-1">Last Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('last_name',Request::old('last_name'),array('class'=>"form-control")) }}
                                            @if ($errors->has('last_name'))
                                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
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
                                        <label class="col-form-label col-lg-1">Date Of Birth</label>
                                        <div class="col-lg-5">
                                            {{ Form::text('date_of_birth',Request::old('date_of_birth'),array('class'=>"form-control datepicker", 'id'=>'date_of_birth'))}}
                                            @if ($errors->has('date_of_birth'))
                                                <span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if(!isset($user))
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-1">Password <span class="text-danger">*</span></label>
                                            <div class="col-lg-5">
                                                {{ Form::password('password', array('class = "form-control"')) }}
                                                @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                            <label class="col-form-label col-lg-1">Confirm Password <span class="text-danger">*</span></label>
                                            <div class="col-lg-5">
                                                {{ Form::password('confirm_password', array('class = "form-control"')) }}
                                                @if ($errors->has('confirm_password'))
                                                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Categories</label>
                                        <div class="col-lg-5">
                                            {{ Form::select('categories[]', [], isset($categoriesIds) ? $categoriesIds : null, array('class'=>"form-control select2", 'multiple'=>true))}}
                                            @if ($errors->has('categories'))
                                                <span class="text-danger">{{ $errors->first('categories') }}</span>
                                            @endif
                                        </div>
                                            <label class="col-form-label col-lg-1">Tags</label>
                                        <div class="col-lg-5">
                                            {{ Form::select('tag_ids[]', [], isset($tagIds) ? $tagIds : null, array('class'=>"form-control select2", 'multiple'=>true)) }}
                                            @if ($errors->has('tags'))
                                                <span class="text-danger">{{ $errors->first('tags') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Membership Type</label>
                                        <div class="col-lg-5">
                                        {{ Form::select('membership_tier', [],Request::old('membership_tier'),array('class'=>'form-control select2','id'=>'membership_tier')) }}
                                        </div>
                                        <label class="col-form-label col-lg-1">Gender <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::select('gender', [],Request::old('gender'),array('class'=>'form-control select2','id'=>'gender','placeholder' => 'Select Gender')) }}
                                            @if ($errors->has('gender'))
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Date Of Subscription</label>
                                        <div class="col-lg-5">
                                            {{ Form::text('date_subscribed',Request::old('date_subscribed'),array('class'=>"form-control datepicker", 'id'=>'date_subscribed','min'=>Carbon\Carbon::now()->format('Y-m-d')))}}
                                            @if ($errors->has('date_subscibed'))
                                                <span class="text-danger">{{ $errors->first('date_subscibed') }}</span>
                                            @endif
                                        </div>

                                        <label class="col-form-label col-lg-1">Is app user</label>
                                        <div class="col-lg-5">
                                            @if(!isset($user))
                                            {{ Form::checkbox('is_app_user','1',true, ['class'=>'form-check-input']) }}
                                            @else
                                                @if($user->is_app_user == 1)
                                                    {{ Form::checkbox('is_app_user','1',true, ['class'=>'form-check-input']) }}
                                                @else
                                                    {{ Form::checkbox('is_app_user','1',false, ['class'=>'form-check-input']) }}
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="text-right">
                                    {{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
                                    <a href="{{ route('users.index') }}" class="btn btn-primary">Cancel</a>
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
