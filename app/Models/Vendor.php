<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;
use Watson\Validating\ValidatingTrait;

class Vendor extends SnipeModel
{
    use HasFactory;
    
    protected $presenter = \App\Presenters\VendorPresenter::class;
    use Presentable;
    use SoftDeletes;

    protected $table = 'vendors';
    protected $hidden = ['deleted_at'];
    
    public $rules = [
        'name' => 'required',
    ];
    
    protected $fillable = [
        'name',
        'address',
        'country',
        'state',
        'city',
        'zip',
        'npwp',
        'phone1',
        'phone2',
        'fax1',
        'fax2',
        'website',
        'description',
        'created_by',
        'updated_by',
    ];
    use ValidatingTrait;
    
    use Searchable;
    protected $searchableAttributes = [];
    protected $searchableRelations = [];
}
