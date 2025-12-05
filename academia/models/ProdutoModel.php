<?php
require_once __DIR__ . '/../core/db.php';

class ProdutoModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function buscarTodos() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE ativo = 1 ORDER BY id DESC");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar produtos: " . $e->getMessage());
            return [];
        }
    }
    
    public function buscarPorId($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Erro ao buscar produto: " . $e->getMessage());
            return null;
        }
    }
    
    public function cadastrar($nome, $descricao, $preco, $imagem, $estoque = 0) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO produtos (nome, descricao, preco, imagem, estoque, ativo) VALUES (?, ?, ?, ?, ?, 1)");
            $stmt->bind_param("ssdsi", $nome, $descricao, $preco, $imagem, $estoque);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Produto cadastrado com sucesso', 'id' => $stmt->insert_id];
            } else {
                return ['success' => false, 'message' => 'Erro ao cadastrar produto'];
            }
        } catch (Exception $e) {
            error_log("Erro no cadastro de produto: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro no sistema'];
        }
    }
    
    public function editar($id, $nome, $descricao, $preco, $imagem = null, $estoque = null) {
        try {
            if ($imagem && $estoque !== null) {
                $stmt = $this->conn->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, imagem=?, estoque=? WHERE id=?");
                $stmt->bind_param("ssdsii", $nome, $descricao, $preco, $imagem, $estoque, $id);
            } else if ($imagem) {
                $stmt = $this->conn->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, imagem=? WHERE id=?");
                $stmt->bind_param("ssdsi", $nome, $descricao, $preco, $imagem, $id);
            } else if ($estoque !== null) {
                $stmt = $this->conn->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=? WHERE id=?");
                $stmt->bind_param("ssdii", $nome, $descricao, $preco, $estoque, $id);
            } else {
                $stmt = $this->conn->prepare("UPDATE produtos SET nome=?, descricao=?, preco=? WHERE id=?");
                $stmt->bind_param("ssdi", $nome, $descricao, $preco, $id);
            }
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao editar produto: " . $e->getMessage());
            return false;
        }
    }
    
    public function deletar($id) {
        try {
            // Soft delete - apenas marca como inativo
            $stmt = $this->conn->prepare("UPDATE produtos SET ativo = 0 WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao deletar produto: " . $e->getMessage());
            return false;
        }
    }
    
    public function atualizarEstoque($id, $quantidade) {
        try {
            $stmt = $this->conn->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id = ? AND estoque >= ?");
            $stmt->bind_param("iii", $quantidade, $id, $quantidade);
            return $stmt->execute() && $stmt->affected_rows > 0;
        } catch (Exception $e) {
            error_log("Erro ao atualizar estoque: " . $e->getMessage());
            return false;
        }
    }
}
?>