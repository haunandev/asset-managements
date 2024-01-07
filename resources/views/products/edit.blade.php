@extends('layouts/edit-form', [
    'createText' => 'Create Product' ,
    'updateText' => 'Update Product',
    'helpPosition'  => 'right',
    'helpText' => 'Help',
    'formAction' => (isset($item->id)) ? route('products.update', ['product' => $item->id]) : route('products.store'),

])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name', ['translated_name' => 'Product Name'])
@include ('partials.forms.edit.textarea', ['translated_name' => 'Product Description', 'fieldname' => 'description'])
@include ('partials.forms.edit.manufacturer-select', ['translated_name' => 'Brand Name', 'fieldname' => 'manufacturer_id'])
@include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'category_id'])
@include ('partials.forms.edit.category-select', ['translated_name' => 'Sub Category', 'fieldname' => 'sub_category_id'])
@include ('partials.forms.edit.image-upload', ['image_path' => app('products_upload_path')])
@include ('partials.forms.edit.purchase_cost', ['fieldname' => 'price', 'translated_name' => 'Price'])

@include ('partials.forms.edit.textarea', ['translated_name' => 'General Memo', 'fieldname' => 'memo'])
@include ('partials.forms.edit.textarea', ['translated_name' => 'Product Specification', 'fieldname' => 'specification'])

{{-- @include ('partials.forms.edit.quantity')
@include ('partials.forms.edit.minimum_quantity')
@include ('partials.forms.edit.serial', ['fieldname' => 'serial'])
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])
@include ('partials.forms.edit.order_number')
@include ('partials.forms.edit.purchase_date')
@include ('partials.forms.edit.notes') --}}


@stop
