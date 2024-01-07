<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Searchable;
use Watson\Validating\ValidatingTrait;

class Product extends Model
{
    use HasFactory;
    
    protected $presenter = \App\Presenters\ProductPresenter::class;
    use Presentable;
    use SoftDeletes;

    protected $table = 'products';
    protected $hidden = ['deleted_at'];
    
    public $rules = [
        'name' => 'required',
    ];

    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'specification',
        'memo',
        'manufacturer_id',
        'category_id',
        'sub_category_id',
        'image',
        'currency',
        'price',
        'packaging',
        'weight',
    ];
    use ValidatingTrait;
    
    use Searchable;
    protected $searchableAttributes = ['name'];
    protected $searchableRelations = [
        'manufacturer' => ['name'],
    ];

    public function manufacturer()
    {
        return $this->belongsTo(\App\Models\Manufacturer::class, 'manufacturer_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'sub_category_id');
    }
}
