<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Model\Auth\Role;

class Group extends Model
{
    use HasFactory;

    public function role(){
        return $this->hasMany(Role::class);
    }
    public function user(){
        return $this->hasMany(User::class);
    }
}
