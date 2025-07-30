<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'required|string',
            'suffix' => 'nullable',
            'date_of_birth' => 'required',
            'gender' => 'required|string',
            'birth_place' => 'required',
            'house_no' => 'required',
            'street' => 'required',
            'purok' => 'required',
            'mobile_no' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->id,
        ];
    }
}
