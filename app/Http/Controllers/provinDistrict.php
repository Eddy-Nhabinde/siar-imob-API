<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class provinDistrict extends Controller
{
    function getProvinces($count = 0)
    {
        $provinces  = 0;
        if ($count != 0) {
            $provinces = DB::table('provincia')
                ->select(array('provincia.nome', DB::raw('COUNT(distrito.id) as totalDistrito')))
                ->leftJoin('distrito', 'distrito.provincia_id', '=', 'provincia.id')
                ->groupBy('provincia.nome')
                ->get();
        } else {
            $provinces = DB::table('provincia')->select('provincia.*')->get();
        }

        return response()->json(
            $provinces,
            200
        );
    }

    function saveProvince(Request $request)
    {
        try {
            DB::table('provincia')->insert([
                'nome' => $request->nome
            ]);

            return response()->json(
                ['response' => 'Provincia Registada Com Sucesso'],
                200
            );
        } catch (Exception $e) {
        }
    }

    function getDistrict(Request $request)
    {
        if ($request->province != 'undefined') {
            $distrito = DB::table('distrito')->select('distrito.*')->where('provincia_id', $request->province)->get();
        } else if ($request->param == 1) {
            $distrito = DB::table('distrito')
                ->select(array('distrito.nome', DB::raw('COUNT(bairros.id) as totalBairross')))
                ->leftJoin('bairros', 'bairros.distrito_id', '=', 'distrito.id')
                ->groupBy('distrito.nome')
                ->get();
        } else {
            $distrito = DB::table('distrito')->select('distrito.*')->get();
        }

        return response()->json(
            $distrito,
            200
        );
    }

    function saveDistrict(Request $request)
    {
        try {
            DB::table('distrito')->insert([
                'nome' => $request->nome,
                'provincia_id' => $request->provincia_id
            ]);

            return response()->json(
                ['response' => 'Distrito Registado Com Sucesso'],
                200
            );
        } catch (Exception $e) {
        }
    }



    function getState()
    {
        $estado = DB::table('status')->select('status.*')->get();

        return response()->json(
            $estado,
            200
        );
    }
}
