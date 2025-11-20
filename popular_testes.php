<?php
/**
 * Script para popular banco com testes antidoping para os atletas cadastrados
 * Execute: php popular_testes.php
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/models/Atleta.php';
require_once __DIR__ . '/models/Teste.php';

$atletaModel = new Atleta();
$testeModel = new Teste();

// Buscar todos os atletas
$atletas = $atletaModel->listar();

if (empty($atletas)) {
    echo "❌ Nenhum atleta encontrado. Execute primeiro: php popular_atletas.php\n";
    exit;
}

echo "Encontrados " . count($atletas) . " atletas.\n";
echo "Criando testes antidoping...\n\n";

// Laboratórios de exemplo
$laboratorios = [
    'LADETEC - UFRJ',
    'LADETEC - USP',
    'Laboratório Brasileiro de Controle de Dopagem',
    'WADA Accredited Lab - Montreal',
    'Laboratório Antidoping - CBF'
];

// Competições de exemplo
$competicoes = [
    'Copa do Mundo 2022',
    'Copa América 2021',
    'Campeonato Brasileiro 2023',
    'Copa Libertadores 2023',
    'Eliminatórias Copa do Mundo',
    'Amistoso Internacional',
    'Copa do Brasil 2023',
    'Campeonato Estadual 2023'
];

// Resultados possíveis
$resultados = ['pendente', 'negativo', 'negativo', 'negativo', 'positivo']; // Mais negativos que positivos

$sucesso = 0;
$erros = 0;

// Criar 2-4 testes por atleta
foreach ($atletas as $atleta) {
    $numTestes = rand(2, 4); // Entre 2 e 4 testes por atleta
    
    for ($i = 0; $i < $numTestes; $i++) {
        // Data aleatória nos últimos 2 anos
        $diasAtras = rand(0, 730); // 0 a 730 dias (2 anos)
        $dataColeta = date('Y-m-d', strtotime("-$diasAtras days"));
        
        $teste = [
            'atleta_id' => $atleta['id'],
            'data_coleta' => $dataColeta,
            'competicao' => $competicoes[array_rand($competicoes)],
            'laboratorio' => $laboratorios[array_rand($laboratorios)],
            'resultado' => $resultados[array_rand($resultados)],
            'observacoes' => $i === 0 ? 'Teste de rotina' : null
        ];
        
        try {
            if ($testeModel->criar($teste)) {
                $sucesso++;
                echo "✅ Teste criado para {$atleta['nome']} - {$teste['data_coleta']} ({$teste['resultado']})\n";
            } else {
                $erros++;
                echo "❌ Erro ao criar teste para {$atleta['nome']}\n";
            }
        } catch (Exception $e) {
            $erros++;
            echo "❌ Erro ao criar teste para {$atleta['nome']}: " . $e->getMessage() . "\n";
        }
    }
}

echo "\n";
echo "========================================\n";
echo "Resultado:\n";
echo "✅ Sucesso: $sucesso testes criados\n";
echo "❌ Erros: $erros testes\n";
echo "========================================\n";

