<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class provinDistrict extends Controller
{
    function getProvinces()
    {
        $provinces = DB::table('provincia')->select('provincia.*')->get();

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
                'provincia_id'=>$request->provincia_id
            ]);

            return response()->json(
                ['response' => 'Distrito Registado Com Sucesso'],
                200
            );
        } catch (Exception $e) {
        }
    }


    function getTipo()
    {
        $Tipo = DB::table('tipos_de_propriedades')->select('tipos_de_propriedades.*')->get();

        return response()->json(
            $Tipo,
            200
        );
    }

    function saveTipo(Request $request)
    {
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
