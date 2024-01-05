<?php

namespace App\Http\Controllers\PurchaseOrders;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrdersController extends Controller
{
    public function index()
    {
        return view('purchase-orders/index');
    }

    public function create()
    {
        return view('purchase-orders/edit')->with('item', new PurchaseOrder);
    }
    
    public function store(Request $request)
    {
        // $this->authorize('create', PurchaseOrder::class);
        $data = new PurchaseOrder();
        $data->name = $request->input('name');
        $data->order_date = $request->input('order_date');
        // $data = $request->handleImages($data);
        if ($data->save()) {
            return redirect()->route('purchase-orders.index')->with('success', 'Success');
        }

        return redirect()->back()->withInput()->withErrors($data->getErrors());
    }

    public function edit($dataId = null)
    {
        // $this->authorize('update', Category::class);
        if (is_null($item = PurchaseOrder::find($dataId))) {
            return redirect()->route('purchase-orders.index')->with('error', 'Data Doesnt Exist.');
        }
        return view('purchase-orders/edit', compact('item'));
    }

    public function update(Request $request, $dataId = null)
    {
        // $this->authorize('update', Category::class);
        if (is_null($data = PurchaseOrder::find($dataId))) {
            // Redirect to the categories management page
            return redirect()->route('purchase-orders.index')->with('error', 'Data Doesnt Exist.');
        }

        // Update the data
        $data->name = $request->input('name');
        $data->order_date = $request->input('order_date');

        // $data = $request->handleImages($data);

        if ($data->save()) {
            // Redirect to the new category page
            return redirect()->route('purchase-orders.index')->with('success', 'Update Success');
        }
        // The given data did not pass validation
        return redirect()->back()->withInput()->withErrors($data->getErrors());
    }
    
    public function destroy($dataId)
    {
        // $this->authorize('delete', Category::class);
        // Check if the data exists
        if (is_null($data = PurchaseOrder::findOrFail($dataId))) {
            return redirect()->route('purchase-orders.index')->with('error', 'Data doesnt exist');
        }

        // if (! $data->isDeletable()) {
        //     return redirect()->route('categories.index')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=> $data->category_type]));
        // }

        // Storage::disk('public')->delete('categories'.'/'.$data->image);

        $data->delete();
        // Redirect to the locations management page
        return redirect()->route('purchase-orders.index')->with('success', 'Delete Success');
    }
}
