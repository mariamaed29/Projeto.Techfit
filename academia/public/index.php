<?php
require_once __DIR__ . '/../controllers/UserController.php';

$controller = new UserController();
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// Se alguém acessar "/", redireciona para Login.html
if ($uri == "/") {
    header("Location: /Login.html");
    exit;
}

if ($uri == "/login" && $_SERVER["REQUEST_METHOD"] == "POST") {
    $controller->login();
    exit;
}

if ($uri == "/cadastro" && $_SERVER["REQUEST_METHOD"] == "POST") {
    $controller->cadastro();
    exit;
}

// Se nenhuma rota bater
echo "Rota não encontrada: $uri";

if ($uri == "/admin/usuarios") {
    require_once __DIR__ . "/../controllers/AdminController.php";
    $admin = new AdminController();
    $admin->listarUsuarios();
    exit;
}

