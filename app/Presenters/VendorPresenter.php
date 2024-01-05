<?php

namespace App\Presenters;

/**
 * Class PurchaseOrder
 */
class VendorPresenter extends Presenter
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
                'title' => 'Company Name',
                'visible' => true,
                // 'formatter' => 'vendorsLinkFormatter',
            ],
            [
                'field' => 'address',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => trans('general.address'),
                'visible' => true,
            ], 
            [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'formatter' => 'vendorsActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Link to this vendors name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('vendors.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('vendors.show', $this->id);
    }
}
