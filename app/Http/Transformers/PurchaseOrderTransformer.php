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
                'po_no' => (string) $data->po_no,
                'vendor_id' => (int) $data->vendor_id,
                'purpose_id' => (int) $data->purpose_id,
                'memo' => (string) $data->memo,
                'payment_terms' => (string) $data->payment_terms,
                'etd' => (string) $data->etd,
                'eta' => (string) $data->eta,
                'general_discount' => (int) $data->general_discount,
                'taxable_nett_value' => (int) $data->taxable_nett_value,
                'vat' => (int) $data->vat,
                'grand_value' => (int) $data->grand_value,
                'created_by' => (int) $data->created_by,
                'user_created_by' => ($data->user_created_by) ? ['id' => $data->user_created_by->id, 'name'=> e($data->user_created_by->username)] : null,
                'manager_approval_by' => (string) $data->manager_approval_by,
                'manager_approval_time' => (string) $data->manager_approval_time,
                'finance_approval_by' => (string) $data->finance_approval_by,
                'finance_approval_time' => (string) $data->finance_approval_time,
                'created_at' => Helper::getFormattedDateObject($data->created_at, 'datetime', false),
                'updated_at' => Helper::getFormattedDateObject($data->updated_at, 'datetime', false),
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
