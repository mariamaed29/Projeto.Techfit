<?php
require_once __DIR__ . '/../core/db.php';

class PedidoModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function criarPedido($produto_id, $produto_nome, $quantidade, $preco_unitario, $forma_pagamento, $endereco, $cep) {
        try {
            $total = $preco_unitario * $quantidade;
            
            $stmt = $this->conn->prepare(
                "INSERT INTO pedidos (produto_id, produto_nome, quantidade, preco_unitario, total, forma_pagamento, endereco, cep, status) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pendente')"
            );
            
            $stmt->bind_param(
                "isiddsss",
                $produto_id,
                $produto_nome,
                $quantidade,
                $preco_unitario,
                $total,
                $forma_pagamento,
                $endereco,
                $cep
            );
            
            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'pedido_id' => $stmt->insert_id,
                    'total' => $total
                ];
            }
            
            return ['success' => false, 'message' => 'Erro ao criar pedido'];
            
        } catch (Exception $e) {
            error_log("Erro ao criar pedido: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro no sistema'];
        }
    }
    
    public function buscarPorId($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM pedidos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Erro ao buscar pedido: " . $e->getMessage());
            return null;
        }
    }
    
    public function listarTodos() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM pedidos ORDER BY created_at DESC");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao listar pedidos: " . $e->getMessage());
            return [];
        }
    }
    
    public function atualizarStatus($id, $status) {
        try {
            $stmt = $this->conn->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao atualizar status: " . $e->getMessage());
            return false;
        }
    }
}
?>