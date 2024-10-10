<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
         'name' => 'required|string|max:100|unique:areas',
        ];
    }
    public function messages(): array
{
    return [
        'name.required' => 'El nombre del área es requerido',
        'name.string' => 'El nombre del área debe ser una cadena de texto',
        'name.max' => 'El nombre del área debe tener un máximo de 100 caracteres',
        'name.unique' => 'El área ya ha sido insertada ',
        'name.string' => 'El nombre del área ',
    ];
}
}
