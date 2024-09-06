<div class="price-master-repeater col-12">
    <div class="row align-items-center">
        <div class="col-6">
            <h4 class="mb-4">{{ __('Print Item Details') }}</h4>
        </div>
        <div class="col-6 text-right">
            <button type="button" class="btn btn-sm btn-dark" data-repeater-create>
                <i class="bi bi-plus-lg me-1"></i>
                <span>{{ __('Add more print item') }}</span>
            </button>
        </div>
    </div>
    <div class="faq-wrpper" data-repeater-list="faqSection">
        <div class="faq-item mb-3" data-repeater-item>
            <div class="mb-2 faq-items">
                <div class="row align-items-center">
                    <div class="col-6">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-6 text-right">
                        <button type="button" data-repeater-delete type="button" value="Delete"
                            class="btn btn-sm btn-square h-6 w-6 border-gray-300 bg-danger-hover text-danger text-light-hover">
                            <i class="icon-trash-alt text-xs"></i>
                        </button>
                    </div>
                </div>
                {{ Form::select('price_master_id', $priceMasters, [], array('class'=>"form-control select2", 'id' => "price_master_id",'placeholder' => 'Select Item Type'))}}
                @if ($errors->has('faq_title'))
                    <span class="text-danger">{{ $errors->first('faq_title') }}</span>
                @endif
            </div>
            <div>
                <label class="form-label">Description</label>
                {{ Form::textarea('description', null, ['class' => 'form-control', 'cols' => '30', 'rows' => '5']) }}
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
