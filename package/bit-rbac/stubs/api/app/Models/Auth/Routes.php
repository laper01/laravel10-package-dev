<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
    protected $table = 'routes';
    protected $fillable = [
        'url',
        'module_id',
        'allow_permission'
    ];
    use HasFactory;
}
