<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'availability_status' => 'required|boolean',
            'image' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The car name is required.',
            'type.required' => 'The car type is required.',
            'price_per_day.required' => 'The price per day is required.',
            'availability_status.required' => 'The availability status is required.',
        ];
    }
}
