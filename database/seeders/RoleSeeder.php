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
            'nim' => 'K3456289',
            'study_program' => 'Pendidikan Teknologi Informasi',
            'card_identity_photo' => 'path/to/card_identiasdty_photo.jpg',
            'password' => bcrypt('password')
        ]);
        $user1->assignRole($admin);

        $user2 = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'nim' => 'K3456739',
            'study_program' => 'Pendidikan Teknologi Informasi',
            'card_identity_photo' => 'path/to/card_identitasy_photo.jpg',
            'password' => bcrypt('password')
        ]);
        $user2->assignRole($user);

        $user3 = User::create([
            'name' => 'Assisten User',
            'email' => 'asisten@example.com',
            'nim' => 'K3456189',
            'study_program' => 'Pendidikan Teknologi Informasi',
            'card_identity_photo' => 'path/to/card_idenstity_photo.jpg',
            'password' => bcrypt('password')
        ]);
        $user3->assignRole($asisten);
    }
}
