<!-- Notes -->
<div class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">
    <label for="{{ $fieldname }}" class="col-md-3 control-label">{{ $translated_name }}</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" name="{{ $fieldname }}" id="{{ $fieldname }}" aria-label="{{ $fieldname }}" style="min-width:100%;">{{ old($fieldname, ($item->{$fieldname})) }}</textarea>
        {!! $errors->first($fieldname, '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
