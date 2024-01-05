@extends('layouts/default')

{{-- Page title --}}
@section('title')
Vendors
@parent
@stop

@section('header_right')
  @can('create', \App\Models\Vendors::class)
    <a href="{{ route('vendors.create') }}" accesskey="n" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
  @endcan
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <table
                data-columns="{{ \App\Presenters\VendorPresenter::dataTableLayout() }}"
                data-cookie-id-table="vendorsTable"
                data-pagination="true"
                data-id-table="vendorsTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-fullscreen="true"
                data-show-export="true"
                data-show-footer="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                id="vendorsTable"
                class="table table-striped snipe-table"
                data-url="{{ route('api.vendors.index') }}"
                data-export-options='{
                "fileName": "export-vendors-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions"]
                }'>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'components-export', 'search' => true, 'showFooter' => true, 'columns' => \App\Presenters\PurchaseOrderPresenter::dataTableLayout()])



@stop
