<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Validator;

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
        $this->validate($this->request, [
            'cpf' => 'required|cpf',
        ]);

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

    public function import()
    {
        $validate = Validator::make($this->request->all(), [
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        $extension = $this->request->file('file')->getClientOriginalExtension();

        $pacientes = [];

        switch ($extension) {

            case 'xlsx':
                $pacientes = self::getDataFromXlsx($this->request->file('file'));
                break;

            case 'xls':
                $pacientes = self::getDataFromXlsx($this->request->file('file'));
                break;

            case 'csv':
                $pacientes = array_map('str_getcsv', file($this->request->file('file')->getPathName()));
                array_shift($pacientes);
                break;

            default:

                break;
        }

        if (count($pacientes)) {
            foreach ($pacientes as $paciente){
                $paciente = new Paciente();
                $paciente->foto = $paciente[0];
                $paciente->nome_completo = $paciente[1];
                $paciente->nome_mae = $paciente[2];
                $paciente->data_nascimento = $paciente[3];
                $paciente->cpf = $paciente[4];
                $paciente->cns = $paciente[5];
                $paciente->cep = $paciente[6];
                $paciente->logradouro = $paciente[7];
                $paciente->numero = $paciente[8];
                $paciente->complemento = $paciente[9];
                $paciente->bairro = $paciente[10];
                $paciente->cidade = $paciente[11];
                $paciente->estado = $paciente[12];

                if ($paciente->save()) {
                    return response()->json([
                        'message' => 'Pacientes cadastrados com sucesso'
                    ], 201);
                }

                return response()->json([
                    'message' => 'Erro ao cadastrar pacientes',
                ], 504);
            }
        }

        return response()->json([
            "message" => "Erro no arquivo de importação",
        ], 500);

    }

    private function getDataFromXlsx($file)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        array_shift($data);
        $data = array_filter(array_map('array_filter', $data));
        return $data;
    }

}
