<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'car_id.required' => 'Car ID is required.',
            'car_id.exists' => 'The selected car does not exist.',
            'start_date.required' => 'Start date is required.',
            'end_date.required' => 'End date is required.',
            'start_date.before' => 'Start date must be before the end date.',
            'end_date.after' => 'End date must be after the start date.',
        ];
    }
}
