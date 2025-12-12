<?php
require_once __DIR__ . '/../models/VendaModel.php';
require_once __DIR__ . '/../models/ProdutoModel.php';

class VendaController {
    private $model;
    private $produtoModel;
    
    public function __construct() {
        $this->model = new VendaModel();
        $this->produtoModel = new ProdutoModel();
    }
    
    // Exibe formulário de compra
    public function exibirFormulario() {
        $produto_id = $_GET['produto_id'] ?? 0;
        
        if (!$produto_id) {
            die("Produto não especificado! <a href='/loja.html'>Voltar para loja</a>");
        }
        
        $produto = $this->produtoModel->buscarPorId($produto_id);
        
        if (!$produto || !$produto['ativo']) {
            die("Produto não encontrado ou indisponível! <a href='/loja.html'>Voltar para loja</a>");
        }
        
        include __DIR__ . '/../views/comprar.php';
    }
    
    // Processa a compra
    public function processar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /loja.html");
            exit;
        }
        
        $dados = [
            'nome' => $_POST['nome'] ?? '',
            'email' => $_POST['email'] ?? '',
            'telefone' => $_POST['telefone'] ?? '',
            'cpf' => $_POST['cpf'] ?? '',
            'produto_id' => $_POST['produto_id'] ?? 0,
            'quantidade' => $_POST['quantidade'] ?? 1,
            'forma_pagamento' => $_POST['forma_pagamento'] ?? 'cartao_credito',
            'cartao' => $_POST['cartao'] ?? '',
        ];
        
        // Validações básicas
        if (empty($dados['nome']) || empty($dados['email']) || empty($dados['cpf'])) {
            die("Preencha todos os campos obrigatórios! <a href='javascript:history.back()'>Voltar</a>");
        }
        
        // Remove formatação do CPF
        $dados['cpf'] = preg_replace('/[^0-9]/', '', $dados['cpf']);
        
        // Validação de CPF
        if (strlen($dados['cpf']) !== 11) {
            die("CPF inválido! <a href='javascript:history.back()'>Voltar</a>");
        }
        
        // Processa a venda
        $resultado = $this->model->cadastrar($dados);
        
        if ($resultado['success']) {
            header("Location: /compra/sucesso?id=" . $resultado['id']);
        } else {
            die($resultado['message'] . " <a href='javascript:history.back()'>Voltar</a>");
        }
        exit;
    }
    
    // Página de sucesso da compra
    public function sucesso() {
        $id = $_GET['id'] ?? 0;
        $venda = $this->model->buscarPorId($id);
        
        if (!$venda) {
            die("Compra não encontrada!");
        }
        
        include __DIR__ . '/../views/compraSucesso.php';
    }
    
    // Minhas compras (para usuário logado)
    public function minhasCompras() {
        if (!isset($_SESSION['user'])) {
            header("Location: /Login.html");
            exit;
        }
        
        $email = $_SESSION['user']['email'];
        $vendas = $this->model->buscarPorEmail($email);
        
        include __DIR__ . '/../views/minhasCompras.php';
    }
    
    // ADMIN: Lista todas as vendas com filtros
    public function listarVendas() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        // Busca todas as vendas do banco
        $vendas = $this->model->buscarTodas();
        
        // Aplicar filtros se existirem
        if (!empty($_GET['status'])) {
            $status = $_GET['status'];
            $vendas = array_filter($vendas, function($v) use ($status) {
                return $v['status'] === $status;
            });
        }
        
        if (!empty($_GET['cliente'])) {
            $cliente = strtolower($_GET['cliente']);
            $vendas = array_filter($vendas, function($v) use ($cliente) {
                return strpos(strtolower($v['nome_cliente']), $cliente) !== false ||
                       strpos(strtolower($v['email_cliente']), $cliente) !== false;
            });
        }
        
        if (!empty($_GET['data_inicio'])) {
            $data_inicio = $_GET['data_inicio'];
            $vendas = array_filter($vendas, function($v) use ($data_inicio) {
                return date('Y-m-d', strtotime($v['data_venda'])) >= $data_inicio;
            });
        }
        
        if (!empty($_GET['data_fim'])) {
            $data_fim = $_GET['data_fim'];
            $vendas = array_filter($vendas, function($v) use ($data_fim) {
                return date('Y-m-d', strtotime($v['data_venda'])) <= $data_fim;
            });
        }
        
        // Reindexar array após filtros
        $vendas = array_values($vendas);
        
        include __DIR__ . '/../views/admin/listaVendas.php';
    }
    
    // ADMIN: Cancelar venda
    public function cancelarVenda() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        $id = $_GET['id'] ?? 0;
        
        if ($this->model->cancelar($id)) {
            header("Location: /admin/vendas?msg=cancelada");
        } else {
            die("Erro ao cancelar venda!");
        }
        exit;
    }
    
    // ADMIN: Atualizar status
    public function atualizarStatus() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        // Extrai o ID da URL
        $url = $_SERVER['REQUEST_URI'];
        preg_match('/\/admin\/vendas\/status\/(\d+)/', $url, $matches);
        $id = $matches[1] ?? 0;
        
        $status = $_POST['status'] ?? 'confirmada';
        
        if ($this->model->atualizarStatus($id, $status)) {
            header("Location: /admin/vendas?msg=atualizada");
        } else {
            die("Erro ao atualizar status!");
        }
        exit;
    }
}
?>