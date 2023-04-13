<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        User::create([
            // 'name' => 'Admin',
            'razon_social' => 'Admin',
            'ruc' => '1076990641',
            'telefono' => '993340954',
            'direccion' => 'san diego 260',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id
        ]);

        User::create([
            // 'name' => 'User',
            'razon_social' => 'User',
            'ruc' => '1076990641',
            'telefono' => '993340954',
            'direccion' => 'san diego 260',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role_id' => $userRole->id
        ]);
    }
}
