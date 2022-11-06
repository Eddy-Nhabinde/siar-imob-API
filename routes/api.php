<?php

use App\Http\Controllers\ArrendamentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BairroController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PropriedadeController;
use App\Http\Controllers\provinDistrict;
use App\Http\Controllers\RequisicaoController;
use App\Http\Controllers\TiposDePropriedadeController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', AuthController::class . '@login');

Route::post('me',  AuthController::class . '@me');
//Registar um novo usuario
Route::post('register', PessoaController::class . '@register');

//Defaul estado = 1 (disponivel)
Route::post('all-props/{estado?}', PropriedadeController::class . '@getProps');

Route::post('save-prop', PropriedadeController::class . '@saveProp');

Route::get('tipos/{count?}', TiposDePropriedadeController::class . '@getTipoProp');

Route::post('save-prop-type', TiposDePropriedadeController::class . '@saveTipoProp');

Route::post('update-prop-type', TiposDePropriedadeController::class . '@editar');

Route::post('bairros', BairroController::class . '@getBairro');

Route::post('save-bairros', BairroController::class . '@saveBairro');

Route::get('update-bairros', BairroController::class . '@editar');

Route::post('save-arrendamento-details', ArrendamentoController::class . '@addArrendamento');

Route::get('cancel-arrendamento/{arrendamento_id}', ArrendamentoController::class . '@cancelArrendamento');

Route::get('my-situation/{id}', ArrendamentoController::class . '@sitView');

Route::get('all-arrendamentos/{id}', ArrendamentoController::class . '@getArrendamentos');

Route::get('provinces/{count?}', provinDistrict::class . '@getProvinces');

Route::post('provinces-save', provinDistrict::class . '@saveProvince');

Route::post('districts', provinDistrict::class . '@getDistrict');

Route::post('districts-save', provinDistrict::class . '@saveDistrict');

Route::get('estados', provinDistrict::class . '@getState');

Route::post('/all-requests', RequisicaoController::class . '@getRequets');

Route::post('/answer-request', RequisicaoController::class . '@answer');

Route::post('request-house', MailController::class . '@newRequest');

Route::group(['middleware' => ['apiJWT']], function () {
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
