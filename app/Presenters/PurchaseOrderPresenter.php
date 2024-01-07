<?php

namespace App\Presenters;

/**
 * Class PurchaseOrder
 */
class PurchaseOrderPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            // [
            //     'field' => 'id',
            //     'searchable' => false,
            //     'sortable' => false,
            //     'switchable' => false,
            //     'title' => trans('general.id'),
            //     'visible' => false,
            // ],
            [
                'field' => 'po_no',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => 'PO No.',
                'visible' => true,
            ],
            [
                'field' => 'created_at',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => 'Request Date',
                'visible' => true,
            ], [
                'field' => 'user_created_by',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                // 'title' => trans('general.manufacturer'),
                'title' => 'Request By',
                'visible' => true,
                'formatter' => 'usersLinkObjFormatter',
            ],
            [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'formatter' => 'purchase-ordersActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Link to this purchase-orders name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('purchase-orders.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('purchase-orders.show', $this->id);
    }
}
