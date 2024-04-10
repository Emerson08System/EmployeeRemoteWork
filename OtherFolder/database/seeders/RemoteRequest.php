<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RemoteRequest extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $data = [
            [
                'emp_id' => 1,
                'request_reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'request_date' => $faker->dateTimeBetween('+5 days', '+10 days')->format('Y-m-d'),
                'total_score' => '0',
                'jobrole_suitability' => '0',
                'performance_accountability' => '0',
                'technological_readiness' => '0',
                'communication_skills' => '0',
                'work_environment' => '0',
                'flexibility_adaptability' => '0',
                'health_wellbeing' => '0',
                'organizational_needs' => '0',
                'legal_compliance' => '0',
                'status' => 'Pending',
            ],
            [
                'emp_id' => 2,
                'request_reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'request_date' => $faker->dateTimeBetween('+5 days', '+10 days')->format('Y-m-d'),
                'total_score' => '0',
                'jobrole_suitability' => '0',
                'performance_accountability' => '0',
                'technological_readiness' => '0',
                'communication_skills' => '0',
                'work_environment' => '0',
                'flexibility_adaptability' => '0',
                'health_wellbeing' => '0',
                'organizational_needs' => '0',
                'legal_compliance' => '0',
                'status' => 'Pending',
            ],
            [
                'emp_id' => 3,
                'request_reason' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'request_date' => $faker->dateTimeBetween('+5 days', '+10 days')->format('Y-m-d'),
                'total_score' => '0',
                'jobrole_suitability' => '0',
                'performance_accountability' => '0',
                'technological_readiness' => '0',
                'communication_skills' => '0',
                'work_environment' => '0',
                'flexibility_adaptability' => '0',
                'health_wellbeing' => '0',
                'organizational_needs' => '0',
                'legal_compliance' => '0',
                'status' => 'Pending',
            ],
        ];

        DB::table('remote_requests')->insert($data);
    }
}
