<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ProductTransformer
{
    public function transformDatas(Collection $datas, $total)
    {
        $array = [];
        foreach ($datas as $data) {
            $array[] = self::transformData($data);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformData(Product $data = null)
    {

        // We only ever use item_count for categories in this transformer, so it makes sense to keep it
        // simple and do this switch here.
        // switch ($data->category_type) {
            // case 'asset':
            //     $data->item_count = $data->assets_count;
            //     break;
            // default:
                // $data->item_count = 0;
        // }

        if ($data) {
            $array = [
                'id' => (int) $data->id,
                'product_code' => (string) sprintf("%07d", $data->id),
                'name' => (string) $data->name,
                'parent_id' => (int) $data->parent_id,
                'description' => (string) $data->description,
                'specification' => (string) $data->specification,
                'manufacturer_id' => (int) $data->category_id,
                'manufacturer' => ($data->manufacturer) ? ['id' => $data->manufacturer->id, 'name'=> e($data->manufacturer->name)] : null,
                'category_id' => (int) $data->category_id,
                'category' => ($data->category) ? ['id' => $data->category->id, 'name'=> e($data->category->name)] : null,
                'price' => Helper::formatCurrencyOutput($data->price),
                'sub_category_id' => (int) $data->sub_category_id,
                'sub_category' => ($data->sub_category) ? ['id' => $data->sub_category->id, 'name'=> e($data->sub_category->name)] : null,
                'image' => ($data->image) ? Storage::disk('public')->url('products/'.e($data->image)) : null,
                'currency' => (string) $data->currency,
                'price' => (int) $data->price,
                'packaging' => (string) $data->packaging,
                'weight' => (int) $data->weight,
                'memo' => (string) $data->memo,
                'created_by' => (int) $data->created_by,
                'updated_by' => (int) $data->updated_by,
                'created_at' => Helper::getFormattedDateObject($data->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($data->updated_at, 'datetime'),
            ];

            $permissions_array['available_actions'] = [
                // 'update' => Gate::allows('update', PurchaseOrder::class),
                'update' => true,
                // 'delete' => $data->isDeletable(),
                'delete' => true,
            ];

            $array += $permissions_array;

            return $array;
        }
    }
}
