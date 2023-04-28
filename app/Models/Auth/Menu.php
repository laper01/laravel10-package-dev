<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'depth',
        'position',
        'name',
        'parent_menu_id',
        'modul_id',
        'url'
    ];
}
