<?php

namespace App\Http\Controllers;

use App\Models\pessoa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PessoaController extends Controller
{
    function register(Request $request)
    {
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
                'response' => 'O email introduzido ja foi registado'
            ], 409);
        } else if (sizeof($contacto) > 0) {
            return response()->json([
                'response' => 'O contacto introduzido ja foi registado'
            ], 409);
        } else {
            $user = new userController();
            $idUSer = $user->store($request->email, $request->senha, $request->acesso);
            if ($idUSer == 'erro') {
                return response()->json([
                    'response' => 'Erro inesperado'
                ], 500);
            } else {
                $Pessoa = new pessoa();
                $Pessoa->nome = $request->nome;
                $Pessoa->apelido  = $request->apelido;
                $Pessoa->datanasc = $request->dataNasc;
                $Pessoa->contacto = $request->contacto;
                $Pessoa->user_id = $idUSer;

                try {
                    $Pessoa->save();
                    return response()->json([
                        'response' => 'Registo feito com sucesso'
                    ], 200);
                } catch (Exception $e) {
                    return response()->json([
                        'resp' => $e
                    ]);
                }
            }
        }
    }
}
