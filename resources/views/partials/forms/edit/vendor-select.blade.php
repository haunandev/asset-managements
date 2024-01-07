<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-6">
        <select class="js-data-ajax" data-endpoint="vendors" data-placeholder="Select Vendor" name="{{ $fieldname }}" style="width: 100%" id="vendor_select"{{ (isset($multiple) && ($multiple=='true')) ? " multiple='multiple'" : '' }}>
            @if ($vendor_id = Request::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $vendor_id }}" selected="selected">
                    {{ (\App\Models\Vendor::find($vendor_id)) ? \App\Models\Vendor::find($vendor_id)->name : '' }}
                </option>
            @else
                <option value="">Select Vendor</option>
            @endif
        </select>
    </div>
    {{-- <div class="col-md-1 col-sm-1 text-left">
        @can('create', \App\Models\Vendor::class)
            @if ((!isset($hide_new)) || ($hide_new!='true'))
                <a href='{{ route('modal.show',['type' => 'category', 'category_type' => isset($category_type) ? $category_type : 'assets' ]) }}' data-toggle="modal"  data-target="#createModal" data-select="{{ $fieldname ?? 'category_select_id' }}" class="btn btn-sm btn-primary">{{ trans('button.new') }}</a>
            @endif
        @endcan
    </div> --}}
    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fas fa-times"></i> :message</span></div>') !!}
</div>