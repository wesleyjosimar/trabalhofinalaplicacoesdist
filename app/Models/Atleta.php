<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atleta extends Model
{
    protected $fillable = [
        'nome',
        'data_nascimento',
        'documento',
        'clube',
        'federacao',
        'status',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function testes()
    {
        return $this->hasMany(Teste::class);
    }

    public function isAtivo()
    {
        return $this->status === 'ativo';
    }
}

