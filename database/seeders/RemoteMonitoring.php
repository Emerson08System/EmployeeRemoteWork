<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RemoteMonitoring extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $data = [
            [
                'emp_id' => 1,
                'schedule_id' => 1,
                'task_id' => 1,
                'meeting_id' =>  1,
                'status' =>  'On Progress',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'emp_id' => 2,
                'schedule_id' => 2,
                'task_id' => 2,
                'meeting_id' =>  2,
                'status' =>  'On Progress',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'emp_id' => 3,
                'schedule_id' => 1,
                'task_id' => 3,
                'meeting_id' =>  3,
                'status' =>  'On Progress',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'emp_id' => 4,
                'schedule_id' => 2,
                'task_id' => 4,
                'meeting_id' =>  4,
                'status' =>  'On Progress',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'emp_id' => 5,
                'schedule_id' => 1,
                'task_id' => 5,
                'meeting_id' =>  5,
                'status' =>  'On Progress',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];

        DB::table('remote_monitorings')->insert($data);
    }
}

