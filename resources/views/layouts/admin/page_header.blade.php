<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                <span class="font-weight-semibold">@yield('title')</span>
                @if(isset($header) && isset($header['modelInfo']))
                    <span class="badge bg-info">{{ $header['modelInfo'] }}</span>
                @endif
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        @if(Route::current()->getName() == 'home' || Route::current()->getName() == 'dashboard')
        <div class="header-elements d-none">
            <div class="d-flex justify-content-center dash-filter-header">
                <div class="input-group date-range-selector--wrapper {{(auth()->user()->merchant_id?"d-none":"")}}">
                    <span class="input-group-prepend">
                        <span class="input-group-text text-warning"><i class="icon-circle2"></i></span>
                    </span>
                    {!!Form::select('merchant_id', App\Models\Merchant::getMerchantsDropdown(), Input::old('merchant_id'), ['placeholder'=>'All', 'id'=>'dash-chart-merchant_id','class' => 'text-capitalize form-control input-lg select-search'])!!}
                </div>

                <div class="input-group date-range-selector--wrapper">
                    <span class="input-group-prepend">
                        <span class="input-group-text text-success"><i class="icon-circle2"></i></span>
                    </span>
                    <select name="select_dates" id="dash-chart-date-range" class="date-range-selector text-capitalize form-control input-lg ">
                        <option selected value="today">today</option>
                        <option value="thisweek">this week</option>
                        <option value="lastweek">last week</option>
                        <option value="thismonth">this month</option>
                        <option value="lastmonth">last month</option>
                    </select>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
                @foreach($breadcrumb as $bk=>$bv)
                <a href="{{$bk}}" class="breadcrumb-item">{{$bv}}</a>
                @endforeach
                <span class="breadcrumb-item active">@yield('title')</span>
            </div>

            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<!-- /page header -->