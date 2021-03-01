<?php

namespace App\Modules\Department\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductPlan extends Model
{
    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
