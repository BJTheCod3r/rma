<?php

namespace App\Models\RMA\Type\Validators;

use App\Models\RMA\Type\BaseIdentifiableEnum;
use App\Models\RMA\Type\INVERTER;

class InverterIdentifierValidator implements ValidatesIdentifiers
{

    const TYPE_HYBRID = 'hy';
    const TYPE_AC = 'ac';

    /**
     * @param INVERTER $type
     * @param string $identifier
     * @inheritDoc
     */
    public function validate(BaseIdentifiableEnum $type, string $identifier): string|array|null
    {
        // The identifier must be 10 characters long.
        if (strlen($identifier) !== 10) {
            return "The identifier must be 10 characters long.";
        }

        // If the type is a hybrid inverter, the identifier must start with characters 'SA' or 'SD'.
        if (str_contains($type, self::TYPE_HYBRID) && !in_array(substr($identifier, 0, 2), ['SA', 'SD'])) {
            return "The identifier must start with characters 'SA' or 'SD'.";
        }

        // If the type is an AC coupled inverter, the identifier must start with characters 'CE'.
        if (str_contains($type, self::TYPE_AC) && substr($identifier, 0, 2) !== 'CE') {
            return "The identifier must start with characters 'CE'.";
        }

        // The 7th character in the identifier must be the letter 'G'.
        if (substr($identifier, 6, 1) !== 'G') {
            return "The 7th character in the identifier must be the letter 'G'.";
        }

        // The rest of the identifier must be made up of numbers.
        if (!ctype_digit(substr($identifier, 7))) {
            return "The rest of the identifier must be made up of numbers.";
        }

        return null;
    }
}
