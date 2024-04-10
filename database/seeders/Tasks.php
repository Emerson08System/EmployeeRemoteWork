<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Tasks extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $data = [
            [
                'project_id' => 1,
                'emp_id' => 1,
                'task_name' => 'Supplier Module',
                'description' => 'Create Supplier Lists and Suppplier Quotation',
                'due_date' => $faker->dateTimeBetween('+20 days', '+21 days')->format('Y-m-d'),
                'task_progress' => '0',
                'task_status' => 'Open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_id' => 1,
                'emp_id' => 2,
                'task_name' => 'Purchasing Module',
                'description' => 'Create Purchasing Module',
                'due_date' => $faker->dateTimeBetween('+20 days', '+21 days')->format('Y-m-d'),
                'task_progress' => '0',
                'task_status' => 'Open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_id' => 1,
                'emp_id' => 3,
                'task_name' => 'Invoice Module',
                'description' => 'Create Invoice Module',
                'due_date' => $faker->dateTimeBetween('+20 days', '+21 days')->format('Y-m-d'),
                'task_progress' => '0',
                'task_status' => 'Open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'project_id' => 3,
                'emp_id' => 4,
                'task_name' => 'E-commerce Website Development - Customer Side',
                'description' => 'Create Customer Information',
                'due_date' => $faker->dateTimeBetween('+20 days', '+21 days')->format('Y-m-d'),
                'task_progress' => '0',
                'task_status' => 'Open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'project_id' => 3,
                'emp_id' => 5,
                'task_name' => 'E-commerce Website Development - Seller Side',
                'description' => 'Create Seller Information',
                'due_date' => $faker->dateTimeBetween('+20 days', '+21 days')->format('Y-m-d'),
                'task_progress' => '0',
                'task_status' => 'Open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('tasks')->insert($data);
    }
}
