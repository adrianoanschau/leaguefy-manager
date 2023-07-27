<?php

namespace Leaguefy\LeaguefyManager\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Leaguefy\LeaguefyManager\Enums\StageTypes;

class UpdateStageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|nullable',
            'type' => [new Enum(StageTypes::class)],
            'competitors' => 'integer|nullable',
            'classify' => 'integer|nullable',
        ];
    }
}
