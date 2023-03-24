<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    protected $request, $paciente;

    public function __construct(Request $request, Paciente $paciente)
    {
        $this->request = $request;
        $this->paciente = $paciente;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if ($this->request->has('nome_completo')) {
            $pacientes = Paciente::where('nome_completo', 'LIKE', "%{$this->request->nome_completo}%")
                ->get();
            if (!$pacientes) {
                return response()->json(['message' => 'Nenhum paciente encontrado'], 404);
            }
        }

        if ($this->request->has('cpf')) {
            $pacientes = Paciente::where('cpf', 'LIKE', "%{$this->request->cpf}%")
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
        $this->paciente->foto = $request->foto;
        $this->paciente->nome_completo = $request->nome_completo;
        $this->paciente->nome_mae = $request->nome_mae;
        $this->paciente->data_nascimento = $request->data_nascimento;
        $this->paciente->cpf = $request->cpf;
        $this->paciente->cns = $request->cns;
        $this->paciente->cep = $request->cep;
        $this->paciente->logradouro = $request->logradouro;
        $this->paciente->numero = $request->numero;
        $this->paciente->complemento = $request->complemento;
        $this->paciente->bairro = $request->bairro;
        $this->paciente->cidade = $request->cidade;
        $this->paciente->estado = $request->estado;

        if ($this->paciente->save()) {
            return response()->json([
                'message' => 'Paciente cadastrado com sucesso'
            ], 201);
        }

        return response()->json([
            'message' => 'Erro ao cadastrar paciente',
            'errors' => $this->paciente->errors()
        ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        return response()->json([
            "paciente" => $paciente
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Paciente $paciente)
    {
        if ($paciente) {

            $paciente->update($this->request->all());

            return response()->json([
                'message' => 'Paciente atualizado com sucesso',
                'paciente' => $paciente
            ], 204);
        }

        return response()->json([
            'message' => 'Erro ao atualizar paciente',
            'errors' => $paciente->errors()
        ], 422);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
        if ($paciente) {
            $paciente->delete();
            return response()->json([
                'message' => 'Paciente removido com sucesso'
            ], 204);
        }

        return response()->json([
            'message' => 'Erro ao remover paciente',
        ], 422);
    }
}
