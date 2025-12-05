<?php
require_once __DIR__ . '/../core/db.php';

class PlanoModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function buscarTodos() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM planos WHERE ativo = 1 ORDER BY valor ASC");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar planos: " . $e->getMessage());
            return [];
        }
    }
    
    public function buscarPorId($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM planos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Erro ao buscar plano: " . $e->getMessage());
            return null;
        }
    }
    
    public function cadastrar($titulo, $valor, $beneficios, $duracao = 'mensal') {
        try {
            $stmt = $this->conn->prepare("INSERT INTO planos (titulo, valor, beneficios, duracao, ativo) VALUES (?, ?, ?, ?, 1)");
            $stmt->bind_param("sdss", $titulo, $valor, $beneficios, $duracao);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Plano cadastrado com sucesso', 'id' => $stmt->insert_id];
            } else {
                return ['success' => false, 'message' => 'Erro ao cadastrar plano'];
            }
        } catch (Exception $e) {
            error_log("Erro no cadastro de plano: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro no sistema'];
        }
    }
    
    public function editar($id, $titulo, $valor, $beneficios, $duracao = 'mensal') {
        try {
            $stmt = $this->conn->prepare("UPDATE planos SET titulo=?, valor=?, beneficios=?, duracao=? WHERE id=?");
            $stmt->bind_param("sdssi", $titulo, $valor, $beneficios, $duracao, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao editar plano: " . $e->getMessage());
            return false;
        }
    }
    
    public function deletar($id) {
        try {
            // Soft delete - apenas marca como inativo
            $stmt = $this->conn->prepare("UPDATE planos SET ativo = 0 WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao deletar plano: " . $e->getMessage());
            return false;
        }
    }
    
    public function buscarAtivos() {
        try {
            $stmt = $this->conn->prepare("SELECT id, titulo, valor, beneficios, duracao FROM planos WHERE ativo = 1 ORDER BY valor ASC");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar planos ativos: " . $e->getMessage());
            return [];
        }
    }
}
?>