<div class="price-master-repeater col-12">
    <div class="row align-items-center">
        <div class="col-6">
            <h2 class="mb-4">{{ __('Print Item Details') }}</h2>
        </div>
        <div class="col-6 text-right">
            <button type="button" class="btn btn-sm btn-dark" data-repeater-create>
                <i class="bi bi-plus-lg me-1"></i>
                <span>{{ __('Add more print items') }}</span>
            </button>
        </div>
    </div>
    <div class="faq-wrpper" data-repeater-list="inquiryPriceItemSection">
    @if (isset($inquiry) && count($inquiry->inquiryPriceItems) > 0)
        @foreach ($inquiry->inquiryPriceItems as $inquiryPriceItem)
            <div class="inquiry-price-item mb-3 border-black p-3 rounded border-1" data-repeater-item>
                <div class="mb-2 inquiry-price-items">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <label class="form-label">Item Type  <span class="text-danger">*</span></label>
                            {{ Form::select('price_master_id', $priceMasters, isset($inquiryPriceItem->priceMaster) ? $inquiryPriceItem->priceMaster->id : null, array('class'=>"form-control select2", 'id' => "",'placeholder' => 'Select Item Type'))}}
                            @if ($errors->has('price_master_id'))
                                <span class="text-danger">{{ $errors->first('price_master_id') }}</span>
                            @endif
                        </div>
                        <div class="col-4">
                            <label class="form-label">Qty <span class="text-danger">*</span></label>
                            {{ Form::number('qty', isset($inquiryPriceItem) ? $inquiryPriceItem->qty : Request::old('qty'), array('class'=>"form-control")) }}
                            @if ($errors->has('qty'))
                                <span class="text-danger">{{ $errors->first('qty') }}</span>
                            @endif
                        </div>

                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <div style="flex:auto;">
                                    <label class="form-label">Cost (Per Qty) <span class="text-danger">*</span></label>
                                    {{ Form::text('cost', isset($inquiryPriceItem) ? $inquiryPriceItem->cost : Request::old('cost'), array('class'=>"form-control")) }}
                                    @if ($errors->has('cost'))
                                        <span class="text-danger">{{ $errors->first('cost') }}</span>
                                    @endif
                                </div>
                            
                                <button type="button" data-repeater-delete class="btn btn-sm btn-square h-6 w-6 border-gray-300 bg-danger-hover text-danger text-light-hover">
                                    <i class="icon-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">GSM <span class="text-danger">*</span></label>
                            {{ Form::text('gsm', isset($inquiryPriceItem) ? $inquiryPriceItem->gsm : Request::old('gsm'), array('class'=>"form-control")) }}
                            @if ($errors->has('gsm'))
                                <span class="text-danger">{{ $errors->first('gsm') }}</span>
                            @endif
                        </div>
                        <div class="col-4">
                            <label class="form-label">Media  <span class="text-danger">*</span></label>
                            {{ Form::text('media', isset($inquiryPriceItem) ? $inquiryPriceItem->media : Request::old('media'), array('class'=>"form-control")) }}
                            @if ($errors->has('media'))
                                <span class="text-danger">{{ $errors->first('media') }}</span>
                            @endif
                        </div>
                        <div class="col-4">
                            <label class="form-label">Total Job Hours <span class="text-danger">*</span></label>
                            {{ Form::text('total_hours', isset($inquiryPriceItem) ? $inquiryPriceItem->total_hours : Request::old('total_hours'), array('class'=>"form-control")) }}
                            @if ($errors->has('total_hours'))
                                <span class="text-danger">{{ $errors->first('total_hours') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @else
        <div class="inquiry-price-item mb-3 border-black p-3 rounded border-1" data-repeater-item>
            <div class="mb-2 inquiry-price-items">
                <div class="row align-items-center">
                    <div class="col-4">
                        <label class="form-label">Item Type <span class="text-danger">*</span></label>
                        {{ Form::select('price_master_id', $priceMasters, [], array('class'=>"form-control select2", 'id' => "price_master_id",'placeholder' => 'Select Item Type'))}}
                        @if ($errors->has('price_master_id'))
                            <span class="text-danger">{{ $errors->first('price_master_id') }}</span>
                        @endif
                    </div>
                    <div class="col-4">
                        <label class="form-label">Qty <span class="text-danger">*</span></label>
                        {{ Form::number('qty', Request::old('qty'), array('class'=>"form-control")) }}
                        @if ($errors->has('qty'))
                            <span class="text-danger">{{ $errors->first('qty') }}</span>
                        @endif
                    </div>

                    <div class="col-4">
                        <div class="d-flex align-items-center">
                            <div style="flex:auto;">
                                <label class="form-label">Cost (Per Qty) <span class="text-danger">*</span></label>
                                {{ Form::text('cost', Request::old('cost'), array('class'=>"form-control")) }}
                                @if ($errors->has('cost'))
                                    <span class="text-danger">{{ $errors->first('cost') }}</span>
                                @endif
                            </div>
                        
                            <button type="button" data-repeater-delete class="btn btn-sm btn-square h-6 w-6 border-gray-300 bg-danger-hover text-danger text-light-hover">
                                <i class="icon-trash-alt text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label">GSM <span class="text-danger">*</span></label>
                        {{ Form::text('gsm', Request::old('gsm'), array('class'=>"form-control")) }}
                        @if ($errors->has('gsm'))
                            <span class="text-danger">{{ $errors->first('gsm') }}</span>
                        @endif
                    </div>
                    <div class="col-4">
                        <label class="form-label">Media  <span class="text-danger">*</span></label>
                        {{ Form::text('media', Request::old('media'), array('class'=>"form-control")) }}
                        @if ($errors->has('media'))
                            <span class="text-danger">{{ $errors->first('media') }}</span>
                        @endif
                    </div>
                    <div class="col-4">
                        <label class="form-label">Total Job Hours <span class="text-danger">*</span></label>
                        {{ Form::text('total_hours', Request::old('total_hours'), array('class'=>"form-control")) }}
                        @if ($errors->has('total_hours'))
                            <span class="text-danger">{{ $errors->first('total_hours') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
</div>
