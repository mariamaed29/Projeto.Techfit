<?php
require_once __DIR__ . "/../models/UserModel.php";
session_start();

class UserController {

    public function login() {
        $model = new UserModel();
        $user = $model->login($_POST['email'], $_POST['senha']);

        if ($user) {
            $_SESSION['user'] = $user;

            if ($user['tipo'] == 'admin') {
                header("Location: /adm.html");
            } else {
                header("Location: /pág.inicial.html");
            }

        } else {
            echo "Email ou senha incorretos.";
        }
    }

    public function cadastro() {
        $model = new UserModel();
        $model->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha']);
        header("Location: /Login.html");
    }
}
