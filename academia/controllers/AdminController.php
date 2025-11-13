<?php
require_once __DIR__ . '/../models/UserModel.php';

class AdminController {
    private $model;
    
    public function __construct() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
        $this->model = new UserModel();
    }
    
    public function listarUsuarios() {
        $usuarios = $this->model->buscarTodos();
        include __DIR__ . '/../views/admin/listaUsuarios.php';
    }
    
    public function deletarUsuario($id) {
        if ($this->model->deletar($id)) {
            header("Location: /admin/usuarios?msg=deletado");
        } else {
            die("Erro ao deletar usuário!");
        }
        exit;
    }
}