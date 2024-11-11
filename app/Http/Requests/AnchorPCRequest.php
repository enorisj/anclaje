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
            'numero'=> 'required|numeric',
            'switch'=> 'nullable|string|max:20',
            'patch_panel'=> 'nullable|string|max:20',
            'puerto'=> 'nullable|numeric',
            'maquina'=> 'nullable|string|max:255',
            'descripcion'=>'nullable|string|max:255',
            'mac'=>'nullable|mac_address',
            'anclaje'=>'nullable|string|max:255',
            'comentario'=>'nullable|string|max:255',
            'rp'=>'nullable|string|max:255',
            'direccionip'=>'nullable|ip',
            'vlan'=>'nullable|string',
            'areas_id'=> 'required'    
        ];
    }
/*
    public function messages(): array
    {
        return [
            'numero.required' => 'El numero es requerido',
            'switch' => 'El switch debe ser una cadena de texto',
            'patch_panel.required' => 'El path panes es un campo requerido',
      
        ];
    }*/
}
