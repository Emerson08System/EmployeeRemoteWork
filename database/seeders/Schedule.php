<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Schedule extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $data = [
            [
                'id' => 1,
                'schedule_date' => Carbon::now()->toDateString(),
                'in_time' => Carbon::createFromTime(8, 0)->toTimeString(), // Convert to HH:MM:SS format
                'out_time' => Carbon::createFromTime(17, 0)->toTimeString(), // Convert to HH:MM:SS format
                'shift_type' => 'Morning Shift',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'schedule_date' => Carbon::now()->toDateString(),
                'in_time' => Carbon::createFromTime(20, 0, 0)->toTimeString(), // Convert to HH:MM:SS format
                'out_time' => Carbon::tomorrow()->setTime(5, 0, 0)->toTimeString(), // Convert to HH:MM:SS format
                'shift_type' => 'Night Shift',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('remote_schedules')->insert($data);
    }


}
