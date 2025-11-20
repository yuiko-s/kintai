<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class AttendancesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('attendances')->insert([
            'user_id'    => 1, 
            'day'        => '2025-11-03',
            'start_time' => Carbon::parse('2025-11-03 09:00:00'),
            'end_time'   => Carbon::parse('2025-11-03 18:00:00'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
