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

    protected $with = [
        'program',
        'year',
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
        $program = $this->program->code;
        $year = $this->year->name;
        $section = $this->section;
        return "$program - $year$section";
    }
}
