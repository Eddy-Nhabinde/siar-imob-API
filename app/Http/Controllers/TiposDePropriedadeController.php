<?php

namespace App\Http\Controllers;

use App\Models\tiposDePropriedade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiposDePropriedadeController extends Controller
{
    function getTipoProp($count = 0)
    {
        $tipos = 0;
        try {
            if ($count > 0) {
                $tipos = DB::table('tipos_de_propriedades')
                    ->select(array('tipos_de_propriedades.nome', DB::raw('COUNT(propriedades.id) as totalCasas')))
                    ->leftJoin('propriedades', 'propriedades.tipos_de_propriedade_id', '=', 'tipos_de_propriedades.id')
                    ->groupBy('tipos_de_propriedades.nome')
                    ->get();
            } else {
                $tipos  =  DB::table('tipos_de_propriedades')
                    ->select('tipos_de_propriedades.*')
                    ->get();
            }
        } catch (Exception $e) {
            return response()->json([
                'response' => 'Erro inesperado',
                500
            ]);
        }

        return response()->json(
            $tipos,
            200
        );
    }

    function saveTipoProp(Request $request)
    {
        $tipo = DB::table('tipos_de_propriedades')
            ->select('tipos_de_propriedades.*')
            ->where('nome', strtoupper($request->nome))
            ->get();

        if (sizeof($tipo) > 0) {
            return response()->json([
                'response' => 'O tipo de propriedade ja existe'
            ], 409);
        } else {
            $tipo = new tiposDePropriedade();

            try {
                $tipo->nome = strtoupper($request->nome);
                $tipo->save();
            } catch (Exception $e) {
                return response()->json([
                    'response' => "Erro inesperado"
                ], 500);
            }
        }

        return response()->json([
            'response' => 'Tipo salvo com sucesso'
        ], 200);
    }

    function editar(Request $request)
    {
        $response = 0;
        try {
            $response = DB::table('tipos_de_propriedades')
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
}
