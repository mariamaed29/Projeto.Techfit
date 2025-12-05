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

// ========== RAIZ ==========
if ($uri === "/") {
    header("Location: /Login.html");
    exit;
}

// ========== AUTENTICAÇÃO ==========
if ($uri === "/login" && $method === "POST") {
    $controller = new UserController();
    $controller->login();
}

if ($uri === "/cadastro" && $method === "POST") {
    $controller = new UserController();
    $controller->cadastro();
}

if ($uri === "/logout") {
    $controller = new UserController();
    $controller->logout();
}

// ========== ROTAS PÚBLICAS (CLIENTES) ==========

// Loja
if ($uri === "/loja" || $uri === "/loja.html") {
    $controller = new ProdutoController();
    $controller->exibirLoja();
    exit;
}

// API de Produtos
if ($uri === "/api/produtos") {
    $controller = new ProdutoController();
    $controller->listarProdutosAPI();
    exit;
}

// Planos
if ($uri === "/planos" || $uri === "/Planos.html") {
    $controller = new PlanoController();
    $controller->exibirPlanos();
    exit;
}

// API de Planos
if ($uri === "/api/planos") {
    $controller = new PlanoController();
    $controller->listarPlanosAPI();
    exit;
}

// Assinatura - Formulário
if ($uri === "/assinar" || $uri === "/Assinar.html") {
    $controller = new AssinaturaController();
    $controller->exibirFormulario();
    exit;
}

// Assinatura - Processar
if ($uri === "/Assinar" && $method === "POST") {
    $controller = new AssinaturaController();
    $controller->processar();
    exit;
}

// Assinatura - Sucesso
if ($uri === "/assinatura/sucesso" && isset($_GET['id'])) {
    $controller = new AssinaturaController();
    $controller->sucesso();
    exit;
}

// Minhas Assinaturas (requer login)
if ($uri === "/minhas-assinaturas") {
    $controller = new AssinaturaController();
    $controller->minhasAssinaturas();
    exit;
}

// ========== ROTAS ADMINISTRATIVAS ==========
if (strpos($uri, '/admin') === 0) {
    // Verifica se é admin
    if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
        http_response_code(403);
        die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
    }
    
    // ===== USUÁRIOS =====
    if ($uri === "/admin/usuarios") {
        $controller = new AdminController();
        $controller->listarUsuarios();
        exit;
    }
    
    if ($uri === "/admin/usuarios/editar" && isset($_GET['id'])) {
        $controller = new AdminController();
        $controller->editarUsuarioForm($_GET['id']);
        exit;
    }
    
    if ($uri === "/admin/usuarios/salvar" && $method === "POST") {
        $controller = new AdminController();
        $controller->editarUsuarioSalvar();
        exit;
    }
    
    if ($uri === "/admin/usuarios/deletar" && isset($_GET['id'])) {
        $controller = new AdminController();
        $controller->deletarUsuario($_GET['id']);
        exit;
    }
    
    // ===== PRODUTOS =====
    if ($uri === "/admin/produtos") {
        $controller = new ProdutoController();
        $controller->listarProdutos();
        exit;
    }
    
    if ($uri === "/admin/produtos/novo") {
        $controller = new ProdutoController();
        $controller->cadastrarProdutoForm();
        exit;
    }
    
    if ($uri === "/admin/produtos/salvar" && $method === "POST") {
        $controller = new ProdutoController();
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $controller->editarProdutoSalvar();
        } else {
            $controller->cadastrarProdutoSalvar();
        }
        exit;
    }
    
    if ($uri === "/admin/produtos/editar" && isset($_GET['id'])) {
        $controller = new ProdutoController();
        $controller->editarProdutoForm($_GET['id']);
        exit;
    }
    
    if ($uri === "/admin/produtos/deletar" && isset($_GET['id'])) {
        $controller = new ProdutoController();
        $controller->deletarProduto($_GET['id']);
        exit;
    }
    
    // ===== PLANOS =====
    if ($uri === "/admin/planos") {
        $controller = new PlanoController();
        $controller->listarPlanos();
        exit;
    }
    
    if ($uri === "/admin/planos/novo") {
        $controller = new PlanoController();
        $controller->cadastrarPlanoForm();
        exit;
    }
    
    if ($uri === "/admin/planos/salvar" && $method === "POST") {
        $controller = new PlanoController();
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $controller->editarPlanoSalvar();
        } else {
            $controller->cadastrarPlanoSalvar();
        }
        exit;
    }
    
    if ($uri === "/admin/planos/editar" && isset($_GET['id'])) {
        $controller = new PlanoController();
        $controller->editarPlanoForm($_GET['id']);
        exit;
    }
    
    if ($uri === "/admin/planos/deletar" && isset($_GET['id'])) {
        $controller = new PlanoController();
        $controller->deletarPlano($_GET['id']);
        exit;
    }
    
    // ===== ASSINATURAS =====
    if ($uri === "/admin/assinaturas") {
        $controller = new AssinaturaController();
        $controller->listarAssinaturas();
        exit;
    }
    
    if ($uri === "/admin/assinaturas/cancelar" && isset($_GET['id'])) {
        $controller = new AssinaturaController();
        $controller->cancelarAssinatura($_GET['id']);
        exit;
    }
    
    if ($uri === "/admin/assinaturas/renovar" && isset($_GET['id'])) {
        $controller = new AssinaturaController();
        $controller->renovarAssinatura($_GET['id']);
        exit;
    }
}

// ========== 404 ==========
// Se chegou aqui e não encontrou nenhuma rota, deixa o .htaccess servir arquivos estáticos
// ou retorna 404 se não for arquivo
if (!file_exists(__DIR__ . $uri)) {
    http_response_code(404);
    echo "<h1>404 - Página não encontrada</h1>";
    echo "<p>Rota: <strong>{$uri}</strong></p>";
    echo "<a href='/'>Voltar</a>";
    exit;
}
?>