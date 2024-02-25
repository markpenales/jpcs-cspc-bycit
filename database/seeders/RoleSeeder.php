<?php

namespace Database\Seeders;

use App\Types\RoleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(RoleType::cases() as $roles){
            Role::create([
                'name' => $roles->value()
            ]);
        }
    }
}
