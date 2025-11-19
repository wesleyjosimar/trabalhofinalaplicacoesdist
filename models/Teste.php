<?php
/**
 * Modelo de Teste Antidoping
 */

require_once __DIR__ . '/../Database.php';

class Teste {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function listar($atletaId = null) {
        if ($atletaId) {
            $stmt = $this->db->prepare("SELECT t.*, a.nome as atleta_nome FROM testes t INNER JOIN atletas a ON t.atleta_id = a.id WHERE t.atleta_id = ? ORDER BY t.data_coleta DESC");
            $stmt->execute([$atletaId]);
        } else {
            $stmt = $this->db->query("SELECT t.*, a.nome as atleta_nome FROM testes t INNER JOIN atletas a ON t.atleta_id = a.id ORDER BY t.data_coleta DESC");
        }
        return $stmt->fetchAll();
    }

    public function buscarPorId($id) {
        $stmt = $this->db->prepare("SELECT t.*, a.nome as atleta_nome FROM testes t INNER JOIN atletas a ON t.atleta_id = a.id WHERE t.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function criar($dados) {
        $stmt = $this->db->prepare("INSERT INTO testes (atleta_id, data_coleta, competicao, laboratorio, resultado, observacoes, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
        return $stmt->execute([
            $dados['atleta_id'],
            $dados['data_coleta'],
            $dados['competicao'] ?? null,
            $dados['laboratorio'],
            $dados['resultado'] ?? 'pendente',
            $dados['observacoes'] ?? null
        ]);
    }

    public function atualizar($id, $dados) {
        $stmt = $this->db->prepare("UPDATE testes SET atleta_id = ?, data_coleta = ?, competicao = ?, laboratorio = ?, resultado = ?, observacoes = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([
            $dados['atleta_id'],
            $dados['data_coleta'],
            $dados['competicao'] ?? null,
            $dados['laboratorio'],
            $dados['resultado'] ?? 'pendente',
            $dados['observacoes'] ?? null,
            $id
        ]);
    }

    public function atualizarResultado($id, $resultado) {
        $stmt = $this->db->prepare("UPDATE testes SET resultado = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$resultado, $id]);
    }
}

