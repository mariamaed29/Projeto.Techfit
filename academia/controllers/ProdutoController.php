<?php
require_once __DIR__ . '/../models/ProdutoModel.php';

class ProdutoController {
    private $model;
    
    public function __construct() {
        $this->model = new ProdutoModel();
    }
    
    // Exibe a loja para clientes
    public function exibirLoja() {
        include __DIR__ . '/../loja.html';
    }
    
    // API: Retorna todos os produtos em JSON
    public function listarProdutosAPI() {
        header('Content-Type: application/json');
        $produtos = $this->model->buscarTodos();
        echo json_encode($produtos);
        exit;
    }
    
    // ADMIN: Lista produtos para gerenciamento
    public function listarProdutos() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        $produtos = $this->model->buscarTodos();
        include __DIR__ . '/../views/admin/listaProdutos.php';
    }
    
    // ADMIN: Formulário de cadastro
    public function cadastrarProdutoForm() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        include __DIR__ . '/../views/admin/cadastrarProduto.php';
    }
    
    // ADMIN: Processa cadastro
    public function cadastrarProdutoSalvar() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/produtos/novo");
            exit;
        }
        
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $imagem = $_POST['imagem'] ?? '';
        $estoque = $_POST['estoque'] ?? 0;
        
        if (empty($nome) || empty($preco)) {
            die("Nome e preço são obrigatórios! <a href='/admin/produtos/novo'>Voltar</a>");
        }
        
        $resultado = $this->model->cadastrar($nome, $descricao, $preco, $imagem, $estoque);
        
        if ($resultado['success']) {
            header("Location: /admin/produtos?msg=cadastrado");
        } else {
            die($resultado['message'] . " <a href='/admin/produtos/novo'>Voltar</a>");
        }
        exit;
    }
    
    // ADMIN: Formulário de edição
    public function editarProdutoForm($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        $produto = $this->model->buscarPorId($id);
        
        if (!$produto) {
            die("Produto não encontrado!");
        }
        
        include __DIR__ . '/../views/admin/editarProduto.php';
    }
    
    // ADMIN: Processa edição
    public function editarProdutoSalvar() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        $id = $_POST['id'] ?? 0;
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $imagem = $_POST['imagem'] ?? null;
        $estoque = $_POST['estoque'] ?? null;
        
        if (empty($nome) || empty($preco)) {
            die("Nome e preço são obrigatórios! <a href='/admin/produtos/editar?id=$id'>Voltar</a>");
        }
        
        if ($this->model->editar($id, $nome, $descricao, $preco, $imagem, $estoque)) {
            header("Location: /admin/produtos?msg=editado");
        } else {
            die("Erro ao editar produto!");
        }
        exit;
    }
    
    // ADMIN: Deletar produto
    public function deletarProduto($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        if ($this->model->deletar($id)) {
            header("Location: /admin/produtos?msg=deletado");
        } else {
            die("Erro ao deletar produto!");
        }
        exit;
    }
}
?>