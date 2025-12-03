<?php
require_once __DIR__ . '/../core/db.php';

class AssinaturaController {
    private $conn;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function processar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /Assinar.html");
            exit;
        }
        
        // Dados do cliente
        $nome = trim($_POST['nome'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
        
        // Dados do plano
        $plano_id = intval($_POST['plano_id'] ?? 0);
        
        // Dados do cartão (em produção, use gateway de pagamento!)
        $cartao = preg_replace('/[^0-9]/', '', $_POST['cartao'] ?? '');
        $cvv = $_POST['digito'] ?? '';
        $validade = $_POST['validade'] ?? '';
        
        // Validações básicas
        if (empty($nome) || empty($email) || empty($cpf) || $plano_id <= 0) {
            $_SESSION['erro'] = "Preencha todos os campos obrigatórios!";
            header("Location: /Assinar.html");
            exit;
        }
        
        if (strlen($cpf) !== 11) {
            $_SESSION['erro'] = "CPF inválido!";
            header("Location: /Assinar.html");
            exit;
        }
        
        if (strlen($cartao) < 13 || strlen($cartao) > 19) {
            $_SESSION['erro'] = "Número do cartão inválido!";
            header("Location: /Assinar.html");
            exit;
        }
        
        try {
            // Verifica se o plano existe
            $stmt = $this->conn->prepare("SELECT * FROM planos WHERE id = ?");
            $stmt->bind_param("i", $plano_id);
            $stmt->execute();
            $plano = $stmt->get_result()->fetch_assoc();
            
            if (!$plano) {
                $_SESSION['erro'] = "Plano não encontrado!";
                header("Location: /Assinar.html");
                exit;
            }
            
            // Verifica se o email já está cadastrado como assinante
            $stmt = $this->conn->prepare("SELECT id FROM assinaturas WHERE email = ? AND status = 'ativa'");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $_SESSION['erro'] = "Este email já possui uma assinatura ativa!";
                header("Location: /Assinar.html");
                exit;
            }
            
            // Insere a assinatura (em produção, processar pagamento antes!)
            $status = 'ativa';
            $data_inicio = date('Y-m-d');
            $data_fim = date('Y-m-d', strtotime('+1 month'));
            
            // IMPORTANTE: NUNCA salve dados completos do cartão!
            // Salve apenas os 4 últimos dígitos para referência
            $cartao_final = substr($cartao, -4);
            
            $stmt = $this->conn->prepare("
                INSERT INTO assinaturas 
                (nome, email, telefone, cpf, plano_id, status, data_inicio, data_fim, cartao_final) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->bind_param(
                "ssssissss",
                $nome,
                $email,
                $telefone,
                $cpf,
                $plano_id,
                $status,
                $data_inicio,
                $data_fim,
                $cartao_final
            );
            
            if ($stmt->execute()) {
                $_SESSION['sucesso'] = "Assinatura realizada com sucesso! Bem-vindo ao " . $plano['titulo'] . "!";
                
                // Redireciona para página de sucesso ou área do cliente
                header("Location: /Login.html");
            } else {
                throw new Exception("Erro ao processar assinatura");
            }
            
        } catch (Exception $e) {
            error_log("Erro na assinatura: " . $e->getMessage());
            $_SESSION['erro'] = "Erro ao processar assinatura. Tente novamente.";
            header("Location: /Assinar.html");
        }
        
        exit;
    }
}
?>