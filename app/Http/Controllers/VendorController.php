<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public $model;
    public $url_prefix;
    public function __construct() {
        $this->model = new Vendor;
        $this->url_prefix = 'vendors';
    }
    
    public function index()
    {
        return view("$this->url_prefix/index");
    }

    public function create()
    {
        return view("$this->url_prefix/edit")->with('item', $this->model);
    }
    
    public function store(Request $request)
    {
        // $this->authorize('create', PurchaseOrder::class);
        $data = $this->model;
        $data->name = $request->input('name');
        $data->address = $request->input('address');
        $data->country = $request->input('country');
        $data->state = $request->input('state');
        $data->city = $request->input('city');
        $data->zip = $request->input('zip');
        $data->npwp = $request->input('npwp');
        $data->phone1 = $request->input('phone1');
        $data->phone2 = $request->input('phone2');
        $data->fax1 = $request->input('fax1');
        $data->fax2 = $request->input('fax2');
        $data->website = $request->input('website');
        $data->description = $request->input('description');
        $data->created_by = Auth::user()->id;
        // $data->name = $request->input('name');
        // $data->order_date = $request->input('order_date');
        // $data = $request->handleImages($data);
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

    public function update(Request $request, $dataId = null)
    {
        // $this->authorize('update', Category::class);
        if (is_null($data = $this->model::find($dataId))) {
            // Redirect to the categories management page
            return redirect()->route("$this->url_prefix.index")->with('error', 'Data Doesnt Exist.');
        }

        // Update the data
        $data->name = $request->input('name');
        $data->address = $request->input('address');
        $data->country = $request->input('country');
        $data->state = $request->input('state');
        $data->city = $request->input('city');
        $data->zip = $request->input('zip');
        $data->npwp = $request->input('npwp');
        $data->phone1 = $request->input('phone1');
        $data->phone2 = $request->input('phone2');
        $data->fax1 = $request->input('fax1');
        $data->fax2 = $request->input('fax2');
        $data->website = $request->input('website');
        $data->description = $request->input('description');
        $data->updated_by = Auth::user()->id;

        // $data = $request->handleImages($data);

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

        // Storage::disk('public')->delete('categories'.'/'.$data->image);

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
}
