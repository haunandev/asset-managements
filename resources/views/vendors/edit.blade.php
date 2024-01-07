@extends('layouts/edit-form', [
    'createText' => 'Create Vendor' ,
    'updateText' => 'Update Vendor',
    'helpPosition'  => 'right',
    'helpText' => 'Help',
    'formAction' => (isset($item->id)) ? route('vendors.update', ['vendor' => $item->id]) : route('vendors.store'),

])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => 'Company Name'])
@include ('partials.forms.edit.address', ['translated_name' => 'Address'])
@include ('partials.forms.edit.base-input', ['translated_name' => 'Phone', 'fieldname' => 'phone1'])
@include ('partials.forms.edit.base-input', ['translated_name' => 'Phone 2', 'fieldname' => 'phone2'])
@include ('partials.forms.edit.base-input', ['translated_name' => 'Fax', 'fieldname' => 'fax1'])
@include ('partials.forms.edit.base-input', ['translated_name' => 'Fax 2', 'fieldname' => 'fax2'])
@include ('partials.forms.edit.base-input', ['translated_name' => 'Website', 'fieldname' => 'website'])
@include ('partials.forms.edit.base-input', ['translated_name' => 'Main Contact', 'fieldname' => 'main_contact'])
@include ('partials.forms.edit.base-input', ['translated_name' => 'Main Email', 'fieldname' => 'main_email', 'type' => 'email'])
@include ('partials.forms.edit.textarea', ['translated_name' => 'General Comment', 'fieldname' => 'description'])
{{-- @include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'category_id','category_type' => 'component'])
@include ('partials.forms.edit.quantity')
@include ('partials.forms.edit.minimum_quantity')
@include ('partials.forms.edit.serial', ['fieldname' => 'serial'])
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])
@include ('partials.forms.edit.order_number')
@include ('partials.forms.edit.purchase_date')
@include ('partials.forms.edit.purchase_cost')
@include ('partials.forms.edit.notes')
@include ('partials.forms.edit.image-upload', ['image_path' => app('components_upload_path')]) --}}


@stop
