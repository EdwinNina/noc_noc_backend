<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ADMIN_USER = 'administrador';
    const EMPLOYEE_USER = 'empleado';

    protected $fillable = ['name', 'description'];
}
