<?php
require_once __DIR__ . '/../models/PlanosModel.php';

class PlanoController {
    private $model;
    
    public function __construct() {
        $this->model = new PlanosModel();
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
        $planos = $this->model->buscarTodos();
        include __DIR__ . '/../views/admin/listaPlanos.php';
    }
    
    public function novo() {
        $this->requireAdmin();
        include __DIR__ . '/../views/admin/novoPlanos.php';
    }
    
    public function criar() {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/planos/novo");
            exit;
        }
        
        // Pega os dados do formulário
        $titulo = trim($_POST['titulo'] ?? '');
        $valor = floatval($_POST['valor'] ?? 0);
        $beneficios = trim($_POST['beneficios'] ?? ''); // CORRIGIDO: era 'beneficio'
        
        // Validações
        if (empty($titulo)) {
            $_SESSION['erro'] = "O título é obrigatório!";
            header("Location: /admin/planos/novo");
            exit;
        }
        
        if ($valor <= 0) {
            $_SESSION['erro'] = "O valor deve ser maior que zero!";
            header("Location: /admin/planos/novo");
            exit;
        }
        
        if (empty($beneficios)) {
            $_SESSION['erro'] = "Os benefícios são obrigatórios!";
            header("Location: /admin/planos/novo");
            exit;
        }
        
        // Tenta criar o plano
        if ($this->model->criar($titulo, $valor, $beneficios)) {
            $_SESSION['sucesso'] = "Plano criado com sucesso!";
            header("Location: /admin/planos");
        } else {
            $_SESSION['erro'] = "Erro ao criar plano!";
            header("Location: /admin/planos/novo");
        }
        exit;
    }
    
    public function editarForm($id) {
        $this->requireAdmin();
        
        // Valida o ID
        if (!is_numeric($id) || $id <= 0) {
            $_SESSION['erro'] = "ID inválido!";
            header("Location: /admin/planos");
            exit;
        }
        
        $plano = $this->model->buscarPorId($id); // CORRIGIDO: era $produto
        
        if (!$plano) {
            $_SESSION['erro'] = "Plano não encontrado!";
            header("Location: /admin/planos");
            exit;
        }
        
        include __DIR__ . '/../views/admin/editarPlanos.php';
    }
    
    public function editarSalvar() {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/planos");
            exit;
        }
        
        // Pega os dados do formulário
        $id = intval($_POST['id'] ?? 0);
        $titulo = trim($_POST['titulo'] ?? '');
        $valor = floatval($_POST['valor'] ?? 0);
        $beneficios = trim($_POST['beneficios'] ?? ''); // CORRIGIDO
        
        // Validações
        if ($id <= 0) {
            $_SESSION['erro'] = "ID inválido!";
            header("Location: /admin/planos");
            exit;
        }
        
        if (empty($titulo)) {
            $_SESSION['erro'] = "O título é obrigatório!";
            header("Location: /admin/planos/editar?id=$id");
            exit;
        }
        
        if ($valor <= 0) {
            $_SESSION['erro'] = "O valor deve ser maior que zero!";
            header("Location: /admin/planos/editar?id=$id");
            exit;
        }
        
        if (empty($beneficios)) {
            $_SESSION['erro'] = "Os benefícios são obrigatórios!";
            header("Location: /admin/planos/editar?id=$id");
            exit;
        }
        
        // Tenta editar o plano
        if ($this->model->editar($id, $titulo, $valor, $beneficios)) {
            $_SESSION['sucesso'] = "Plano editado com sucesso!";
            header("Location: /admin/planos");
        } else {
            $_SESSION['erro'] = "Erro ao editar plano!";
            header("Location: /admin/planos/editar?id=$id");
        }
        exit;
    }
    
    public function deletar($id) {
        $this->requireAdmin();
        
        // Valida o ID
        if (!is_numeric($id) || $id <= 0) {
            $_SESSION['erro'] = "ID inválido!";
            header("Location: /admin/planos");
            exit;
        }
        
        // Tenta deletar o plano
        if ($this->model->deletar($id)) {
            $_SESSION['sucesso'] = "Plano deletado com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao deletar plano!";
        }
        
        header("Location: /admin/planos");
        exit;
    }
    
    public function listarJson() {
        $planos = $this->model->buscarTodos();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($planos, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
?>