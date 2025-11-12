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

if ($uri == "/admin/produtos") {
    require_once __DIR__ . "/../controllers/ProductController.php";
    $c = new ProductController();
    $c->listar();
}

if ($uri == "/admin/produtos/novo") {
    require_once __DIR__ . "/../controllers/ProductController.php";
    $c = new ProductController();
    $c->novo();
}

if ($uri == "/admin/produtos/criar") {
    require_once __DIR__ . "/../controllers/ProductController.php";
    $c = new ProductController();
    $c->criar();
}

if ($uri == "/admin/produtos/editar") {
    require_once __DIR__ . "/../controllers/ProductController.php";
    $c = new ProductController();
    $c->editarForm($_GET['id']);
}

if ($uri == "/admin/produtos/salvar") {
    require_once __DIR__ . "/../controllers/ProductController.php";
    $c = new ProductController();
    $c->editarSalvar();
}

if ($uri == "/admin/produtos/deletar") {
    require_once __DIR__ . "/../controllers/ProductController.php";
    $c = new ProductController();
    $c->deletar($_GET['id']);
}
if ($uri == "/api/produtos") {
    require_once __DIR__ . "/../models/ProductModel.php";
    $m = new ProductModel();
    header('Content-Type: application/json');
    echo json_encode($m->buscarTodos());
    exit;
}
