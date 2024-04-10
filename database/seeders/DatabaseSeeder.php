<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // Departments::class,
            // Employees::class,
            Schedule::class,
            Projects::class,
            RemoteRequest::class,
            Tasks::class,
            Meetings::class,
            RemoteMonitoring::class,
        ]);
    }
}
