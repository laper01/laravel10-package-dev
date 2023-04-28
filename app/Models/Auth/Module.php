<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Model\Auth\Role;

class Module extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'id',
        'name',
        'allow_permission',
        'author',
        'edited',
        'folder'
    ];

    public function role()
    {
        return $this->hasMany(Role::class);
    }

    public function scopeWithRowNumber($query, $column = 'id', $order = 'asc')
    {
        $sub = static::selectRaw("*, row_number() OVER (order by $column $order) as row_number")
            ->toSql();
        $query->from(DB::raw("({$sub}) as sub"));
    }
}
