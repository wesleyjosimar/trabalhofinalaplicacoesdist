<?php
/**
 * Script para popular banco com 10 atletas de exemplo
 * Execute: php popular_atletas.php
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/models/Atleta.php';

$atletaModel = new Atleta();

// Verificar se já existem atletas
$atletasExistentes = $atletaModel->listar();
if (count($atletasExistentes) >= 10) {
    echo "⚠️ Já existem " . count($atletasExistentes) . " atletas no banco.\n";
    echo "Deseja continuar mesmo assim? (s/n): ";
    $resposta = trim(fgets(STDIN));
    if (strtolower($resposta) !== 's') {
        exit;
    }
}

// Dados dos atletas
$atletas = [
    [
        'nome' => 'Neymar da Silva Santos Júnior',
        'data_nascimento' => '1992-02-05',
        'documento' => '12345678901',
        'clube' => 'Al-Hilal',
        'federacao' => 'CBF',
        'status' => 'ativo'
    ],
    [
        'nome' => 'Gabriel Jesus',
        'data_nascimento' => '1997-04-03',
        'documento' => '23456789012',
        'clube' => 'Arsenal',
        'federacao' => 'CBF',
        'status' => 'ativo'
    ],
    [
        'nome' => 'Casemiro',
        'data_nascimento' => '1992-02-23',
        'documento' => '34567890123',
        'clube' => 'Manchester United',
        'federacao' => 'CBF',
        'status' => 'ativo'
    ],
    [
        'nome' => 'Alisson Becker',
        'data_nascimento' => '1992-10-02',
        'documento' => '45678901234',
        'clube' => 'Liverpool',
        'federacao' => 'CBF',
        'status' => 'ativo'
    ],
    [
        'nome' => 'Marquinhos',
        'data_nascimento' => '1994-05-14',
        'documento' => '56789012345',
        'clube' => 'Paris Saint-Germain',
        'federacao' => 'CBF',
        'status' => 'ativo'
    ],
    [
        'nome' => 'Vinicius Junior',
        'data_nascimento' => '2000-07-12',
        'documento' => '67890123456',
        'clube' => 'Real Madrid',
        'federacao' => 'CBF',
        'status' => 'ativo'
    ],
    [
        'nome' => 'Rodrygo Goes',
        'data_nascimento' => '2001-01-09',
        'documento' => '78901234567',
        'clube' => 'Real Madrid',
        'federacao' => 'CBF',
        'status' => 'ativo'
    ],
    [
        'nome' => 'Raphinha',
        'data_nascimento' => '1996-12-14',
        'documento' => '89012345678',
        'clube' => 'Barcelona',
        'federacao' => 'CBF',
        'status' => 'ativo'
    ],
    [
        'nome' => 'Bruno Guimarães',
        'data_nascimento' => '1997-11-16',
        'documento' => '90123456789',
        'clube' => 'Newcastle United',
        'federacao' => 'CBF',
        'status' => 'ativo'
    ],
    [
        'nome' => 'Richarlison',
        'data_nascimento' => '1997-05-10',
        'documento' => '01234567890',
        'clube' => 'Tottenham',
        'federacao' => 'CBF',
        'status' => 'ativo'
    ]
];

$sucesso = 0;
$erros = 0;

foreach ($atletas as $atleta) {
    try {
        if ($atletaModel->criar($atleta)) {
            echo "✅ Atleta criado: {$atleta['nome']}\n";
            $sucesso++;
        } else {
            echo "❌ Erro ao criar: {$atleta['nome']}\n";
            $erros++;
        }
    } catch (Exception $e) {
        echo "❌ Erro ao criar {$atleta['nome']}: " . $e->getMessage() . "\n";
        $erros++;
    }
}

echo "\n";
echo "========================================\n";
echo "Resultado:\n";
echo "✅ Sucesso: $sucesso atletas\n";
echo "❌ Erros: $erros atletas\n";
echo "========================================\n";

