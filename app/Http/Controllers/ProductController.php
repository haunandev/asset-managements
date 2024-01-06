<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Actionlog;

class ProductController extends Controller
{
    public $model;
    public $url_prefix;
    public function __construct() {
        $this->model = new Product;
        $this->url_prefix = 'products';
    }
    
    public function index()
    {
        return view("$this->url_prefix/index");
    }

    public function create()
    {
        return view("$this->url_prefix/edit")->with('item', $this->model);
    }
    
    public function store(ImageUploadRequest $request)
    {
        // $this->authorize('create', PurchaseOrder::class);
        $data = $this->model;
        
        $data->name = $request->input('name');
        $data->parent_id = $request->input('parent_id');
        $data->description = $request->input('description');
        $data->memo = $request->input('memo');
        $data->specification = $request->input('specification');
        $data->manufacturer_id = $request->input('manufacturer_id');
        $data->category_id = $request->input('category_id');
        $data->sub_category_id = $request->input('sub_category_id');
        $data->image = $request->input('image');
        $data->currency = $request->input('currency');
        $data->price = $request->input('price');
        $data->packaging = $request->input('packaging');
        $data->weight = $request->input('weight');
        $data->created_by = Auth::user()->id;
        $data = $request->handleImages($data);
        if ($data->save()) {
            return redirect()->route("$this->url_prefix.index")->with('success', 'Success');
        }

        return redirect()->back()->withInput()->withErrors($data->getErrors());
    }

    public function edit($dataId = null)
    {
        // $this->authorize('update', Category::class);
        if (is_null($item = $this->model::find($dataId))) {
            return redirect()->route('vendors.index')->with('error', 'Data Doesnt Exist.');
        }
        return view("$this->url_prefix/edit", compact('item'));
    }

    public function update(ImageUploadRequest $request, $dataId = null)
    {
        // $this->authorize('update', Category::class);
        if (is_null($data = $this->model::find($dataId))) {
            // Redirect to the categories management page
            return redirect()->route("$this->url_prefix.index")->with('error', 'Data Doesnt Exist.');
        }

        // Update the data
        $data->name = $request->input('name');
        $data->parent_id = $request->input('parent_id');
        $data->description = $request->input('description');
        $data->memo = $request->input('memo');
        $data->specification = $request->input('specification');
        $data->manufacturer_id = $request->input('manufacturer_id');
        $data->category_id = $request->input('category_id');
        $data->sub_category_id = $request->input('sub_category_id');
        $data->image = $request->input('image');
        $data->currency = $request->input('currency');
        $data->price = $request->input('price');
        $data->packaging = $request->input('packaging');
        $data->weight = $request->input('weight');
        $data->updated_by = Auth::user()->id;

        $data = $request->handleImages($data);

        if ($data->save()) {
            // Redirect to the new category page
            return redirect()->route("$this->url_prefix.index")->with('success', 'Update Success');
        }
        // The given data did not pass validation
        return redirect()->back()->withInput()->withErrors($data->getErrors());
    }
    
    public function destroy($dataId)
    {
        // $this->authorize('delete', Category::class);
        // Check if the data exists
        if (is_null($data = $this->model::findOrFail($dataId))) {
            return redirect()->route("$this->url_prefix.index")->with('error', 'Data doesnt exist');
        }

        // if (! $data->isDeletable()) {
        //     return redirect()->route('categories.index')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=> $data->category_type]));
        // }

        Storage::disk('public')->delete($this->url_prefix.'/'.$data->image);

        $data->delete();
        // Redirect to the locations management page
        return redirect()->route("$this->url_prefix.index")->with('success', 'Delete Success');
    }

    public function show($id)
    {
        // $this->authorize('view', Company::class);

        if (is_null($data = $this->model::find($id))) {
            return redirect()->route("$this->url_prefix.index")
                ->with('error', 'Data not found.');
        }

        return view("$this->url_prefix/view")->with('item', $data);
    }
    public function restore($id)
    {
        // $this->authorize('delete', Manufacturer::class);

        if ($data = $this->model::withTrashed()->find($id)) {

            if ($data->deleted_at == '') {
                return redirect()->back()->with('error', trans('general.not_deleted', ['item_type' => trans('general.manufacturer')]));
            }

            if ($data->restore()) {
                $logaction = new Actionlog();
                $logaction->item_type = $this->model;
                $logaction->item_id = $data->id;
                $logaction->created_at = date('Y-m-d H:i:s');
                $logaction->user_id = Auth::user()->id;
                $logaction->logaction('restore');

                // Redirect them to the deleted page if there are more, otherwise the section index
                $deleted_manufacturers = $this->model::onlyTrashed()->count();
                if ($deleted_manufacturers > 0) {
                    return redirect()->back()->with('success', trans('admin/manufacturers/message.success.restored'));
                }
                return redirect()->route("$this->url_prefix.index")->with('success', trans('admin/manufacturers/message.restore.success'));
            }

            // Check validation to make sure we're not restoring an asset with the same asset tag (or unique attribute) as an existing asset
            return redirect()->back()->with('error', trans('general.could_not_restore', ['item_type' => trans('general.manufacturer'), 'error' => $data->getErrors()->first()]));
        }

        return redirect()->route("$this->url_prefix.index")->with('error', trans('admin/manufacturers/message.does_not_exist'));

    }
}
