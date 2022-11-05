<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requisicao extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id',
        'propriedade_id',
        'id_dono',
        'status',
        'mensagem'
    ];

}
