<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory;
    use softDeletes;
    protected $table = 'pacientes';

    protected $fillable = [
        'foto',
        'nome_completo',
        'nome_mae',
        'data_nascimento',
        'cpf',
        'cns',
        'endereco_cep',
        'endereco_rua',
        'endereco_numero',
        'endereco_complemento',
        'endereco_bairro',
        'endereco_cidade',
        'endereco_estado',
    ];
}
