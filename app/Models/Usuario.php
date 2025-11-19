<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model
{
    protected $table = 'usuarios';
    
    protected $fillable = [
        'nome',
        'email',
        'senha',
        'perfil',
    ];

    protected $hidden = [
        'senha',
    ];

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = Hash::make($value);
    }

    public function verificarSenha($senha)
    {
        return Hash::check($senha, $this->attributes['senha']);
    }

    public function isAdmin()
    {
        return $this->perfil === 'admin';
    }
}

