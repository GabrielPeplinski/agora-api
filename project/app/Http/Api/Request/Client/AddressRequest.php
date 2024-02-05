<?php

namespace App\Http\Api\Request\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'zipCode' => 'required|string|min:8|max:8',
            'neighborhood' => 'required|string|min:3|max:255',
            'cityName' => 'required|string|min:3|max:255',
            'stateAbbreviation' => 'required|string|min:2|max:2|exists:address_states,name_abbreviation',
        ];
    }
}
