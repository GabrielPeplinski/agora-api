<?php

namespace App\Http\Api\Request\Client\Solicitation;

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
            'latitudeCoordinates' => 'required|string',
            'longitudeCoordinates' => 'required|string',
            'solicitationCategoryId' => 'required|exists:solicitation_categories,id',
        ];
    }
}
