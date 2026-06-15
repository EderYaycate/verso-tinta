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
        $admin   = Role::create(['name' => 'admin']);
        $usuario = Role::create(['name' => 'usuario']);

        $userAdmin = User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@libreria.com',
            'password' => Hash::make('admin123'),
        ]);
        $userAdmin->assignRole($admin);

        $userCliente = User::create([
            'name'     => 'Cliente',
            'email'    => 'cliente@libreria.com',
            'password' => Hash::make('cliente123'),
        ]);
        $userCliente->assignRole($usuario);
    }
}