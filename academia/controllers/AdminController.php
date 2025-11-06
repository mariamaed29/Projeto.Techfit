<?php
require_once __DIR__ . '/../models/UserModel.php';
session_start();

class AdminController {

    public function listarUsuarios() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado!");
        }

        $model = new UserModel();
        $usuarios = $model->buscarTodos();

        include __DIR__ . '/../views/admin/listaUsuarios.php';
    }
}
