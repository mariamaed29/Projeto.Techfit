<?php
require_once __DIR__ . '/../core/db.php';

class VendaModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function cadastrar($dados) {
        try {
            $this->conn->begin_transaction();
            
            // Verifica produto e estoque
            $stmt = $this->conn->prepare("SELECT id, nome, preco, estoque FROM produtos WHERE id = ? AND ativo = 1");
            $stmt->bind_param("i", $dados['produto_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                throw new Exception('Produto não encontrado ou inativo');
            }
            
            $produto = $result->fetch_assoc();
            
            if ($produto['estoque'] < $dados['quantidade']) {
                throw new Exception('Estoque insuficiente');
            }
            
            $valor_total = $produto['preco'] * $dados['quantidade'];
            
            // Mascara o cartão
            $cartao_mascarado = null;
            if (!empty($dados['cartao'])) {
                $cartao_limpo = preg_replace('/[^0-9]/', '', $dados['cartao']);
                $cartao_mascarado = '****' . substr($cartao_limpo, -4);
            }
            
            // Insere a venda
            $stmt = $this->conn->prepare("
                INSERT INTO vendas (
                    nome_cliente, email_cliente, telefone_cliente, cpf_cliente,
                    produto_id, produto_nome, quantidade, valor_unitario, valor_total,
                    forma_pagamento, cartao_mascarado, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'confirmada')
            ");
            
            $stmt->bind_param(
                "ssssisiddss",
                $dados['nome'],
                $dados['email'],
                $dados['telefone'],
                $dados['cpf'],
                $dados['produto_id'],
                $produto['nome'],
                $dados['quantidade'],
                $produto['preco'],
                $valor_total,
                $dados['forma_pagamento'],
                $cartao_mascarado
            );
            
            if (!$stmt->execute()) {
                throw new Exception('Erro ao cadastrar venda');
            }
            
            $venda_id = $stmt->insert_id;
            
            // Atualiza o estoque
            $stmt = $this->conn->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id = ?");
            $stmt->bind_param("ii", $dados['quantidade'], $dados['produto_id']);
            
            if (!$stmt->execute()) {
                throw new Exception('Erro ao atualizar estoque');
            }
            
            // Se estoque zerou, desativa o produto
            $stmt = $this->conn->prepare("UPDATE produtos SET ativo = 0 WHERE id = ? AND estoque = 0");
            $stmt->bind_param("i", $dados['produto_id']);
            $stmt->execute();
            
            $this->conn->commit();
            
            return [
                'success' => true, 
                'message' => 'Compra realizada com sucesso!',
                'id' => $venda_id,
                'valor_total' => $valor_total
            ];
            
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Erro na venda: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    public function buscarPorEmail($email) {
        try {
            $stmt = $this->conn->prepare("
                SELECT v.*, p.imagem as produto_imagem
                FROM vendas v
                LEFT JOIN produtos p ON v.produto_id = p.id
                WHERE v.email_cliente = ?
                ORDER BY v.data_venda DESC
            ");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar vendas: " . $e->getMessage());
            return [];
        }
    }
    
    public function buscarPorId($id) {
        try {
            $stmt = $this->conn->prepare("
                SELECT v.*, p.imagem as produto_imagem
                FROM vendas v
                LEFT JOIN produtos p ON v.produto_id = p.id
                WHERE v.id = ?
            ");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Erro ao buscar venda: " . $e->getMessage());
            return null;
        }
    }
    
    public function buscarTodas() {
        try {
            $stmt = $this->conn->prepare("
                SELECT v.*, p.imagem as produto_imagem
                FROM vendas v
                LEFT JOIN produtos p ON v.produto_id = p.id
                ORDER BY v.data_venda DESC
            ");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar vendas: " . $e->getMessage());
            return [];
        }
    }
    
    public function cancelar($id) {
        try {
            $this->conn->begin_transaction();
            
            // Busca a venda
            $stmt = $this->conn->prepare("SELECT produto_id, quantidade, status FROM vendas WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                throw new Exception('Venda não encontrada');
            }
            
            $venda = $result->fetch_assoc();
            
            if ($venda['status'] === 'cancelada') {
                throw new Exception('Venda já cancelada');
            }
            
            // Cancela a venda
            $stmt = $this->conn->prepare("UPDATE vendas SET status = 'cancelada' WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            if (!$stmt->execute()) {
                throw new Exception('Erro ao cancelar venda');
            }
            
            // Devolve o estoque
            $stmt = $this->conn->prepare("UPDATE produtos SET estoque = estoque + ?, ativo = 1 WHERE id = ?");
            $stmt->bind_param("ii", $venda['quantidade'], $venda['produto_id']);
            $stmt->execute();
            
            $this->conn->commit();
            return true;
            
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Erro ao cancelar venda: " . $e->getMessage());
            return false;
        }
    }
    
    public function atualizarStatus($id, $status) {
        try {
            $stmt = $this->conn->prepare("UPDATE vendas SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao atualizar status: " . $e->getMessage());
            return false;
        }
    }
}
?>