<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

// Exibe erros em desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../controllers/',
        __DIR__ . '/../models/',
        __DIR__ . '/../core/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

// Raiz
if ($uri === "/") {
    header("Location: /Login.html");
    exit;
}

// Login
if ($uri === "/login" && $method === "POST") {
    $controller = new UserController();
    $controller->login();
}

// Cadastro
if ($uri === "/cadastro" && $method === "POST") {
    $controller = new UserController();
    $controller->cadastro();
}

// Logout
if ($uri === "/logout") {
    $controller = new UserController();
    $controller->logout();
}

// API Produtos
if ($uri === "/api/produtos") {
    $controller = new ProductController();
    $controller->listarJson();
}

// Rotas Admin
if (strpos($uri, '/admin') === 0) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
        http_response_code(403);
        die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
    }
    
    if ($uri === "/admin/usuarios") {
        $controller = new AdminController();
        $controller->listarUsuarios();
        exit;
    }
    
    if ($uri === "/admin/usuarios/deletar" && isset($_GET['id'])) {
        $controller = new AdminController();
        $controller->deletarUsuario($_GET['id']);
    }
    
    if ($uri === "/admin/produtos") {
        $controller = new ProductController();
        $controller->listar();
        exit;
    }
    
    if ($uri === "/admin/produtos/novo") {
        $controller = new ProductController();
        $controller->novo();
        exit;
    }
    
    if ($uri === "/admin/produtos/criar" && $method === "POST") {
        $controller = new ProductController();
        $controller->criar();
    }
    
    if ($uri === "/admin/produtos/editar" && isset($_GET['id'])) {
        $controller = new ProductController();
        $controller->editarForm($_GET['id']);
        exit;
    }
    
    if ($uri === "/admin/produtos/salvar" && $method === "POST") {
        $controller = new ProductController();
        $controller->editarSalvar();
    }
    
    if ($uri === "/admin/produtos/deletar" && isset($_GET['id'])) {
        $controller = new ProductController();
        $controller->deletar($_GET['id']);
    }
}

// 404
http_response_code(404);
echo "<h1>404 - Página não encontrada</h1>";
echo "<p>Rota: <strong>{$uri}</strong></p>";
echo "<a href='/'>Voltar</a>";