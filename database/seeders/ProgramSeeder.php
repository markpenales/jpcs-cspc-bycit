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
            'Bachelor of Science in Computer Science' => "BSCS",
            "Bachelor of Science in Information Technology" => "BSIT",
            "Bachelor of Science in Information Science" => "BSIS",
            "Bachelor Library and Information Science" => "BLIS",
        ];

        foreach ($programs as $program => $code) {
            Program::query()->firstOrCreate([
                'name' => $program,
                'code' => $code
            ]);
        }
    }
}
