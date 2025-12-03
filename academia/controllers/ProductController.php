<?php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController {
    private $model;
    
    public function __construct() {
        $this->model = new ProductModel();
    }
    
    private function requireAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            $_SESSION['erro'] = "Acesso negado!";
            header("Location: /Login.html");
            exit;
        }
    }
    
    public function listar() {
        $this->requireAdmin();
        $produtos = $this->model->buscarTodos();
        include __DIR__ . '/../views/admin/listaProdutos.php';
    }
    
    public function novo() {
        $this->requireAdmin();
        include __DIR__ . '/../views/admin/novoProduto.php';
    }
    
    public function criar() {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/produtos/novo");
            exit;
        }
        
        // Pega os dados do formulário
        $nome = trim($_POST['nome'] ?? '');
        $preco = floatval($_POST['preco'] ?? 0);
        $descricao = trim($_POST['descricao'] ?? '');
        $imagem = trim($_POST['imagem'] ?? '');
        
        // Validações
        if (empty($nome)) {
            $_SESSION['erro'] = "O nome é obrigatório!";
            header("Location: /admin/produtos/novo");
            exit;
        }
        
        if ($preco <= 0) {
            $_SESSION['erro'] = "O preço deve ser maior que zero!";
            header("Location: /admin/produtos/novo");
            exit;
        }
        
        // Tenta criar o produto
        if ($this->model->criar($nome, $preco, $descricao, $imagem)) {
            $_SESSION['sucesso'] = "Produto criado com sucesso!";
            header("Location: /admin/produtos");
        } else {
            $_SESSION['erro'] = "Erro ao criar produto!";
            header("Location: /admin/produtos/novo");
        }
        exit;
    }
    
    public function editarForm($id) {
        $this->requireAdmin();
        
        // Valida o ID
        if (!is_numeric($id) || $id <= 0) {
            $_SESSION['erro'] = "ID inválido!";
            header("Location: /admin/produtos");
            exit;
        }
        
        $produto = $this->model->buscarPorId($id);
        
        if (!$produto) {
            $_SESSION['erro'] = "Produto não encontrado!";
            header("Location: /admin/produtos");
            exit;
        }
        
        include __DIR__ . '/../views/admin/editarProduto.php';
    }
    
    public function editarSalvar() {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/produtos");
            exit;
        }
        
        // Pega os dados do formulário
        $id = intval($_POST['id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $preco = floatval($_POST['preco'] ?? 0);
        $descricao = trim($_POST['descricao'] ?? '');
        $imagem = trim($_POST['imagem'] ?? '');
        
        // Validações
        if ($id <= 0) {
            $_SESSION['erro'] = "ID inválido!";
            header("Location: /admin/produtos");
            exit;
        }
        
        if (empty($nome)) {
            $_SESSION['erro'] = "O nome é obrigatório!";
            header("Location: /admin/produtos/editar?id=$id");
            exit;
        }
        
        if ($preco <= 0) {
            $_SESSION['erro'] = "O preço deve ser maior que zero!";
            header("Location: /admin/produtos/editar?id=$id");
            exit;
        }
        
        // Tenta editar o produto
        if ($this->model->editar($id, $nome, $preco, $descricao, $imagem)) {
            $_SESSION['sucesso'] = "Produto editado com sucesso!";
            header("Location: /admin/produtos");
        } else {
            $_SESSION['erro'] = "Erro ao editar produto!";
            header("Location: /admin/produtos/editar?id=$id");
        }
        exit;
    }
    
    public function deletar($id) {
        $this->requireAdmin();
        
        // Valida o ID
        if (!is_numeric($id) || $id <= 0) {
            $_SESSION['erro'] = "ID inválido!";
            header("Location: /admin/produtos");
            exit;
        }
        
        // Tenta deletar o produto
        if ($this->model->deletar($id)) {
            $_SESSION['sucesso'] = "Produto deletado com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao deletar produto!";
        }
        
        header("Location: /admin/produtos");
        exit;
    }
    
    public function listarJson() {
        $produtos = $this->model->buscarTodos();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($produtos, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
?>