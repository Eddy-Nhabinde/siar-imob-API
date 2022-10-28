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
        if ($request->distrito != "undefined") {
            $bairro = DB::table('bairros')->select('bairros.*')->where('distrito_id', $request->distrito)->get();
        } else if ($request->param == 1) {
            $bairro = DB::table('bairros')
                ->join('distrito', 'distrito.id', '=', 'bairros.distrito_id')
                ->join('provincia', 'provincia.id', '=', 'distrito.provincia_id')
                ->select('bairros.nome', 'distrito.nome as dname', 'provincia.nome as pname')
                ->get();
        } else {
            $bairro = DB::table('bairros')->select('bairros.*')->get();
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

    function deleteBairro($id)
    {
    }
}
