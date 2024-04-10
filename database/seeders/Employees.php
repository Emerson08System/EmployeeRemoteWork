<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Employees extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $employeeIDS = [];

        for ($i = 0; $i < 5; $i++) {
            $month = str_pad($faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT); // Generate a random two-digit month
            $day = str_pad($faker->numberBetween(1, 31), 2, '0', STR_PAD_LEFT); // Generate a random two-digit day
            $year = substr($faker->year(), 2); // Extract the last two digits of a random year
            $employee_id = "{$month}{$day}{$year}" . ($i + 1); // Concatenate the parts to form the employee ID
            $employeeIDS[] = $employee_id;
        }

        $data = [
            [
                'id' => 1,
                'job_role_id' => NULL,
                'code' => $employeeIDS[0],
                'last_name' => 'Oratil',
                'first_name' => 'Gabriel',
                'middle_name' => 'N / A',
                'email' => 'OratilGabriel@gmail.com',
                'status' => $faker->randomElement(['full time', 'part time','probationary']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'job_role_id' => NULL,
                'code' => $employeeIDS[1],
                'last_name' => 'Garlitos',
                'first_name' => 'Benhar',
                'middle_name' => 'N / A',
                'email' => 'BenharGarlitos@gmail.com',
                'status' => $faker->randomElement(['full time', 'part time','probationary']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 'employee_id' => $employeeIDS[2],
                'id' => 3,
                'job_role_id' => NULL,
                'code' => $employeeIDS[2],
                'first_name' => 'Rea',
                'last_name' => 'Abanidas',
                'middle_name' => 'N / A',
                'email' => 'ReaAbanidas@gmail.com',
                'status' => $faker->randomElement(['full time', 'part time','probationary']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'job_role_id' => NULL,
                'code' => $employeeIDS[3],
                'first_name' => 'Joshua',
                'last_name' => 'Ladios',
                'middle_name' => 'N / A',
                'email' => 'ReaAbanidas@gmail.com',
                'status' => $faker->randomElement(['full time', 'part time','probationary']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'job_role_id' => NULL,
                'code' => $employeeIDS[4],
                'first_name' => 'Jane',
                'last_name' => 'Aloquina',
                'middle_name' => 'N / A',
                'email' => 'JaneAloquina@gmail.com',
                'status' => $faker->randomElement(['full time', 'part time','probationary']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('employees')->insert($data);
    }
}
