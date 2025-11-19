<?php
/**
 * Controller de Autenticação
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $usuario = $this->usuarioModel->buscarPorEmail($email);

            if ($usuario && $this->usuarioModel->verificarSenha($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_perfil'] = $usuario['perfil'];
                
                header('Location: index.php');
                exit;
            } else {
                $erro = 'Email ou senha incorretos';
            }
        }

        require_once VIEWS_PATH . '/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: login.php');
        exit;
    }

    public static function verificarAutenticacao() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login.php');
            exit;
        }
    }

    public static function verificarAdmin() {
        self::verificarAutenticacao();
        if ($_SESSION['usuario_perfil'] !== 'admin') {
            header('Location: index.php');
            exit;
        }
    }
}

