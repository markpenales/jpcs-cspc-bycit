<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'year_id',
        'section',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function name()
    {
        return "$this->program->name() $this->year->name $this->section";
    }
}
