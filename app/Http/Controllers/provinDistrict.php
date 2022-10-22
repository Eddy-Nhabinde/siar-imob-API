<?php

namespace App\Http\Controllers;

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

    function getDistrict(Request $request)
    {
        $distrito = DB::table('distrito')->select('distrito.*')->where('provincia_id', $request->province)->get();

        return response()->json(
            $distrito,
            200
        );
    }

    function getBairros(Request $request)
    {
        $distrito = DB::table('bairros')->select('bairros.*')->where('distrito_id', $request->distrito)->get();

        return response()->json(
            $distrito,
            200
        );
    }
}
