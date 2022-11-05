<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    function newRequest(Request $request)
    {
        $Ucontroller =  new userController();
        $data = $Ucontroller->getRequestOwnerData($request->inquilino);

        $req = new RequisicaoController();
        $saveRequest = $req->create($request->inquilino, $request->casa_id, $request->dono_id);

        $email_data = [
            'recipient' => $Ucontroller->getEmail($request->dono_id),
            'from' => 'dlabteamsd@gmail.com',
            'fromname' => 'SIAR-IMOB',
            'subject' => 'Nova Requisicao',
            'nome' => $data[0]->nome,
            'apelido' => $data[0]->apelido,
            'url' =>  'http://localhost:3000/login?casa_id=' . $request->casa_id . '&inq_id=' . $request->inquilino
        ];


        if ($saveRequest == 2) {
            if ($this->sendEmail($email_data) == 1) {
                return response(['sucesso' => 'Requisicao enviada!']);
            } else {
                return response(['erro' => 'Erro inesperado']);
            }
        } else {
            return response(['sucesso' => 'Requisicao enviada!']);
        }
    }

    function sendEmail($email_data)
    {
        try {
            Mail::send('new_request', $email_data, function ($message) use ($email_data) {
                $message->to($email_data['recipient'])
                    ->from($email_data['from'], $email_data['fromname'])
                    ->subject($email_data['subject']);
            });
            return 1;
        } catch (Exception $e) {
            return 2;
        }
    }
}
