<?php

namespace App\Modules\Department\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public static function getDepartmentOptions() {
        return Cache::remember('users', 24 * 60, function()
        {
            return DB::table('departments')->get()->map(function ($item) {
                return [
                    'title' => $item->name,
                    'value' => $item->id
                ];
            });
        });
    }
}
