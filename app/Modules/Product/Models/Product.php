<?php

namespace App\Modules\Product\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    // Danh sách các phòng ban
    public static function getProductOptions()
    {
        return Cache::remember('products', 24 * 60, function () {
            return DB::table('products')->get()->map(function ($item) {
                return [
                    'title' => $item->name,
                    'value' => $item->id
                ];
            })->toArray();
        });
    }
}
