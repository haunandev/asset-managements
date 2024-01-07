<?php

namespace App\Presenters;

/**
 * Class PurchaseOrder
 */
class ProductPresenter extends Presenter
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
                'sortable' => false,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ],
            [
                'field' => 'image',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => 'Product Image',
                'visible' => true,
                'formatter' => 'imageFormatter',
            ],
            [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => 'Product Name',
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],[
                'field' => 'manufacturer',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                // 'title' => trans('general.manufacturer'),
                'title' => 'Brand',
                'visible' => true,
                'formatter' => 'manufacturersLinkObjFormatter',
            ],[
                'field' => 'price',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.purchase_cost'),
                'footerFormatter' => 'sumFormatter',
                'class' => 'text-right',
            ],
            [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'formatter' => 'productsActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Link to this products name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('products.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('products.show', $this->id);
    }
}
