<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $admin = Role::create(['name' => 'admin']);
        $usuario = Role::create(['name' => 'usuario']);

        // Crear usuario administrador
        $user = User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@libreria.com',
            'password' => Hash::make('admin123'),
        ]);

        // Asignar rol admin
        $user->assignRole($admin);
    }
}