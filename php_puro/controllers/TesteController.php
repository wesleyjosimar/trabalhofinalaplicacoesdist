<?php
/**
 * Controller de Testes Antidoping
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/Teste.php';
require_once __DIR__ . '/../models/Atleta.php';
require_once __DIR__ . '/AuthController.php';

AuthController::verificarAutenticacao();

class TesteController {
    private $testeModel;
    private $atletaModel;

    public function __construct() {
        $this->testeModel = new Teste();
        $this->atletaModel = new Atleta();
    }

    public function index() {
        $atletaId = $_GET['atleta_id'] ?? null;
        $testes = $this->testeModel->listar($atletaId);
        $atletas = $this->atletaModel->listar();
        require_once VIEWS_PATH . '/testes/index.php';
    }

    public function create() {
        $atletas = $this->atletaModel->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'atleta_id' => $_POST['atleta_id'] ?? 0,
                'data_coleta' => $_POST['data_coleta'] ?? '',
                'competicao' => $_POST['competicao'] ?? null,
                'laboratorio' => $_POST['laboratorio'] ?? '',
                'resultado' => $_POST['resultado'] ?? 'pendente',
                'observacoes' => $_POST['observacoes'] ?? null
            ];

            if ($this->testeModel->criar($dados)) {
                header('Location: /testes.php?sucesso=1');
                exit;
            } else {
                $erro = 'Erro ao criar teste';
            }
        }

        require_once VIEWS_PATH . '/testes/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $teste = $this->testeModel->buscarPorId($id);

        if (!$teste) {
            header('Location: /testes.php');
            exit;
        }

        $atletas = $this->atletaModel->listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'atleta_id' => $_POST['atleta_id'] ?? 0,
                'data_coleta' => $_POST['data_coleta'] ?? '',
                'competicao' => $_POST['competicao'] ?? null,
                'laboratorio' => $_POST['laboratorio'] ?? '',
                'resultado' => $_POST['resultado'] ?? 'pendente',
                'observacoes' => $_POST['observacoes'] ?? null
            ];

            if ($this->testeModel->atualizar($id, $dados)) {
                header('Location: /testes.php?sucesso=1');
                exit;
            } else {
                $erro = 'Erro ao atualizar teste';
            }
        }

        require_once VIEWS_PATH . '/testes/edit.php';
    }
}

