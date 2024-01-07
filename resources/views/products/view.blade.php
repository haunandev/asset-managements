@extends('layouts/default')

{{-- Page title --}}
@section('title')
View Product
 - {{ $item->name }}
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-9">

    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
      
      <ul class="nav nav-tabs hidden-print">

        <li class="active">
          <a href="#details" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fas fa-info-circle fa-2x" aria-hidden="true"></i>
            </span>
            <span class="hidden-xs hidden-sm">{{ trans('admin/users/general.info') }}</span>
          </a>
        </li>

        {{-- <li>
          <a href="#history" data-toggle="tab">
            <span class="hidden-lg hidden-md">
            <i class="fas fa-history fa-2x" aria-hidden="true"></i></span>
            <span class="hidden-xs hidden-sm">{{ trans('general.history') }}</span>
          </a>
        </li> --}}
        
        {{-- @can('update', \App\Models\Product::class)
          <li class="pull-right"><a href="#" data-toggle="modal" data-target="#uploadFileModal">
              <i class="fas fa-paperclip" aria-hidden="true"></i> {{ trans('button.upload') }}</a>
          </li>
        @endcan --}}
      </ul>

      <div class="tab-content">

        <div class="tab-pane active" id="details">
          <div class="row">
            <div class="col-md-12">
              <div class="container row-new-striped">

                {{-- product_code --}}
                <div class="row">
                  <div class="col-md-3">
                    <strong>Product ID</strong>
                  </div>
                  <div class="col-md-9">
                    {{ sprintf("%07d", $item->id) }}
                  </div>
                </div>

                {{-- name --}}
                <div class="row">
                  <div class="col-md-3">
                    <strong>Product Name</strong>
                  </div>
                  <div class="col-md-9">
                    {{ $item->name }}
                  </div>
                </div>

                {{-- description --}}
                @if ($item->description)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>Description</strong>
                    </div>
                    <div class="col-md-9">
                      {{ $item->description }}
                    </div>
                  </div>
                @endif

                @if ($item->manufacturer)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>{{ trans('admin/hardware/form.manufacturer') }}</strong>
                    </div>
                    <div class="col-md-9">
                      @can('view', \App\Models\Manufacturer::class)
                        <a href="{{ route('manufacturers.show', $item->manufacturer->id) }}">
                          {{ $item->manufacturer->name }}
                        </a>
                      @else
                        {{ $item->manufacturer->name }}
                      @endcan

                      @if ($item->manufacturer->url)
                        <br><i class="fas fa-globe-americas" aria-hidden="true"></i> <a href="{{ $item->manufacturer->url }}" rel="noopener">{{ $item->manufacturer->url }}</a>
                      @endif

                      @if ($item->manufacturer->support_url)
                        <br><i class="far fa-life-ring" aria-hidden="true"></i>
                        <a href="{{ $item->manufacturer->support_url }}"  rel="noopener">{{ $item->manufacturer->support_url }}</a>
                      @endif

                      @if ($item->manufacturer->support_phone)
                        <br><i class="fas fa-phone" aria-hidden="true"></i>
                        <a href="tel:{{ $item->manufacturer->support_phone }}">{{ $item->manufacturer->support_phone }}</a>
                      @endif

                      @if ($item->manufacturer->support_email)
                        <br><i class="far fa-envelope" aria-hidden="true"></i> <a href="mailto:{{ $item->manufacturer->support_email }}">{{ $item->manufacturer->support_email }}</a>
                      @endif
                    </div>
                  </div>
                @endif

                @if ($item->category)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>{{ trans('general.category') }}</strong>
                    </div>
                    <div class="col-md-9">
                      <a href="{{ route('categories.show', $item->category->id) }}">{{ $item->category->name }}</a>
                    </div>
                  </div>
                @endif

                @if ($item->sub_category)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>Sub Category</strong>
                    </div>
                    <div class="col-md-9">
                      <a href="{{ route('categories.show', $item->sub_category->id) }}">{{ $item->sub_category->name }}</a>
                    </div>
                  </div>
                @endif

                <div class="row">
                  <div class="col-md-3">
                    <strong>
                      Price
                    </strong>
                  </div>
                  <div class="col-md-9">
                    {{ $snipeSettings->default_currency }}
                    {{ Helper::formatCurrencyOutput($item->price) }}
                  </div>
                </div>

                {{-- memo --}}
                @if ($item->memo)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>Memo</strong>
                    </div>
                    <div class="col-md-9">
                      {{ $item->memo }}
                    </div>
                  </div>
                @endif

                {{-- specification --}}
                @if ($item->specification)
                  <div class="row">
                    <div class="col-md-3">
                      <strong>Specification</strong>
                    </div>
                    <div class="col-md-9">
                      {{ $item->specification }}
                    </div>
                  </div>
                @endif

              </div> <!-- end row-striped -->
            </div>

          </div>
        </div> <!-- end tab-pane -->

      </div> <!-- /.tab-content -->

    </div> <!-- nav-tabs-custom -->
  </div>  <!-- /.col -->
  <div class="col-md-3">

    @if ($item->image!='')
        <div class="row">
            <div class="col-md-12 text-center" style="padding-bottom: 15px;">
                <a href="{{ Storage::disk('public')->url('products/'.e($item->image)) }}" data-toggle="lightbox"><img src="{{ Storage::disk('public')->url('products/'.e($item->image)) }}" class="img-responsive img-thumbnail" alt="{{ $item->name }}"></a>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-3" style="padding-bottom: 15px;">
            <strong>Name</strong>
        </div>
        <div class="col-md-9">
          {{ $item->name }}
        </div>
    </div>

    @can('update', $item)
      <a href="{{ route('products.edit', $item->id) }}" class="btn btn-block btn-primary" style="margin-bottom: 10px;">Edit Product</a>
      {{-- <a href="{{ route('clone/product', $item->id) }}" class="btn btn-block btn-primary" style="margin-bottom: 10px;">Clone Product</a> --}}
    @endcan

    @can('delete', $item)
      <button class="btn btn-block btn-danger delete-asset" data-toggle="modal" data-title="{{ trans('general.delete') }}" data-content="{{ trans('general.delete_confirm', ['item' => $item->name]) }}" data-target="#dataConfirmModal">
        {{ trans('general.delete') }}
      </button>
    @endcan
  </div>

</div> <!-- /.row -->



{{-- @can('update', \App\Models\Product::class)
  @include ('modals.upload-file', ['item_type' => 'license', 'item_id' => $item->id])
@endcan --}}

@stop


@section('moar_scripts')
  <script>

    $('#dataConfirmModal').on('show.bs.modal', function (event) {
      var content = $(event.relatedTarget).data('content');
      var title = $(event.relatedTarget).data('title');
      $(this).find(".modal-body").text(content);
      $(this).find(".modal-header").text(title);
    });

  </script>
  @include ('partials.bootstrap-table')
@stop
