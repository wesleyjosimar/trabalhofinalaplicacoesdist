<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Atleta;
use App\Models\Teste;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário admin padrão
        Usuario::create([
            'nome' => 'Administrador',
            'email' => 'admin@cbf.com.br',
            'senha' => 'admin123',
            'perfil' => 'admin',
        ]);

        Usuario::create([
            'nome' => 'Operador',
            'email' => 'operador@cbf.com.br',
            'senha' => 'operador123',
            'perfil' => 'operacional',
        ]);
    }
}

