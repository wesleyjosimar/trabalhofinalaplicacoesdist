<?php
/**
 * Modelo de Atleta
 */

require_once __DIR__ . '/../Database.php';

class Atleta {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function listar($filtro = '') {
        if ($filtro) {
            $stmt = $this->db->prepare("SELECT * FROM atletas WHERE nome LIKE ? OR documento LIKE ? ORDER BY nome");
            $filtro = "%$filtro%";
            $stmt->execute([$filtro, $filtro]);
        } else {
            $stmt = $this->db->query("SELECT * FROM atletas ORDER BY nome");
        }
        return $stmt->fetchAll();
    }

    public function buscarPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM atletas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function criar($dados) {
        $stmt = $this->db->prepare("INSERT INTO atletas (nome, data_nascimento, documento, clube, federacao, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
        return $stmt->execute([
            $dados['nome'],
            $dados['data_nascimento'],
            $dados['documento'],
            $dados['clube'] ?? null,
            $dados['federacao'] ?? null,
            $dados['status'] ?? 'ativo'
        ]);
    }

    public function atualizar($id, $dados) {
        $stmt = $this->db->prepare("UPDATE atletas SET nome = ?, data_nascimento = ?, documento = ?, clube = ?, federacao = ?, status = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([
            $dados['nome'],
            $dados['data_nascimento'],
            $dados['documento'],
            $dados['clube'] ?? null,
            $dados['federacao'] ?? null,
            $dados['status'] ?? 'ativo',
            $id
        ]);
    }

    public function inativar($id) {
        $stmt = $this->db->prepare("UPDATE atletas SET status = 'inativo', updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

