@extends('layouts/default')

{{-- Page title --}}
@section('title')
Purchase Orders
@parent
@stop

@section('header_right')
  {{-- @can('create', \App\Models\Component::class) --}}
    <a href="{{ route('purchase-orders.create') }}" accesskey="n" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
  {{-- @endcan --}}
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <table
                data-columns="{{ \App\Presenters\PurchaseOrderPresenter::dataTableLayout() }}"
                data-cookie-id-table="purchaseOrdersTable"
                data-pagination="true"
                data-id-table="purchaseOrdersTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-fullscreen="true"
                data-show-export="true"
                data-show-footer="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                id="purchaseOrdersTable"
                class="table table-striped snipe-table"
                data-url="{{ route('api.purchase-orders.index') }}"
                data-export-options='{
                "fileName": "export-purchase-orders-{{ date('Y-m-d') }}",
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
