<?php
require_once __DIR__ . '/../models/PlanoModel.php';

class PlanoController {
    private $model;
    
    public function __construct() {
        $this->model = new PlanoModel();
    }
    
    // Exibe página de planos para clientes
    public function exibirPlanos() {
        include __DIR__ . '/../Planos.html';
    }
    
    // API: Retorna todos os planos em JSON
    public function listarPlanosAPI() {
        header('Content-Type: application/json');
        $planos = $this->model->buscarAtivos();
        echo json_encode($planos);
        exit;
    }
    
    // ADMIN: Lista planos para gerenciamento
    public function listarPlanos() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        $planos = $this->model->buscarTodos();
        include __DIR__ . '/../views/admin/listaPlanos.php';
    }
    
    // ADMIN: Formulário de cadastro
    public function cadastrarPlanoForm() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        include __DIR__ . '/../views/admin/cadastrarPlano.php';
    }
    
    // ADMIN: Processa cadastro
    public function cadastrarPlanoSalvar() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/planos/novo");
            exit;
        }
        
        $titulo = $_POST['titulo'] ?? '';
        $valor = $_POST['valor'] ?? 0;
        $beneficios = $_POST['beneficios'] ?? '';
        $duracao = $_POST['duracao'] ?? 'mensal';
        
        if (empty($titulo) || empty($valor)) {
            die("Título e valor são obrigatórios! <a href='/admin/planos/novo'>Voltar</a>");
        }
        
        $resultado = $this->model->cadastrar($titulo, $valor, $beneficios, $duracao);
        
        if ($resultado['success']) {
            header("Location: /admin/planos?msg=cadastrado");
        } else {
            die($resultado['message'] . " <a href='/admin/planos/novo'>Voltar</a>");
        }
        exit;
    }
    
    // ADMIN: Formulário de edição
    public function editarPlanoForm($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        $plano = $this->model->buscarPorId($id);
        
        if (!$plano) {
            die("Plano não encontrado!");
        }
        
        include __DIR__ . '/../views/admin/editarPlano.php';
    }
    
    // ADMIN: Processa edição
    public function editarPlanoSalvar() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        $id = $_POST['id'] ?? 0;
        $titulo = $_POST['titulo'] ?? '';
        $valor = $_POST['valor'] ?? 0;
        $beneficios = $_POST['beneficios'] ?? '';
        $duracao = $_POST['duracao'] ?? 'mensal';
        
        if (empty($titulo) || empty($valor)) {
            die("Título e valor são obrigatórios! <a href='/admin/planos/editar?id=$id'>Voltar</a>");
        }
        
        if ($this->model->editar($id, $titulo, $valor, $beneficios, $duracao)) {
            header("Location: /admin/planos?msg=editado");
        } else {
            die("Erro ao editar plano!");
        }
        exit;
    }
    
    // ADMIN: Deletar plano
    public function deletarPlano($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        
        if ($this->model->deletar($id)) {
            header("Location: /admin/planos?msg=deletado");
        } else {
            die("Erro ao deletar plano!");
        }
        exit;
    }
}
?>