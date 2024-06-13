<?php

namespace Database\Seeders;

use App\Models\Choice;
use App\Models\NIMModel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        NIMModel::create([
            'token' => 'NE4cSc',
            'nim' => '105221026',
            'status_vote' => false,
            'status_active' => true,
        ]);

        Choice::create([
            'choice_cabinet' => 'kabinet1',
        ]);
        Choice::create([
            'choice_cabinet' => 'kabinet2',
        ]);
    }
}
