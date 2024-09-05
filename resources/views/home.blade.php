@extends('layouts.admin.master')
@section('title', 'Home')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="row mt-4">
                <div class="col-12 col-lg-4 col-md-6 ml-auto">
                    {{Form::select('dashboard_stats_period', ['Month'=> 'Monthly', 'Week'=> 'Weekly', 'Today'=> 'Today'],NULL, ['class'=>'form-control', 'id'=>'dashboard_stats_period', 'autocomplete'=>'off'])}}
                </div>
            </div>
            <div class="row mt-4">
                
            </div>
        </div>
    </div>
@endsection

