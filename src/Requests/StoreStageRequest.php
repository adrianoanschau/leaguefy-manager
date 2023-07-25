<?php

namespace Leaguefy\LeaguefyManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStageRequest extends FormRequest
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
            'tournament' => 'required|string',
            'lane' => 'integer|nullable',
            'position' => 'integer|nullable',
            'laneInsert' => 'string|nullable',
            'positionInsert' => 'string|nullable',
        ];
    }
}
