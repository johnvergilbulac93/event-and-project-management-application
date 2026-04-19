<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'date' => 'required|date|after_or_equal:today',
            'status' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'end_time.after' => "Invalid time.",
            'date.after_or_equal' => "Invalid date."
        ];
    }
}
