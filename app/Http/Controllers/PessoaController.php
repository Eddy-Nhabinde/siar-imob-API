<?php

namespace App\Http\Controllers;

use App\Models\pessoa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PessoaController extends Controller
{
    function register(Request $request)
    {

        $validated = $request->validate([
            $request->email => 'email:rfc'
        ]);
        $dateOfBirth = $request->dataNasc;
        
        if (Carbon::parse($dateOfBirth)->age < 18) {
            return response()->json([
                'error' => 'O sistema e para maiores de 18 anos'
            ], 409);
        } else if (!$validated) {
            return response()->json([
                'error' => 'Email invalido'
            ], 409);
        } else {
            $email = DB::table('users')
                ->select('users.*')
                ->where('email', $request->email)
                ->get();

            $contacto = DB::table('pessoas')
                ->select('pessoas.*')
                ->where('contacto', $request->contacto)
                ->get();

            if (sizeof($email) > 0) {
                return response()->json([
                    'error' => 'O email introduzido ja foi registado'
                ], 409);
            } else if (sizeof($contacto) > 0) {
                return response()->json([
                    'error' => 'O contacto introduzido ja foi registado'
                ], 409);
            } else {

                $user = new userController();
                $idUSer = $user->store($request->email, $request->senha, $request->acesso);
                if ($idUSer == 'erro') {
                    return response()->json([
                        'error' => 'Erro inesperado'
                    ], 500);
                } else {

                    $Pessoa = new pessoa();
                    $Pessoa->nome = $request->nome;
                    $Pessoa->apelido  = $request->apelido;
                    $Pessoa->datanasc = $request->dataNasc;
                    $Pessoa->contacto = $request->contacto;
                    $Pessoa->conta = $request->conta;
                    $Pessoa->user_id = $idUSer;

                    try {
                        $Pessoa->save();
                        return response()->json([
                            'success' => 'Registo feito com sucesso'
                        ], 200);
                    } catch (Exception $e) {
                        return response()->json([
                            'error' => $e
                        ]);
                    }
                }
            }
        }
    }
}
