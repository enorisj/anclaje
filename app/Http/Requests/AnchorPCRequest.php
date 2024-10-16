<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnchorPCRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'numero'=> 'required|number',
            'switch'=> 'required',
            'patch_panel'=> 'required',
            'puerto'=> 'number',
            'maquina'=> 'string|max:255',
            'description'=>'string|max:255',
            'mac'=>'mac_address',
            'anclaje'=>'string|max:255',
            'comentario'=>'string|max:255',
            'rp'=>'string|max:255',
            'direccionip'=>'ip',
            'vlan'=>'number',
            'areas_id'=> 'required|string|max:100|unique:areas',
    
        ];
    }

    public function messages(): array
    {
        return [
            'numero.required' => 'El numero es requerido',
            'switch' => 'El switch debe ser una cadena de texto',
            'patch_panel.required' => 'El path panes es un campo requerido',
      
        ];
    }
}
