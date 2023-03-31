<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    public function role(){
        return $this->hasMany(Role::class);
    }

    public function scopeWithRowNumber($query, $column = 'id', $order = 'asc'){
        $sub = static::selectRaw("*, row_number() OVER (order by $column $order) as row_number")
            ->toSql();
        $query->from(DB::raw("({$sub}) as sub"));
    }
}
