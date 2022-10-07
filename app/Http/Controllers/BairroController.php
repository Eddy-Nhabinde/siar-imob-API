<?php

namespace App\Http\Controllers;

use App\Models\bairro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BairroController extends Controller
{
    function getBairro(Request $request)
    {
        $bairro = 0;
        try {
            $bairro  =  DB::table('bairros')
                ->select('bairros.*')
                ->get();
        } catch (Exception $e) {
            return response()->json([
                'response' => 'Erro inesperado',
                500
            ]);
        }

        return response()->json(
            $bairro,
            200
        );
    }

    function saveBairro(Request $request)
    {
        $bairro = DB::table('bairros')
            ->select('bairros.*')
            ->where('nome', strtoupper($request->nome))
            ->get();

        if (sizeof($bairro) > 0) {
            return response()->json([
                'response' => 'O Bairro ja existe'
            ], 409);
        } else {
            $bairro = new bairro();

            try {
                $bairro->nome = strtoupper($request->nome);
                $bairro->distrito_id = $request->distrito_id;
                $bairro->save();
            } catch (Exception $e) {
                return response()->json([
                    'response' => "Erro inesperado"
                ], 500);
            }
        }

        return response()->json([
            'response' => 'Bairro salvo com sucesso'
        ], 200);
    }

    function editar(Request $request)
    {
        $response = 0;
        try {
            $response = DB::table('bairros')
                ->where('id', $request->id)
                ->update([
                    'nome' =>  strtoupper($request->nome)
                ]);
        } catch (Exception $e) {
            return response()->json([
                'response' => "Erro inesperado"
            ], 500);
        }


        if ($response == 1) {
            return response()->json([
                'response' => 'Alteracao feita com sucesso'
            ], 200);
        }
    }

    function deleteBairro($id){

    }
}
