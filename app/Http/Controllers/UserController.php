<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    function store($email, $senha, $acesso)
    {
        $user = new User();
        $user->email = $email;
        $user->password = password_hash($senha, PASSWORD_DEFAULT);
        $user->acesso = $acesso;

        try {
            $user->save();
            $id = DB::table('users')->where('email', $email)->value('id');
        } catch (Exception $e) {
            return "erro";
        }
        return $id;
    }
}
