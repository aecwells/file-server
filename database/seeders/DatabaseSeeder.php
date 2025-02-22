<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SmbHost;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {  
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
        ]);

        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        SmbHost::factory()->count(1)->create();
    }
}
