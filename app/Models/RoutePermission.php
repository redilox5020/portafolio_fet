<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_name',
        'permission_name'
    ];
}
