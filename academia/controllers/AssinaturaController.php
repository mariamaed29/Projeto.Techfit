<?php
require_once __DIR__ . '/../models/AssinaturaModel.php';
require_once __DIR__ . '/../models/PlanoModel.php';

class AssinaturaController {
    private $model;
    private $planoModel;
    
    public function __construct() {
        $this->model = new AssinaturaModel();
        $this->planoModel = new PlanoModel();
    }
    
    // Exibe formulário de assinatura
    public function exibirFormulario() {
        include __DIR__ . '/../Assinar.html';
    }
    
    // Processa a assinatura
    public function processar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /Assinar.html");
            exit;
        }
        
        $nome = $_POST['nome'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $email = $_POST['email'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $plano_id = $_POST['plano_id'] ?? 0;
        $cartao = $_POST['cartao'] ?? '';
        $digito = $_POST['digito'] ?? '';
        $validade = $_POST['validade'] ?? '';
        
        // Validações básicas
        if (empty($nome) || empty($email) || empty($cpf) || empty($plano_id)) {
            die("Preencha todos os campos obrigatórios! <a href='/Assinar.html'>Voltar</a>");
        }
        
        // Remove formatação do CPF e cartão
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $cartao = preg_replace('/[^0-9]/', '', $cartao);
        
        // Validação de CPF
        if (strlen($cpf) !== 11) {
            die("CPF inválido! <a href='/Assinar.html'>Voltar</a>");
        }
        
        // Validação de cartão
        if (strlen($cartao) < 13 || strlen($cartao) > 19) {
            die("Número de cartão inválido! <a href='/Assinar.html'>Voltar</a>");
        }
        
        // Processa assinatura
        $resultado = $this->model->cadastrar($nome, $telefone, $email, $cpf, $plano_id, $cartao, $digito, $validade);
        
        if ($resultado['success']) {
            // Redireciona para página de sucesso
            header("Location: /assinatura/sucesso?id=" . $resultado['id']);
        } else {
            die($resultado['message'] . " <a href='/Assinar.html'>Voltar</a>");
        }
        exit;
    }
    
    // Página de sucesso da assinatura
    public function sucesso() {
        $id = $_GET['id'] ?? 0;
        $assinatura = $this->model->buscarPorId($id);
        
        if (!$assinatura) {
            die("Assinatura não encontrada!");
        }
        
        include __DIR__ . '/../views/assinaturaSucesso.php';
    }
    
    // Minhas assinaturas (para usuário logado)
    public function minhasAssinaturas() {
        if (!isset($_SESSION['user'])) {
            header("Location: /Login.html");
            exit;
        }
        
        $email = $_SESSION['user']['email'];
        $assinaturas = $this->model->buscarPorEmail($email);
        
        include __DIR__ . '/../views/minhasAssinaturas.php';
    }
    
    // ADMIN: Lista todas as assinaturas
    public function listarAssinaturas() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        $assinaturas = $this->model->buscarTodas();
        include __DIR__ . '/../views/admin/listaAssinaturas.php';
    }
    
    // ADMIN: Cancelar assinatura
    public function cancelarAssinatura($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        if ($this->model->cancelar($id)) {
            header("Location: /admin/assinaturas?msg=cancelada");
        } else {
            die("Erro ao cancelar assinatura!");
        }
        exit;
    }
    
    // ADMIN: Renovar assinatura
    public function renovarAssinatura($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        if ($this->model->renovar($id)) {
            header("Location: /admin/assinaturas?msg=renovada");
        } else {
            die("Erro ao renovar assinatura!");
        }
        exit;
    }
}
?>