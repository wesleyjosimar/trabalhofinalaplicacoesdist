<?php
/**
 * Controller de Usuários (apenas admin)
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/AuthController.php';

AuthController::verificarAdmin();

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function index() {
        $usuarios = $this->usuarioModel->listar();
        require_once VIEWS_PATH . '/usuarios/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'] ?? '',
                'email' => $_POST['email'] ?? '',
                'senha' => $_POST['senha'] ?? '',
                'perfil' => $_POST['perfil'] ?? 'operacional'
            ];

            if ($this->usuarioModel->criar($dados)) {
                header('Location: usuarios.php?sucesso=1');
                exit;
            } else {
                $erro = 'Erro ao criar usuário';
            }
        }

        require_once VIEWS_PATH . '/usuarios/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $usuario = $this->usuarioModel->buscarPorId($id);

        if (!$usuario) {
            header('Location: usuarios.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'] ?? '',
                'email' => $_POST['email'] ?? '',
                'perfil' => $_POST['perfil'] ?? 'operacional'
            ];

            if (!empty($_POST['senha'])) {
                $dados['senha'] = $_POST['senha'];
            }

            if ($this->usuarioModel->atualizar($id, $dados)) {
                header('Location: usuarios.php?sucesso=1');
                exit;
            } else {
                $erro = 'Erro ao atualizar usuário';
            }
        }

        require_once VIEWS_PATH . '/usuarios/edit.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->usuarioModel->excluir($id);
        header('Location: usuarios.php?sucesso=1');
        exit;
    }
}

