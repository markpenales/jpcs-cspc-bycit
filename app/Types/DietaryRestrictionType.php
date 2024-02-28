<?php

namespace App\Types;

enum DietaryRestrictionType
{
    case VEGAN;
    case VEGETARIAN;
    case HALAL;
    case ALLERGIES;

    public function value()
    {
        return match ($this) {
            self::VEGAN => 'Vegan',
            self::VEGETARIAN => 'Vegetarian',
            self::HALAL => 'Halal',
            self::ALLERGIES => 'Allergies'
        };
    }
}
