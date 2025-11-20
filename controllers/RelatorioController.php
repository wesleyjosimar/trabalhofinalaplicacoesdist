<?php
/**
 * Controller de Relatórios
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/Atleta.php';
require_once __DIR__ . '/../models/Teste.php';
require_once __DIR__ . '/AuthController.php';

class RelatorioController {
    private $atletaModel;
    private $testeModel;

    public function __construct() {
        // Verificar autenticação
        AuthController::verificarAutenticacao();
        
        $this->atletaModel = new Atleta();
        $this->testeModel = new Teste();
    }

    public function index() {
        $filtro = $_GET['filtro'] ?? 'todos';
        $dataInicio = $_GET['data_inicio'] ?? '';
        $dataFim = $_GET['data_fim'] ?? '';
        
        $todosAtletas = $this->atletaModel->listar();
        $todosTestes = $this->testeModel->listar();
        
        $dados = [
            'total_atletas' => count($todosAtletas),
            'atletas_ativos' => count(array_filter($todosAtletas, fn($a) => $a['status'] === 'ativo')),
            'total_testes' => count($todosTestes),
            'testes_pendentes' => count(array_filter($todosTestes, fn($t) => $t['resultado'] === 'pendente')),
            'testes_positivos' => count(array_filter($todosTestes, fn($t) => $t['resultado'] === 'positivo')),
            'testes_negativos' => count(array_filter($todosTestes, fn($t) => $t['resultado'] === 'negativo')),
        ];

        // Filtrar testes se necessário
        $testes = $this->testeModel->listar();
        if ($filtro !== 'todos') {
            $testes = array_filter($testes, fn($t) => $t['resultado'] === $filtro);
        }

        // Filtrar por data se fornecido
        if ($dataInicio && $dataFim) {
            $testes = array_filter($testes, function($t) use ($dataInicio, $dataFim) {
                $dataColeta = strtotime($t['data_coleta']);
                return $dataColeta >= strtotime($dataInicio) && $dataColeta <= strtotime($dataFim);
            });
        }

        $dados['testes_filtrados'] = $testes;
        $dados['filtro'] = $filtro;
        $dados['data_inicio'] = $dataInicio;
        $dados['data_fim'] = $dataFim;

        include VIEWS_PATH . '/relatorios/index.php';
    }

    public function exportar() {
        $formato = $_GET['formato'] ?? 'csv';
        $filtro = $_GET['filtro'] ?? 'todos';
        
        $testes = $this->testeModel->listar();
        if ($filtro !== 'todos') {
            $testes = array_filter($testes, fn($t) => $t['resultado'] === $filtro);
        }

        if ($formato === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=relatorio_testes_' . date('Y-m-d') . '.csv');
            
            $output = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Cabeçalho
            fputcsv($output, ['ID', 'Atleta', 'Documento', 'Data Coleta', 'Competição', 'Laboratório', 'Resultado', 'Observações']);
            
            // Dados
            foreach ($testes as $teste) {
                $atleta = $this->atletaModel->buscarPorId($teste['atleta_id']);
                fputcsv($output, [
                    $teste['id'],
                    $atleta['nome'] ?? '',
                    $atleta['documento'] ?? '',
                    $teste['data_coleta'],
                    $teste['competicao'] ?? '',
                    $teste['laboratorio'],
                    ucfirst($teste['resultado']),
                    $teste['observacoes'] ?? ''
                ]);
            }
            
            fclose($output);
            exit;
        }
    }
}

