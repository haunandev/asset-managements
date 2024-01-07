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
        'vendor_id' => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'po_no',
        'vendor_id',
        'purpose_id',
        'memo',
        'payment_terms',
        'etd',
        'eta',
        'general_discount',
        'taxable_nett_value',
        'vat',
        'grand_value',
        'created_by',
        'updated_by',
        'manager_approval_by',
        'manager_approval_time',
        'finance_approval_by',
        'finance_approval_time'
    ];
    use ValidatingTrait;

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = [
        'po_no'
    ];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [
        'user_created_by' => ['name']
    ];

    public function user_created_by()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
