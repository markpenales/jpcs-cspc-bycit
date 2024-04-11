<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Section;
use App\Models\Year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            "BSCS 1A",
            "BSCS 1B",
            "BSCS 2A",
            "BSCS 2B",
            "BSCS 3A",
            "BSCS 3B",
            "BSCS 4A",
            "BSCS 4B",
            "BSIT 1A",
            "BSIT 1B",
            "BSIT 1C",
            "BSIT 1D",
            "BSIT 1E",
            "BSIT 1F",
            "BSIT 1G",
            "BSIT 1H",
            "BSIT 2A",
            "BSIT 2B",
            "BSIT 2C",
            "BSIT 2D",
            "BSIT 2E",
            "BSIT 2F",
            "BSIT 2G",
            "BSIT 2H",
            "BSIT 3A",
            "BSIT 3B",
            "BSIT 3C",
            "BSIT 3D",
            "BSIT 3E",
            "BSIT 3F",
            "BSIT 4A",
            "BSIT 4B",
            "BSIT 4C",
            "BSIT 4D",
            "BLIS 1A",
            "BLIS 2A",
            "BLIS 3A",
            "BLIS 3B",
            "BLIS 4A",
            "BLIS 4B",
            "BSIS 1A",
            "BSIS 1B",
            "BSIS 1C",
            "BSIS 2A",
            "BSIS 2B",
            "BSIS 2C",
            "BSIS 3A",
            "BSIS 3B",
            "BSIS 4A",
            "BSIS 4B",
            "BSCpE 1A",
            "BSCpE 1B",
        ];

        foreach ($sections as $section) {
            $splitSection = Str::of($section)->explode(' ');
            $program = $splitSection->first();
            $year = $splitSection->last()[0];
            $section = $splitSection->last()[1];

            Section::query()->firstOrCreate(
                [
                    'program_id' => Program::query()->where('code', $program)->first()->id,
                    'year_id' => Year::query()->where('name', $year)->first()->id,
                    'section' => $section,
                ],
                [
                    'program_id' => Program::query()->where('code', $program)->first()->id,
                    'year_id' => Year::query()->where('name', $year)->first()->id,
                    'section' => $section,
                ]
            );
        }
    }
}
