<?php

namespace Database\Seeders;

use App\Models\EmploymentStatus;
use App\Models\EmploymentType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\YearsOfOperation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

       $this->call([
           ContactSeeder::class,
           PhilippineStandardGeographicalCodeSeeder::class,
           SuffixSeeder::class,
           CivilStatusSeeder::class,

           CurrentPostionSeeder::class,
           EmploymentStatusSeeder::class,
           EmploymentTypeSeeder::class,
           TenureSeeder::class,
           WorkIndustrySeeder::class,
           YearsOfOperationSeeder::class,
       ]);
    }
}
