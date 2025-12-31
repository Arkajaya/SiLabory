<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $asisten = Role::create(['name' => 'asisten']);
        $user = Role::create(['name' => 'user']);


        $user1 = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $user1->assignRole($admin);

        $user2 = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password')
        ]);
        $user2->assignRole($user);

        $user3 = User::create([
            'name' => 'Assisten User',
            'email' => 'asisten@example.com',
            'password' => bcrypt('password')
        ]);
        $user3->assignRole($asisten);
    }
}
