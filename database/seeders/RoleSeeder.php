<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'administrador',
            'description' => 'Administrador del sistema',
        ]);

        Role::create([
            'name' => 'empleado',
            'description' => 'Personal de la empresa',
        ]);
    }
}
