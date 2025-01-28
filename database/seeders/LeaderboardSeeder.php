<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LeaderboardSeeder extends Seeder
{
    public function run()
    {
        // Generate dummy data
        $users = [
            ['id' => 1, 'name' => 'vivek'],
            ['id' => 2, 'name' => 'nitin'],
            ['id' => 3, 'name' => 'ajay'],
            ['id' => 4, 'name' => 'hardik'],
        ];


        foreach ($users as $user) {
            for ($i = 0; $i < 20; $i++) {
                DB::table('leaderboard')->insert([
                    'full_name' => $user['name'],
                    'user_id' => $user['id'],
                    'activity_date' => now()->subDays(rand(0, 30))->subMinutes(rand(0, 1440)),
                    'points' => rand(10, 99), 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
    }
}

