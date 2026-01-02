<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'nim' => 'K3456789',
            'study_program' => 'Pendidikan Teknologi Informasi',
            'card_identity_photo' => 'path/to/card_identity_photo.jpg'
        ]);

        $this->call(RoleSeeder::class);
        // $this->call(LoansSeeder::class);
    }
}
