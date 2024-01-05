<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class VendorTransformer
{
    public function transformDatas(Collection $datas, $total)
    {
        $array = [];
        foreach ($datas as $data) {
            $array[] = self::transformData($data);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformData(Vendor $data = null)
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
                'name' => (string) $data->name,
                'address' => (string) $data->address,
                'country' => (string) $data->country,
                'state' => (string) $data->state,
                'city' => (string) $data->city,
                'zip' => (int) $data->zip,
                'npwp' => (string) $data->npwp,
                'phone1' => (string) $data->phone1,
                'phone2' => (string) $data->phone2,
                'fax1' => (string) $data->fax1,
                'fax2' => (string) $data->fax2,
                'website' => (string) $data->website,
                'description' => (string) $data->description,
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
