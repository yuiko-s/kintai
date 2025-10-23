<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',

    ];
}
