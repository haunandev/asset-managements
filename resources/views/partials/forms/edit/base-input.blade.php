<!-- Name -->
<div class="form-group {{ $errors->has($fieldname) ? ' has-error' : '' }}">
    <label for="{{ $fieldname }}" class="col-md-3 control-label">{{ $translated_name }}</label>
    <div class="col-md-7 col-sm-12{{  (Helper::checkIfRequired($item, $fieldname)) ? ' required' : '' }}">
        <input class="form-control" type="{{ $type ?? 'text' }}" name="{{ $fieldname }}" id="{{ $fieldname }}" aria-label="{{ $fieldname }}" value="{{ old($fieldname, ($item->{$fieldname})) }}"{!!  (Helper::checkIfRequired($item, $fieldname)) ? ' data-validation="required" required' : '' !!} />
        {!! $errors->first($fieldname, '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
