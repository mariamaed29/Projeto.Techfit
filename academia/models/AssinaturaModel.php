<?php
require_once __DIR__ . '/../core/db.php';

class AssinaturaModel {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function cadastrar($nome, $telefone, $email, $cpf, $plano_id, $cartao, $digito, $validade) {
        try {
            // Verifica se o plano existe
            $stmt = $this->conn->prepare("SELECT id FROM planos WHERE id = ? AND ativo = 1");
            $stmt->bind_param("i", $plano_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                return ['success' => false, 'message' => 'Plano não encontrado ou inativo'];
            }
            
            // Verifica se já existe assinatura ativa para este email
            $stmt = $this->conn->prepare("SELECT id FROM assinaturas WHERE email = ? AND status = 'ativa'");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return ['success' => false, 'message' => 'Já existe uma assinatura ativa para este email'];
            }
            
            // Oculta parcialmente os dados sensíveis para armazenamento
            $cartao_mascarado = '****' . substr($cartao, -4);
            $digito_hash = password_hash($digito, PASSWORD_DEFAULT);
            
            // Calcula data de vencimento (30 dias)
            $data_vencimento = date('Y-m-d', strtotime('+30 days'));
            
            $stmt = $this->conn->prepare("INSERT INTO assinaturas (nome, telefone, email, cpf, plano_id, cartao_mascarado, digito_hash, validade, status, data_vencimento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'ativa', ?)");
            $stmt->bind_param("ssssissss", $nome, $telefone, $email, $cpf, $plano_id, $cartao_mascarado, $digito_hash, $validade, $data_vencimento);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Assinatura realizada com sucesso!', 'id' => $stmt->insert_id];
            } else {
                return ['success' => false, 'message' => 'Erro ao processar assinatura'];
            }
        } catch (Exception $e) {
            error_log("Erro na assinatura: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro no sistema'];
        }
    }
    
    public function buscarPorEmail($email) {
        try {
            $stmt = $this->conn->prepare("
                SELECT a.*, p.titulo as plano_titulo, p.valor as plano_valor 
                FROM assinaturas a 
                INNER JOIN planos p ON a.plano_id = p.id 
                WHERE a.email = ? 
                ORDER BY a.created_at DESC
            ");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar assinaturas: " . $e->getMessage());
            return [];
        }
    }
    
    public function buscarTodas() {
        try {
            $stmt = $this->conn->prepare("
                SELECT a.*, p.titulo as plano_titulo, p.valor as plano_valor 
                FROM assinaturas a 
                INNER JOIN planos p ON a.plano_id = p.id 
                ORDER BY a.created_at DESC
            ");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Erro ao buscar assinaturas: " . $e->getMessage());
            return [];
        }
    }
    
    public function buscarPorId($id) {
        try {
            $stmt = $this->conn->prepare("
                SELECT a.*, p.titulo as plano_titulo, p.valor as plano_valor, p.beneficios 
                FROM assinaturas a 
                INNER JOIN planos p ON a.plano_id = p.id 
                WHERE a.id = ?
            ");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Erro ao buscar assinatura: " . $e->getMessage());
            return null;
        }
    }
    
    public function cancelar($id) {
        try {
            $stmt = $this->conn->prepare("UPDATE assinaturas SET status = 'cancelada' WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao cancelar assinatura: " . $e->getMessage());
            return false;
        }
    }
    
    public function renovar($id) {
        try {
            $data_vencimento = date('Y-m-d', strtotime('+30 days'));
            $stmt = $this->conn->prepare("UPDATE assinaturas SET status = 'ativa', data_vencimento = ? WHERE id = ?");
            $stmt->bind_param("si", $data_vencimento, $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao renovar assinatura: " . $e->getMessage());
            return false;
        }
    }
}
?>