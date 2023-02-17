<?php

namespace Database\Factories\RMA;

use App\Models\RMA\RMA;
use App\Models\RMA\Type\RMA_TYPE;
use App\Models\RMA\Type\Validators\InverterIdentifierValidator;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RMA\RMAItem>
 */
class RMAItemFactory extends Factory
{
    const IDENTIFIERS = [
        RMA_TYPE::INVERTER => 'SA45G014',
        RMA_TYPE::BATTERY => 'BE26456789',
        RMA_TYPE::PERIPHERAL => 'PE1234567'
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return array_merge(['rma_id' => RMA::factory()],
            static::makeData($this->faker));
    }

    /**
     * @param Generator $faker
     * @return array
     */
    public static function makeData(Generator $faker): array
    {
        $type = RMA_TYPE::getRandomInstance();

        return [
            'type' => $type->value,
            'value' => call_user_func([$type->getAssociatedEnumClass(), 'getRandomValue']),
            'identifier' => strtoupper($faker->bothify('??####?###')), //not actually valid, but generating so something is there
            'reason' => $faker->sentence
        ];
    }

    /**
     * @param Generator $faker
     * @return array
     */
    public static function makeValidData(Generator $faker): array
    {
        $type = RMA_TYPE::getRandomInstance();
        $identifier = self::IDENTIFIERS[$type->value];
        $value = call_user_func([$type->getAssociatedEnumClass(), 'getRandomValue']);
        $identifier = substr($identifier,0, 2).(floatval(substr($value, -3)) * 10).substr($identifier, 2);
        $identifier = str_contains($value, InverterIdentifierValidator::TYPE_AC) ? 'CE'.substr($identifier, 2) : $identifier;

        return [
            'type' => $type->value,
            'value' => $value,
            'identifier' => $identifier,
            'reason' => $faker->sentence
        ];
    }
}
