<?php

namespace Database\Seeders;

use App\Models\TShirtSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TShirtSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            "XS" => ["length" => 24, "width" => 17.5],
            "S" => ["length" => 25.5, "width" => 20],
            "M" => ["length" => 26, "width" => 20.5],
            "L" => ["length" => 26.5, "width" => 21.5],
            "XL" => ["length" => 26.5, "width" => 22],
            "2XL" => ["length" => 27, "width" => 22.5]
        ];

        foreach ($sizes as $size => $dimensions) {
            TShirtSize::query()->firstOrCreate(
                ["name" => $size],
                [
                    "name" => $size,
                    "length" => $dimensions['length'],
                    "width" => $dimensions["width"],
                ]
            );
        }
    }
}
