<?php

namespace App\Types;

enum RoleType
{
    case SUPER_ADMIN;
    case OFFICER;
    case USER;


    public function value(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => "Super Admin",
            self::OFFICER => "Officer",
            self::USER => "User"
        };
    }
}
