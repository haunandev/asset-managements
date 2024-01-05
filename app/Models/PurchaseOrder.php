<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;
use Watson\Validating\ValidatingTrait;

class PurchaseOrder extends SnipeModel
{
    use HasFactory;
    
    protected $presenter = \App\Presenters\PurchaseOrderPresenter::class;
    use Presentable;
    use SoftDeletes;

    protected $table = 'purchase_orders';
    protected $hidden = ['deleted_at'];
    
    /**
     * Purchase Order validation rules
     */
    public $rules = [
        'name' => 'required',
        'order_date' => 'required'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'order_date',
    ];
    use ValidatingTrait;

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = [];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [];
}
