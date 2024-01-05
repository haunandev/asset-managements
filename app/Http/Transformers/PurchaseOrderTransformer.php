<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class PurchaseOrderTransformer
{
    public function transformDatas(Collection $datas, $total)
    {
        $array = [];
        foreach ($datas as $data) {
            $array[] = self::transformData($data);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformData(PurchaseOrder $data = null)
    {

        // We only ever use item_count for categories in this transformer, so it makes sense to keep it
        // simple and do this switch here.
        switch ($data->category_type) {
            // case 'asset':
            //     $data->item_count = $data->assets_count;
            //     break;
            default:
                $data->item_count = 0;
        }

        if ($data) {
            $array = [
                'id' => (int) $data->id,
                'name' => (string) $data->name,
                'order_date' => $data->order_date,
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
