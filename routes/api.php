<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BairroController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PropriedadeController;
use App\Http\Controllers\TiposDePropriedadeController;
use App\Models\propriedade;
use Illuminate\Http\Request;
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

// route::post('register', PessoaController::class . '@register');

Route::post('login', AuthController::class . '@login');

//Registar um novo usuario
Route::post('register', PessoaController::class . '@register');

Route::get('all-props', PropriedadeController::class . '@getProps');

Route::get('all-prop-types', TiposDePropriedadeController::class . '@getTipoProp');

Route::post('save-prop-type', TiposDePropriedadeController::class . '@saveTipoProp');

Route::post('update-prop-type', TiposDePropriedadeController::class . '@editar');

Route::get('get-bairros', BairroController::class . '@getBairro');

Route::get('save-bairros', BairroController::class . '@saveBairro');

Route::get('update-bairros', BairroController::class . '@editar');


Route::group(['middleware' => ['apiJWT']], function () {

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
