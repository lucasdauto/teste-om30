<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacienteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
//                'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
                'foto' => 'required|string|max:255',
                'nome_completo' => 'string|required|max:45',
                'cpf' => 'string|max:14|required|unique:pacientes',
                'nome_mae' => 'string|required|max:45',
                'data_nascimento' => 'date|required',
                'cns' => 'required|unique:pacientes',
                'cep' => 'string|max:8|required',
                'logradouro' => 'string|required|max:45',
                'numero' => 'string|required|max:4',
                'complemento' => 'string|max:45',
                'bairro' => 'string|required|max:45',
                'cidade' => 'string|required|max:45',
                'estado' => 'string|required|max:45',

        ];
    }
}
