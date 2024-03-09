<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Types\RoleType;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'google_id',
        'email',
        'password',
        'last_name',
        'first_name',
        'middle_initial',
        'college_id',
        'section_id',
        't_shirt_size_id',
        'nickname',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $with = ['section', 'college', 'tShirtSize', 'restrictions'];

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->hasAnyRole([RoleType::SUPER_ADMIN->value(), RoleType::OFFICER->value()]);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function tShirtSize()
    {
        return $this->belongsTo(TShirtSize::class);
    }

    public function restrictions()
    {
        return $this->hasMany(DietaryRestriction::class);
    }

    public function registration()
    {
        return $this->hasOne(Registration::class);
    }
}
