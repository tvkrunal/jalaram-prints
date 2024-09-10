<div class="price-master-repeater col-12">
    <div class="row align-items-center">
        <div class="col-6">
            <h2 class="mb-4">{{ __('Print Item Details') }}</h2>
        </div>
    </div>
    <div class="faq-wrpper" data-repeater-list="inquiryPriceItemSection">
    @if (isset($inquiry) && count($inquiry->inquiryPriceItems) > 0)
        @foreach ($inquiry->inquiryPriceItems as $inquiryPriceItem)
            <div class="inquiry-price-item mb-3 border-black p-3 rounded border-1" data-repeater-item>
                <div class="mb-2 inquiry-price-items">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <label class="form-label">Item Type</label>
                            {{ Form::select('price_master_id', $priceMasters, isset($inquiryPriceItem->priceMaster) ? $inquiryPriceItem->priceMaster->id : null, array('class'=>"form-control select2", 'id' => "",'placeholder' => 'Select Item Type','disabled' => 'true'))}}
                        </div>
                        <div class="col-4">
                            <label class="form-label">Qty</label>
                            {{ Form::number('qty', isset($inquiryPriceItem) ? $inquiryPriceItem->qty : Request::old('qty'), array('class'=>"form-control",'disabled' => 'true')) }}
                        </div>

                        <div class="col-4">
                            <div class="d-flex align-items-center">
                                <div style="flex:auto;">
                                    <label class="form-label">Cost (Per Qty)</label>
                                    {{ Form::text('cost', isset($inquiryPriceItem) ? $inquiryPriceItem->cost : Request::old('cost'), array('class'=>"form-control",'disabled' => 'true')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">GSM</label>
                            {{ Form::text('gsm', isset($inquiryPriceItem) ? $inquiryPriceItem->gsm : Request::old('gsm'), array('class'=>"form-control",'disabled' => 'true')) }}
                        </div>
                        <div class="col-4">
                            <label class="form-label">Media</label>
                            {{ Form::text('media', isset($inquiryPriceItem) ? $inquiryPriceItem->media : Request::old('media'), array('class'=>"form-control",'disabled' => 'true')) }}
                        </div>
                        <div class="col-4">
                            <label class="form-label">Total Job Hours</label>
                            {{ Form::text('total_hours', isset($inquiryPriceItem) ? $inquiryPriceItem->total_hours : Request::old('total_hours'), array('class'=>"form-control",'disabled' => 'true')) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    </div>
</div>
