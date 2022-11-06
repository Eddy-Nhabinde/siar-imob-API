<?php

namespace App\Http\Controllers;

use App\Models\requisicao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequisicaoController extends Controller
{
    function create($user_id, $casa_id, $dono_id)
    {
        try {
            $myRequest = DB::table('requisicaos')
                ->select('requisicaos.*')
                ->where('pessoa_id', $user_id)
                ->where('propriedade_id', $casa_id)
                ->get();
            if (sizeof($myRequest) > 0) {
                return 1;
            } else {
                // requisicao::create([
                //     'pessoa_id' => $user_id,
                //     'propriedade_id' => $casa_id,
                //     'id_Dono' => $dono_id,
                //     'mensagem' => '',
                //     'status' => 'Pendente'
                // ]);
            }
            return 2;
        } catch (Exception $e) {
            dd($e);
        }
    }

    function getRequets(Request $request)
    {
        $allRequest = 0;
        try {
            if ($request->inq_id) {
                if ($request->data) {
                    $allRequest = DB::table('requisicaos')
                        ->join('propriedades', 'propriedades.id', '=', 'requisicaos.propriedade_id')
                        ->join('pessoas', 'pessoas.user_id', '=', 'requisicaos.pessoa_id')
                        ->join('bairros', 'bairros.id', '=', 'propriedades.bairro_id')
                        ->join('tipos_de_propriedades', 'tipos_de_propriedades.id', '=', 'propriedades.tipos_de_propriedade_id')
                        ->select('requisicaos.status', 'requisicaos.id as reqId', 'pessoas.nome', 'pessoas.contacto', 'pessoas.apelido', 'propriedades.foto', 'propriedades.preco', 'bairros.nome as nomeBairro', 'tipos_de_propriedades.nome as nomeTipo', 'requisicaos.created_at as data')
                        ->where('pessoa_id', $request->inq_id)
                        ->where('requisicaos.created_at', '<=', $request->data)
                        ->get();
                } else {
                    $allRequest = DB::table('requisicaos')
                        ->join('propriedades', 'propriedades.id', '=', 'requisicaos.propriedade_id')
                        ->join('pessoas', 'pessoas.user_id', '=', 'requisicaos.pessoa_id')
                        ->join('bairros', 'bairros.id', '=', 'propriedades.bairro_id')
                        ->join('tipos_de_propriedades', 'tipos_de_propriedades.id', '=', 'propriedades.tipos_de_propriedade_id')
                        ->select('requisicaos.status', 'requisicaos.id as reqId', 'pessoas.nome', 'pessoas.contacto', 'pessoas.apelido', 'propriedades.foto', 'propriedades.preco', 'bairros.nome as nomeBairro', 'tipos_de_propriedades.nome as nomeTipo', 'requisicaos.created_at as data')
                        ->where('pessoa_id', $request->inq_id)
                        ->get();
                }
            } else {
                if ($request->data && $request->pessoa_id == 0) {
                    $allRequest = DB::table('requisicaos')
                        ->join('propriedades', 'propriedades.id', '=', 'requisicaos.propriedade_id')
                        ->join('pessoas', 'pessoas.user_id', '=', 'requisicaos.pessoa_id')
                        ->join('bairros', 'bairros.id', '=', 'propriedades.bairro_id')
                        ->join('tipos_de_propriedades', 'tipos_de_propriedades.id', '=', 'propriedades.tipos_de_propriedade_id')
                        ->select('requisicaos.status', 'requisicaos.id as reqId', 'pessoas.nome', 'pessoas.contacto', 'pessoas.apelido', 'propriedades.foto', 'propriedades.preco', 'bairros.nome as nomeBairro', 'tipos_de_propriedades.nome as nomeTipo', 'requisicaos.created_at as data')
                        ->where('id_Dono', $request->dono_id)
                        ->where('requisicaos.created_at', '<=', $request->data)
                        ->get();
                } else if ($request->pessoa_id != 0 && $request->casa_id != 0 && $request->casa_id != 'null' && $request->pessoa_id != 'null') {
                    $allRequest = DB::table('requisicaos')
                        ->join('propriedades', 'propriedades.id', '=', 'requisicaos.propriedade_id')
                        ->join('pessoas', 'pessoas.user_id', '=', 'requisicaos.pessoa_id')
                        ->join('bairros', 'bairros.id', '=', 'propriedades.bairro_id')
                        ->join('tipos_de_propriedades', 'tipos_de_propriedades.id', '=', 'propriedades.tipos_de_propriedade_id')
                        ->select('requisicaos.status', 'requisicaos.id as reqId', 'pessoas.nome', 'pessoas.contacto', 'pessoas.apelido', 'propriedades.foto', 'propriedades.preco', 'bairros.nome as nomeBairro', 'tipos_de_propriedades.nome as nomeTipo', 'requisicaos.created_at as data')
                        ->where('id_Dono', $request->dono_id)
                        ->where('requisicaos.pessoa_id', $request->pessoa_id)
                        ->where('requisicaos.propriedade_id', $request->casa_id)
                        ->get();
                } else {
                    $allRequest = DB::table('requisicaos')
                        ->join('propriedades', 'propriedades.id', '=', 'requisicaos.propriedade_id')
                        ->join('pessoas', 'pessoas.user_id', '=', 'requisicaos.pessoa_id')
                        ->join('bairros', 'bairros.id', '=', 'propriedades.bairro_id')
                        ->join('tipos_de_propriedades', 'tipos_de_propriedades.id', '=', 'propriedades.tipos_de_propriedade_id')
                        ->select('requisicaos.status', 'requisicaos.id as reqId', 'pessoas.nome', 'pessoas.contacto', 'pessoas.apelido', 'propriedades.foto', 'propriedades.preco', 'bairros.nome as nomeBairro', 'tipos_de_propriedades.nome as nomeTipo', 'requisicaos.created_at as data')
                        ->where('id_Dono', $request->dono_id)
                        ->get();
                }
            }
            return response([$allRequest]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    function answer(Request $request)
    {

        try {
            $allRequest = DB::table('requisicaos')
                ->join('propriedades', 'propriedades.id', '=', 'requisicaos.propriedade_id')
                ->join('users', 'users.id', '=', 'requisicaos.pessoa_id')
                ->join('pessoas', 'pessoas.user_id', '=', 'users.id')
                ->join('bairros', 'bairros.id', '=', 'propriedades.bairro_id')
                ->select('bairros.nome', 'users.email', 'pessoas.nome as nomeInq', 'pessoas.apelido')
                ->where('requisicaos.id', $request->id)
                ->get();

            $email = new MailController();

            if ($email->requestAnswer($allRequest, $request->status) == 1) {
                requisicao::where('id', $request->id)->update(['status' => $request->status]);
            } else {
                return response(['erro' => 'Erro inesperado']);
            }
            return response(['sucesso' => 'requisicao ' . $request->status . ' com sucesso']);
        } catch (Exception $e) {
            return response(['erro' => 'Erro inesperado']);
        }
    }
}
