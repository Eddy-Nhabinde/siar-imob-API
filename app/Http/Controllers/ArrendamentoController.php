<?php

namespace App\Http\Controllers;

use App\Models\arrendamento;
use Exception;
use Illuminate\Http\Request;

class ArrendamentoController extends Controller
{
    function addArrendamento(Request $request)
    {
        if ($request->data_i) {
            $ARRENDAMENTO = new arrendamento();

            try {
                $ARRENDAMENTO->propriedade_id = $request->prop_id;
                $ARRENDAMENTO->pessoa_id = $request->inquilino_id;
                $ARRENDAMENTO->data_inicio = $request->data_i;
                $ARRENDAMENTO->duracao = $request->duracao;
                $ARRENDAMENTO->valor_pago = $request->valor_pago;
                $ARRENDAMENTO->save();

                $ocupar = new PropriedadeController();
                $ocupar->ocuparProp($request->prop_id);
            } catch (Exception $e) {
                return response()->json([
                    'response' => "Erro inesperado"
                ], 500);
            }
            return response()->json([
                'response' => "Arrendamento feito com sucesso"
            ], 200);
        }
    }

    function sitView($id)
    {
    }
}
