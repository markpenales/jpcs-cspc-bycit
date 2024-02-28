<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietaryRestriction extends Model
{
    use HasFactory;

    protected $fillable = [
        'restriction_id',
        'allergies',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restriction()
    {
        return $this->belongsTo(Restriction::class);
    }
}
