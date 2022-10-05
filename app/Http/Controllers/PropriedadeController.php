<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropriedadeController extends Controller
{
    function getProps(Request $request)
    {
        $props = 0;

        if ($request->bairro && !$request->tipo && !$request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->where('bairro_id', $request->bairro)
                ->get();
        } else if (!$request->bairro && $request->tipo && !$request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->where('tipos_de_propriedade_id', $request->tipo)
                ->get();
        } else if (!$request->bairro && !$request->tipo && $request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->whereBetween('preco', [0, $request->preco])
                ->get();
        } else if ($request->bairro && $request->tipo && !$request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->where('bairro_id', $request->bairro)
                ->where('tipos_de_propriedade_id', $request->tipo)
                ->get();
        } else if ($request->bairro && !$request->tipo && $request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->where('bairro_id', $request->bairro)
                ->whereBetween('preco', [0, $request->preco])
                ->get();
        } else if (!$request->bairro && $request->tipo && $request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->whereBetween('preco', [0, $request->preco])
                ->where('tipos_de_propriedade_id', $request->tipo)
                ->get();
        } else if ($request->bairro && $request->tipo && $request->preco) {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->whereBetween('preco', [0, $request->preco])
                ->where('tipos_de_propriedade_id', $request->tipo)
                ->where('bairro_id', $request->bairro)
                ->get();
        } else {
            $props = DB::table('propriedades')
                ->select('propriedades.*')
                ->get();
        }

        return response()->json(
            $props,
            200
        );
    }
}
