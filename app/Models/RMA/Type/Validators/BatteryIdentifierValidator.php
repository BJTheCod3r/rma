<?php

namespace App\Models\RMA\Type\Validators;

use App\Models\RMA\Type\BaseIdentifiableEnum;
use App\Models\RMA\Type\BATTERY;

class BatteryIdentifierValidator implements ValidatesIdentifiers
{
    /**
     * @param BATTERY $type
     * @inheritDoc
     */
    public function validate(BaseIdentifiableEnum $type, string $identifier): string|array|null
    {
        // The identifier must be 12 characters long.
        if (strlen($identifier) !== 12) {
            return "The identifier must be 12 characters long.";
        }

        // The identifier must start with characters 'BE', 'BB' or 'BG'.
        if (!in_array(substr($identifier, 0, 2), ['BE', 'BB', 'BG'])) {
            return "The identifier must start with characters 'BE', 'BB' or 'BG'.";
        }

        // The identifier's 3rd and 4th characters must be the battery size times 10 (e.g. 9.5kWh = 95).
        if ($this->getBatterySize($type) !== floatval(substr($identifier, 2, 2))) {
            return "The identifier's 3rd and 4th characters must be the battery size times 10 (e.g. 9.5kWh = 95).";
        }

        // The rest of the identifier must be made up of numbers.
        if (!ctype_digit(substr($identifier, 4))) {
            return "The rest of the identifier must be made up of numbers.";
        }

        return null;
    }

    /**
     * @param string $type
     * @return float
     */
    private function getBatterySize(string $type): float
    {
        return floatval(substr($type, -3)) * 10;
    }
}
