<?php

namespace App\Http\Controllers;

use App\Models\propriedade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PropriedadeController extends Controller
{
    function getProps($estado = 1, Request $request)
    {
        $props = 0;

        if ($request->bairro && !$request->tipo && !$request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->where('bairro_id', $request->bairro)
                ->where('status_id', $estado)
                ->where('dono_id', $request->dono_id)
                ->get();
        } else if (!$request->bairro && $request->tipo && !$request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->where('tipos_de_propriedade_id', $request->tipo)
                ->where('status_id', $estado)
                ->where('dono_id', $request->dono_id)
                ->get();
        } else if (!$request->bairro && !$request->tipo && $request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->whereBetween('preco', [0, $request->preco])
                ->where('status_id', $estado)
                ->where('dono_id', $request->dono_id)
                ->get();
        } else if ($request->bairro && $request->tipo && !$request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->where('bairro_id', $request->bairro)
                ->where('tipos_de_propriedade_id', $request->tipo)
                ->where('status_id', $estado)
                ->where('dono_id', $request->dono_id)
                ->get();
        } else if ($request->bairro && !$request->tipo && $request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->where('bairro_id', $request->bairro)
                ->whereBetween('preco', [0, $request->preco])
                ->where('status_id', $estado)
                ->where('dono_id', $request->dono_id)
                ->get();
        } else if (!$request->bairro && $request->tipo && $request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->whereBetween('preco', [0, $request->preco])
                ->where('tipos_de_propriedade_id', $request->tipo)
                ->where('status_id', $estado)
                ->where('dono_id', $request->dono_id)
                ->get();
        } else if ($request->bairro && $request->tipo && $request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->whereBetween('preco', [0, $request->preco])
                ->where('tipos_de_propriedade_id', $request->tipo)
                ->where('status_id', $estado)
                ->where('dono_id', $request->dono_id)
                ->where('bairro_id', $request->bairro)
                ->get();
        } else {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->where('status_id', $estado)
                ->where('dono_id', $request->dono_id)
                ->get();
        }

        return response()->json(
            $props,
            200
        );
    }

    function ocuparProp($prop_id, $operation)
    {
        try {
            if ($operation == 1) {
                $response = DB::table('propriedades')
                    ->where('id', $prop_id)
                    ->update([
                        'status_id' =>  2
                    ]);
            } else {
                $response = DB::table('propriedades')
                    ->where('id', $prop_id)
                    ->update([
                        'status_id' =>  1
                    ]);
            }

            return $response;
        } catch (Exception $e) {
            return 500;
        }
    }

    function  saveProp(Request $request)
    {
        if ($request->has('image')) {
            $image = $request->file('image');

            $name = time() . '.' . $image->getClientOriginalExtension();

            $image->move('images/', $name);

            $prop = new propriedade();

            $prop->descricao = $request->Desc;
            $prop->tipos_de_propriedade_id = $request->TipoValue;
            $prop->bairro_id = $request->Bairro;
            $prop->foto = $name;
            $prop->preco = $request->Valor;
            $prop->dono_id = '1';
            $prop->status_id = '1';

            try {
                $prop->save();
                return response()->json(
                    'Propriedade registada com sucesso'
                );
            } catch (Exception $e) {
                return response()->json([
                    'error' => 'Email invalido'
                ], 409);
            }
        }
    }
}
