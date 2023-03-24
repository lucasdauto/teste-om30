<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use \App\Http\Controllers\CepController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('paciente', PacienteController::class);
Route::get('paciente/search',[PacienteController::class,'search'])->name('paciente.search');

Route::resource('consulta-cep', CepController::class);


Route::post('paciente/importacao',[PacienteController::class,'importacao'])->name('paciente.importacao');
