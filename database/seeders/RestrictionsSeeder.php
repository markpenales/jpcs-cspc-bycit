<?php

namespace Database\Seeders;

use App\Models\Restriction;
use App\Types\DietaryRestrictionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestrictionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (DietaryRestrictionType::cases() as $restriction) {
            Restriction::firstOrCreate([
                'name' => $restriction->value()
            ]);
        }
    }
}
