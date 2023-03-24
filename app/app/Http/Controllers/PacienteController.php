<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use App\Models\Paciente;
use App\Rules\CPFValidationRule;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'nome_completo' => 'string|max:45',
            'cpf' => 'string|length:14',
        ]);

        if ($request->has('nome_completo')) {
            $pacientes = Paciente::where('nome_completo', 'LIKE', "%{$request->nome_completo}%")
                ->get();
            if (!$pacientes) {
                return response()->json(['message' => 'Nenhum paciente encontrado'], 404);
            }
        }

        if ($request->has('cpf')) {
            $pacientes = Paciente::where('cpf', 'LIKE', "%{$request->cpf}%")
                ->get();
            if (!$pacientes) {
                return response()->json(['message' => 'Nenhum paciente encontrado'], 404);
            }
        }

        if (!isset($pacientes)) {
            $pacientes = Paciente::all();
        }

        return response()->json([
            "pacientes" => $pacientes
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PacienteRequest $request)
    {
        $validateDate = $request->validate($request, [
            "cpf" => [new CPFValidationRule],
        ]);
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paciente $paciente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
        //
    }
}
