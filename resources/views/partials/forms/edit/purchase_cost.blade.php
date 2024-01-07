<!-- Purchase Cost -->
<div class="form-group {{ $errors->has(($fieldname ?? 'purchase_cost')) ? ' has-error' : '' }}">
    <label for="{{ $fieldname ?? 'purchase_cost' }}" class="col-md-3 control-label">{{ $translated_name ?? trans('general.purchase_cost') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">
            <input class="form-control" type="text" name="{{ $fieldname ?? 'purchase_cost' }}" aria-label="{{ $fieldname ?? 'purchase_cost' }}" id="{{ $fieldname ?? 'purchase_cost' }}" value="{{ old(($fieldname ?? 'purchase_cost'), Helper::formatCurrencyOutput($item->{$fieldname ?? 'purchase_cost'})) }}" />
            <span class="input-group-addon">
                @if (isset($currency_type))
                    {{ $currency_type }}
                @else
                    {{ $snipeSettings->default_currency }}
                @endif
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first(($fieldname ?? 'purchase_cost'), '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>

</div>
