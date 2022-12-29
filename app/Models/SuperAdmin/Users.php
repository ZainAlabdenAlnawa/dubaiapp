<?php

namespace App\Models\SuperAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table="users";
    protected $fillable =
    ['name','email','password','user_id','role'];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

