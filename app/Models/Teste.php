<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teste extends Model
{
    protected $fillable = [
        'atleta_id',
        'data_coleta',
        'competicao',
        'laboratorio',
        'resultado',
        'observacoes',
    ];

    protected $casts = [
        'data_coleta' => 'date',
    ];

    public function atleta()
    {
        return $this->belongsTo(Atleta::class);
    }
}

