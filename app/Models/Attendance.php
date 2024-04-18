<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['venue', 'registration_id'];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}

