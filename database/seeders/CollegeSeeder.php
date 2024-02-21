<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colleges = [
            "Camarines Sur Polytechnic Colleges",
            "ACLC - Iriga",
            "ACLC - Naga",
            "Ceguera Technological College",
            "University of Saint Anthony",
            "Baao Community College",
            "Ateneo de Naga University",
            "Naga College Foundation",
            "Systems Technology Institute - Naga",
            "Universidad de Sta. Isabel - Naga",
            "University of Nueva Caceres",
            "Central Bicol State University of Agriculture",
            "Camarines Norte State College",
            "Bicol University - Main Campus",
            "Bicol University - Polangui Campus",
            "Polangui Community College",
            "Sorsogon State University",
            "Catanduanes State University",
            "Aemillianum College Inc.",
        ];

        foreach ($colleges as $college) {
            College::query()->firstOrCreate([
                'name' => $college
            ]);
        }
    }
}
