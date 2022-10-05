<?php

namespace App\Http\Controllers;

use App\Models\tiposDePropriedade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiposDePropriedadeController extends Controller
{
    function getTipoProp()
    {
        $tipos = 0;
        try {
            $tipos  =  DB::table('tipos_de_propriedades')
                ->select('tipos_de_propriedades.*')
                ->get();
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
                $tipo->nome = $request->nome;
                $tipo->save();
            } catch (Exception $e) {
                return response()->json([
                    'response' => $e
                ], 500);
            }
        }

        return response()->json([
            'response' => 'Tipo salvo com sucesso'
        ], 200);
    }
}
