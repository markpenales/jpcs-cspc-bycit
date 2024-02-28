<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restriction extends Model
{
    use HasFactory;


    public function dietaryRestriction()
    {
        return $this->hasMany(DietaryRestriction::class);
    }
}
