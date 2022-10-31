<?php

namespace App\Http\Controllers;

use App\Models\arrendamento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                $ocupar->ocuparProp($request->prop_id, 1);
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
        $situation  = 0;
        try {
            $situation = DB::table('arrendamentos')
                ->select('arrendamentos.*')
                ->where('pessoa_id', $id)
                ->get();
        } catch (Exception $e) {
            return response()->json([
                'response' => "Erro inesperado"
            ], 500);
        }
        return response()->json(
            $situation,
            200
        );
    }

    function cancelArrendamento($arrendamento_id)
    {
        try {
            $idProp = DB::table('arrendamentos')
                ->select('arrendamentos.propriedade_id')
                ->where('id', $arrendamento_id)
                ->get();

            DB::table('arrendamentos')
                ->where('id', $arrendamento_id)
                ->update([
                    'estado' =>  'Cancelado'
                ]);

            $ocupar = new PropriedadeController();
            $ocupar->ocuparProp($idProp[0]->propriedade_id, 2);
        } catch (Exception $e) {
            return response()->json([
                'response' => "Erro inesperado"
            ], 500);
        }

        return response()->json([
            'response' => "Cancelamento Feiro com sucesso"
        ], 200);
    }

    function getArrendamentos($id)
    {
        $arrendamentos = 0;
        try {
            $arrendamentos = DB::table('arrendamentos')
                ->join('propriedades', 'propriedades.id', '=', 'arrendamentos.propriedade_id')
                ->join('tipos_de_propriedades', 'tipos_de_propriedades.id', '=', 'propriedades.tipos_de_propriedade_id')
                ->join('bairros', 'bairros.id', '=', 'propriedades.bairro_id')
                ->join('pessoas', 'pessoas.id', '=', 'arrendamentos.pessoa_id')
                ->select('bairros.nome as nomeBairro', 'propriedades.id as propID', 'pessoas.contacto', 'pessoas.nome as nomeInq','pessoas.apelido',  'arrendamentos.duracao', 'arrendamentos.estado')
                ->where('propriedades.dono_id', $id)
                ->get();
        } catch (Exception $e) {
            return response()->json([
                'response' => "Erro inesperado"
            ], 500);
        }

        return response()->json($arrendamentos, 200);
    }
}





