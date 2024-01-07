@extends('layouts/edit-form', [
    'createText' => 'Create Purchase Order' ,
    'updateText' => 'Update Purchase Order',
    'helpPosition'  => 'right',
    'helpText' => 'Help',
    'formAction' => (isset($item->id)) ? route('purchase-orders.update', ['purchase_order' => $item->id]) : route('purchase-orders.store'),

])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.vendor-select', ['translated_name' => 'Vendor', 'fieldname' => 'vendor_id'])
@include ('partials.forms.edit.base-input', ['translated_name' => 'Payment Terms', 'fieldname' => 'payment_terms'])
@include ('partials.forms.edit.datepicker', ['translated_name' => 'ETD', 'fieldname' => 'etd'])
@include ('partials.forms.edit.datepicker', ['translated_name' => 'ETA', 'fieldname' => 'eta'])
@include ('partials.forms.edit.textarea', ['translated_name' => 'Memo', 'fieldname' => 'memo'])

@stop
