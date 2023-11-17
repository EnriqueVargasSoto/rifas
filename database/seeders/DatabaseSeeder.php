<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Raffle;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create([
            'id' => 1,
            'role' => 'Super Admin'
        ]);

        Role::create([
            'id' => 2,
            'role' => 'Responsable'
        ]);
        Role::create([
            'id' => 3,
            'role' => 'Administrador'
        ]);

        User::create([
            'role_id' => 1,
            'name' => 'Eber',
            'dni' => '87654321',
            'short_name' => 'Eber',
            'phone' => '987654321',
            'unit' => 'Unidad Administradora',
            'area' => 'Area Administradora',
            'position' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(123456),
            'clave' => '123456',
        ]);

        for ($i=1; $i <= 40000; $i++) {
            # code...
            $codigo = str_pad($i, 5, '0', STR_PAD_LEFT);

            Raffle::create([
                'number' => $i,
                'code' => $codigo
            ]);
        }
    }
}
