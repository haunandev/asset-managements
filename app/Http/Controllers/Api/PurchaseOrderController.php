<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Transformers\CategoriesTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\PurchaseOrderTransformer;

class PurchaseOrderController extends Controller
{
    public $table_columns;
    public function __construct() {
        $this->table_columns = [
            'id',
            'po_no',
            'vendor_id',
            'purpose_id',
            'memo',
            'payment_terms',
            'etd',
            'eta',
            'general_discount',
            'taxable_nett_value',
            'vat',
            'grand_value',
            'created_by',
            'updated_by',
            'manager_approval_by',
            'manager_approval_time',
            'finance_approval_by',
            'finance_approval_time',
            'created_at',
            'updated_at'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowed_columns = $this->table_columns;

        $datas = PurchaseOrder::select([...$this->table_columns]);

        if ($request->filled('search')) {
            $datas = $datas->TextSearch($request->input('search'));
        }

        if ($request->filled('po_no')) {
            $datas->where('po_no', '=', $request->input('po_no'));
        }

        // Make sure the offset and limit are actually integers and do not exceed system limits
        $offset = ($request->input('offset') > $datas->count()) ? $datas->count() : app('api_offset_value');
        $limit = app('api_limit_value');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'po_no';
        $datas->orderBy($sort, $order);

        $total = $datas->count();
        $datas = $datas->skip($offset)->take($limit)->get();

        return (new PurchaseOrderTransformer)->transformDatas($datas, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \App\Http\Requests\ImageUploadRequest $request
     * @return \Illuminate\Http\Response
     */
    // public function store(ImageUploadRequest $request)
    public function store(Request $request)
    {
        // $this->authorize('create', PurchaseOrder::class);
        $data = new PurchaseOrder;
        $data->fill($request->all());
        // $data = $request->handleImages($data);

        if ($data->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $data, 'Success'));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $data->getErrors()));

    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $this->authorize('view', PurchaseOrder::class);
        $data = PurchaseOrder::findOrFail($id);
        return (new PurchaseOrderTransformer)->transformData($data);

    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \App\Http\Requests\ImageUploadRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $this->authorize('update', Category::class);
        $data = PurchaseOrder::findOrFail($id);

        $data->fill($request->all());
        $data = $request->handleImages($data);

        if ($data->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $data, 'Success'));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $data->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $this->authorize('delete', Category::class);
        $data = PurchaseOrder::findOrFail($id);

        // if (! $data->isDeletable()) {
        //     return response()->json(
        //         Helper::formatStandardApiResponse('error', null, trans('admin/categories/message.assoc_items', ['asset_type'=>$data->category_type]))
        //     );
        // }
        $data->delete();

        return response()->json(Helper::formatStandardApiResponse('success', null, 'Delete Succeed.'));
    }


    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     */
    public function selectlist(Request $request)
    {
        // $this->authorize('view.selectlists');
        $datas = PurchaseOrder::select([
            'id',
            'name',
            'order_date'
        ]);

        // if ($request->filled('search')) {
        //     $datas = $datas->where('name', 'LIKE', '%'.$request->get('search').'%');
        // }

        return (new SelectlistTransformer)->transformSelectlist($datas);
    }
}
