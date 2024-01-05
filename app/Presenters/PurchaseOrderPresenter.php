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
            [
                'field' => 'id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => true,
            ],
            [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.name'),
                'visible' => true,
            ],
            [
                'field' => 'order_date',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.date'),
                'visible' => true,
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
