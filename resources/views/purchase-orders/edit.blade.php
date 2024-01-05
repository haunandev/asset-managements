@extends('layouts/edit-form', [
    'createText' => 'Create Purchase Order' ,
    'updateText' => 'Update Purchase Order',
    'helpPosition'  => 'right',
    'helpText' => 'Help',
    'formAction' => (isset($item->id)) ? route('purchase-orders.update', ['purchase_order' => $item->id]) : route('purchase-orders.store'),

])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => 'Name'])
@include ('partials.forms.edit.datepicker', ['translated_name' => 'Order Date', 'fieldname' => 'order_date'])
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
