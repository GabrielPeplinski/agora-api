<?php

namespace App\Http\Api\Request\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SolicitationRequest extends FormRequest
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
            'title' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:5|max:1000',
            'latitudeCoordinates' => [
                'required',
                'string',
                'regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/',
            ],
            'longitudeCoordinates' => [
                'required',
                'string',
                'regex:/^[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/',
            ],
            'solicitationCategoryId' => 'required|exists:solicitation_categories,id',
        ];
    }
}
