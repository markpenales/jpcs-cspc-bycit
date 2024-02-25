<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CollegeSeeder::class,
            ProgramSeeder::class,
            YearSeeder::class,
            SectionSeeder::class,
            TShirtSizeSeeder::class,
            SuffixSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
