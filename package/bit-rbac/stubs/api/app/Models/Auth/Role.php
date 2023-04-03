<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\Group;
use App\Models\Auth\Module;

class Role extends Model
{
    use HasFactory;

    protected $guarded=['id'];
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function module(){
        return $this->belongsTo(Module::class);
    }
    public function scopeWithRowNumber($query, $column = 'id', $order = 'asc'){
        $sub = static::selectRaw("*, row_number() OVER (order by $column $order) as row_number")
            ->toSql();
        $query->from(DB::raw("({$sub}) as sub"));
    }
}
