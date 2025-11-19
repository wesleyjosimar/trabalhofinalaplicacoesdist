<?php
/**
 * Modelo de Usuário
 */

require_once __DIR__ . '/../Database.php';

class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function buscarPorEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function buscarPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function verificarSenha($senha, $hash) {
        return password_verify($senha, $hash);
    }

    public function listar() {
        $stmt = $this->db->query("SELECT id, nome, email, perfil, created_at FROM usuarios ORDER BY nome");
        return $stmt->fetchAll();
    }

    public function criar($dados) {
        $senhaHash = password_hash($dados['senha'], PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO usuarios (nome, email, senha, perfil, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        return $stmt->execute([
            $dados['nome'],
            $dados['email'],
            $senhaHash,
            $dados['perfil'] ?? 'operacional'
        ]);
    }

    public function atualizar($id, $dados) {
        $sql = "UPDATE usuarios SET nome = ?, email = ?, perfil = ?, updated_at = NOW()";
        $params = [$dados['nome'], $dados['email'], $dados['perfil'] ?? 'operacional'];
        
        if (!empty($dados['senha'])) {
            $sql .= ", senha = ?";
            $params[] = password_hash($dados['senha'], PASSWORD_BCRYPT);
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function excluir($id) {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

