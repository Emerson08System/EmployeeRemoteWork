<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Meetings extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $meeting_date = $faker->dateTimeBetween('+5 days', '+10 days')->format('Y-m-d H:i:s');
        $date_start = $faker->dateTimeBetween('+5 days', '+10 days')->format('Y-m-d H:i:s');
        $date_end = $faker->dateTimeBetween('+5 days', '+10 days')->format('Y-m-d H:i:s');

        $data = [

            [
                'title' => 'Inventory Management System Project Meeting',
                'organizer_id' => NULL,
                'meeting_date' => $meeting_date,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'location' => $faker->address,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'attendies' => NULL,
                'status' => 'Pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Customer Relationship Management (CRM) System Meeting',
                'organizer_id' => NULL,
                'meeting_date' => $meeting_date,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'location' => $faker->address,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'attendies' => NULL,
                'status' => 'Pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'E-commerce Website Development Meeting',
                'organizer_id' => NULL,
                'meeting_date' => $meeting_date,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'location' => $faker->address,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'attendies' => NULL,
                'status' => 'Pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Mobile App Development - Task Manager Meeting',
                'organizer_id' => NULL,
                'meeting_date' => $meeting_date,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'location' => $faker->address,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'attendies' => NULL,
                'status' => 'Pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Network Infrastructure Upgrade Meeting',
                'organizer_id' => NULL,
                'meeting_date' => $meeting_date,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'location' => $faker->address,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'attendies' => NULL,
                'status' => 'Pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('remote_meetings')->insert($data);
    }
}
