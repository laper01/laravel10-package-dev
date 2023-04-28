<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'position',
        'name',
        'parent_menu_id',
        'module_id',
        'url',
    ];
}
