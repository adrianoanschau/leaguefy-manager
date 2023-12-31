<?php

namespace Leaguefy\LeaguefyManager\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConnectStageRequest extends FormRequest
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
            'parent' => 'required|string',
            'child' => 'required|string',
        ];
    }
}
