<?php
/**
 * Controller de Atletas
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/Atleta.php';
require_once __DIR__ . '/AuthController.php';

AuthController::verificarAutenticacao();

class AtletaController {
    private $atletaModel;

    public function __construct() {
        $this->atletaModel = new Atleta();
    }

    public function index() {
        $filtro = $_GET['filtro'] ?? '';
        $atletas = $this->atletaModel->listar($filtro);
        require_once VIEWS_PATH . '/atletas/index.php';
    }

    public function show() {
        $id = $_GET['id'] ?? 0;
        $atleta = $this->atletaModel->buscarPorId($id);
        
        if (!$atleta) {
            header('Location: /atletas.php');
            exit;
        }

        // Buscar testes do atleta
        require_once __DIR__ . '/../models/Teste.php';
        $testeModel = new Teste();
        $testes = $testeModel->listar($id);
        
        require_once VIEWS_PATH . '/atletas/show.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'] ?? '',
                'data_nascimento' => $_POST['data_nascimento'] ?? '',
                'documento' => $_POST['documento'] ?? '',
                'clube' => $_POST['clube'] ?? null,
                'federacao' => $_POST['federacao'] ?? null,
                'status' => $_POST['status'] ?? 'ativo'
            ];

            if ($this->atletaModel->criar($dados)) {
                header('Location: /atletas.php?sucesso=1');
                exit;
            } else {
                $erro = 'Erro ao criar atleta';
            }
        }

        require_once VIEWS_PATH . '/atletas/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $atleta = $this->atletaModel->buscarPorId($id);

        if (!$atleta) {
            header('Location: /atletas.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'] ?? '',
                'data_nascimento' => $_POST['data_nascimento'] ?? '',
                'documento' => $_POST['documento'] ?? '',
                'clube' => $_POST['clube'] ?? null,
                'federacao' => $_POST['federacao'] ?? null,
                'status' => $_POST['status'] ?? 'ativo'
            ];

            if ($this->atletaModel->atualizar($id, $dados)) {
                header('Location: /atletas.php?sucesso=1');
                exit;
            } else {
                $erro = 'Erro ao atualizar atleta';
            }
        }

        require_once VIEWS_PATH . '/atletas/edit.php';
    }

    public function inativar() {
        $id = $_GET['id'] ?? 0;
        $this->atletaModel->inativar($id);
        header('Location: /atletas.php?sucesso=1');
        exit;
    }
}

