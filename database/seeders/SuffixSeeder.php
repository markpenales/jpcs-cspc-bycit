<?php

namespace Database\Seeders;

use App\Models\Suffix;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuffixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suffixes = [
            "Jr.",
            "Sr.",
            "I",
            "II",
            "III",
            "IV",
            "V"
        ];

        foreach ($suffixes as $suffix) {
            Suffix::query()->firstOrCreate(['name' => $suffix], ['name' => $suffix]);
        }
    }
}
