<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            'Bachelor of Science in Computer Science',
            "Bachelor of Science in Information Technology",
            "Bachelor of Science in Information Science",
            "Bachelor Library and Information Science",
        ];

        foreach ($programs as $program) {
            Program::query()->firstOrCreate([
                'name' => $program
            ]);
        }
    }
}
