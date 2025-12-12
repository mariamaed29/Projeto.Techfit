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
            
            // Log para debug
            error_log("=== INICIANDO CADASTRO DE VENDA ===");
            error_log("Dados recebidos: " . print_r($dados, true));
            
            // Verifica produto e estoque
            $stmt = $this->conn->prepare("SELECT id, nome, preco, estoque FROM produtos WHERE id = ? AND ativo = 1");
            $stmt->bind_param("i", $dados['produto_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                throw new Exception('Produto não encontrado ou inativo');
            }
            
            $produto = $result->fetch_assoc();
            error_log("Produto encontrado: " . print_r($produto, true));
            
            if ($produto['estoque'] < $dados['quantidade']) {
                throw new Exception('Estoque insuficiente. Disponível: ' . $produto['estoque']);
            }
            
            $valor_total = $produto['preco'] * $dados['quantidade'];
            
            // Mascara o cartão
            $cartao_mascarado = null;
            if (!empty($dados['cartao'])) {
                $cartao_limpo = preg_replace('/[^0-9]/', '', $dados['cartao']);
                $cartao_mascarado = '****' . substr($cartao_limpo, -4);
            }
            
            // Prepara dados para inserção
            $nome_cliente = $dados['nome'];
            $email_cliente = $dados['email'];
            $telefone_cliente = $dados['telefone'];
            $cpf_cliente = $dados['cpf'];
            $produto_id = $dados['produto_id'];
            $produto_nome = $produto['nome'];
            $quantidade = $dados['quantidade'];
            $valor_unitario = $produto['preco'];
            $forma_pagamento = $dados['forma_pagamento'];
            $status = 'confirmada';
            
            // Log dos dados que serão inseridos
            error_log("Preparando INSERT com os dados:");
            error_log("Nome: $nome_cliente");
            error_log("Email: $email_cliente");
            error_log("Produto: $produto_nome (ID: $produto_id)");
            error_log("Quantidade: $quantidade");
            error_log("Valor unitário: $valor_unitario");
            error_log("Valor total: $valor_total");
            
            // Insere a venda
            $sql = "INSERT INTO vendas (
                nome_cliente, email_cliente, telefone_cliente, cpf_cliente,
                produto_id, produto_nome, quantidade, valor_unitario, valor_total,
                forma_pagamento, cartao_mascarado, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($sql);
            
            if (!$stmt) {
                throw new Exception('Erro ao preparar statement: ' . $this->conn->error);
            }
            
            $stmt->bind_param(
                "ssssisiddsss",
                $nome_cliente,
                $email_cliente,
                $telefone_cliente,
                $cpf_cliente,
                $produto_id,
                $produto_nome,
                $quantidade,
                $valor_unitario,
                $valor_total,
                $forma_pagamento,
                $cartao_mascarado,
                $status
            );
            
            if (!$stmt->execute()) {
                throw new Exception('Erro ao executar INSERT: ' . $stmt->error);
            }
            
            $venda_id = $stmt->insert_id;
            error_log("Venda inserida com ID: $venda_id");
            
            // Atualiza o estoque
            $stmt = $this->conn->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id = ?");
            $stmt->bind_param("ii", $quantidade, $produto_id);
            
            if (!$stmt->execute()) {
                throw new Exception('Erro ao atualizar estoque: ' . $stmt->error);
            }
            
            error_log("Estoque atualizado. Linhas afetadas: " . $stmt->affected_rows);
            
            // Se estoque zerou, desativa o produto
            $stmt = $this->conn->prepare("UPDATE produtos SET ativo = 0 WHERE id = ? AND estoque = 0");
            $stmt->bind_param("i", $produto_id);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                error_log("Produto desativado (estoque zerou)");
            }
            
            $this->conn->commit();
            error_log("=== VENDA CADASTRADA COM SUCESSO ===");
            
            return [
                'success' => true, 
                'message' => 'Compra realizada com sucesso!',
                'id' => $venda_id,
                'valor_total' => $valor_total
            ];
            
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("ERRO na venda: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
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
            $vendas = $result->fetch_all(MYSQLI_ASSOC);
            
            error_log("Total de vendas encontradas: " . count($vendas));
            
            return $vendas;
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