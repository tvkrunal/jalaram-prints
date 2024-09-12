@extends('layouts.admin.master')
@section('title', isset($priceMaster)?'Update'. ' '.'('.$priceMaster->item_type.')':'Create Price Master')
@section('content')
    <div class="content-wrapper">
        @include('layouts.admin.page_header',['breadcrumb'=>[route('price-master.index')=>'Price Master']])
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
                                <h6 class="card-title">@if(isset($priceMaster)) Update @else Create @endif Price Master</h6>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                        <a class="list-icons-item" data-action="remove"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @if(isset($priceMaster))
                                    {{ Form::model($priceMaster, ['route' => ['price-master.update', $priceMaster->id], 'method' => 'patch' , 'enctype'=>'multipart/form-data']) }}
                                @else
                                    {{ Form::open(['route' => 'price-master.store' , 'enctype'=>'multipart/form-data']) }}
                                @endif
                                <fieldset class="mb-3">
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Item Type<span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('item_type',Request::old('item_type'),array('class'=>"form-control")) }}
                                            @if ($errors->has('item_type'))
                                                <span class="text-danger">{{ $errors->first('item_type') }}</span>
                                            @endif
                                        </div>
                                        <label class="col-form-label col-lg-1">Media<span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('media',Request::old('media'),array('class'=>"form-control")) }}
                                            @if ($errors->has('media'))
                                                <span class="text-danger">{{ $errors->first('media') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">GSM <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::text('gsm',Request::old('gsm'),array('class'=>"form-control")) }}
                                            @if ($errors->has('gsm'))
                                                <span class="text-danger">{{ $errors->first('media') }}</span>
                                            @endif
                                        </div>
                                        <label class="col-form-label col-lg-1">Qty <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::number('qty',Request::old('qty'),array('class'=>"form-control")) }}
                                            @if ($errors->has('qty'))
                                                <span class="text-danger">{{ $errors->first('qty') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-1">Min Cost <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::number('min_cost',Request::old('min_cost'),array('class'=>"form-control")) }}
                                            @if ($errors->has('min_cost'))
                                                <span class="text-danger">{{ $errors->first('min_cost') }}</span>
                                            @endif
                                        </div>
                                        <label class="col-form-label col-lg-1">Max Cost <span class="text-danger">*</span></label>
                                        <div class="col-lg-5">
                                            {{ Form::number('max_cost',Request::old('max_cost'),array('class'=>"form-control")) }}
                                            @if ($errors->has('max_cost'))
                                                <span class="text-danger">{{ $errors->first('max_cost') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="text-right">
                                    {{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}
                                    <a href="{{ route('price-master.index') }}" class="btn btn-primary">Cancel</a>
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
