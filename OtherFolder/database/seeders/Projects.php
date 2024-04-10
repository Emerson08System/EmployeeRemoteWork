<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Projects extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $data = [
            [
                'id' => 1,
                'project_name' => 'Inventory Management System',
                'description' => 'Develop an inventory management system to track and manage stock levels, orders, and suppliers.',
                'date_start' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'date_end' => $faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
                'progress' => '50',
                'status' => 'Open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'project_name' => 'Customer Relationship Management (CRM) System',
                'description' => 'Develop a CRM system to manage customer interactions, track leads, and streamline sales processes.',
                'date_start' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'date_end' => $faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
                'progress' => '70',
                'status' => 'Open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'project_name' => 'E-commerce Website Development',
                'description' => 'Develop an e-commerce website to sell products online, including shopping cart functionality and secure payment gateways.',
                'date_start' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'date_end' => $faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
                'progress' => '40',
                'status' => 'Open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'project_name' => 'Mobile App Development - Task Manager',
                'description' => 'Develop a mobile app to manage tasks, deadlines, and team collaboration, with user-friendly interface and push notifications.',
                'date_start' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'date_end' => $faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
                'progress' => '60',
                'status' => 'Open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'project_name' => 'Network Infrastructure Upgrade',
                'description' => 'Upgrade the existing network infrastructure to improve performance, security, and scalability.',
                'date_start' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'date_end' => $faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
                'progress' => '30',
                'status' => 'Open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('projects')->insert($data);
    }
}
