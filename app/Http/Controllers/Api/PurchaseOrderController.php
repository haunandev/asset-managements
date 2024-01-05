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
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowed_columns = [
            'id',
            'name',
            'order_date',
        ];

        $datas = PurchaseOrder::select([
            'id',
            'name',
            'created_at',
            'updated_at',
            'order_date',
            ]);


        /*
         * This checks to see if we should override the Admin Setting to show archived assets in list.
         * We don't currently use it within the Snipe-IT GUI, but will be useful for API integrations where they
         * may actually need to fetch assets that are archived.
         *
         * @see \App\Models\Category::showableAssets()
         */
        // if ($request->input('archived')=='true') {
        //     $datas = $datas->withCount('assets as assets_count');
        // } else {
        //     $datas = $datas->withCount('showableAssets as assets_count');
        // }

        if ($request->filled('search')) {
            $datas = $datas->TextSearch($request->input('search'));
        }

        if ($request->filled('name')) {
            $datas->where('name', '=', $request->input('name'));
        }

        // Make sure the offset and limit are actually integers and do not exceed system limits
        $offset = ($request->input('offset') > $datas->count()) ? $datas->count() : app('api_offset_value');
        $limit = app('api_limit_value');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'assets_count';
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
