<?php

namespace App\Http\Requests;

use App\Models\RMA\RMAItemData;
use App\Models\RMA\Type\RMA_TYPE;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

/**
 * @property-read array $items
 */
class CreateRMARequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'items' => ['required', 'array'],
            'items.*.type' => ['required', new EnumValue(RMA_TYPE::class)],
            'items.*.value' => ['required'],
            'items.*.identifier' => ['required'],
            'items.*.reason' => ['required'],
        ];
    }

    /**
     * @return RMAItemData[]
     */
    public function getItems(): array
    {
        return array_map(fn($data) => new RMAItemData($data), $this->items);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function checkIdentifierValidation(): void
    {
        $messages = [];

        foreach ($this->getItems() as $index => $item) {

            try {
                $message = RMA_TYPE::fromValue($item->type)->validate($item->value, strval($item->identifier));
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }

            if ($message !== null) {
                $messages["items.{$index}.identifier"] = $message;
            }
        }

        if (sizeof($messages) > 0) {
            throw ValidationException::withMessages($messages);
        }
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            try {
                $this->checkIdentifierValidation();
            } catch (ValidationException $exception) {
                $validator->errors()->merge($exception->validator->errors());
            }
        });
    }
}
