<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

session_start();

// Pega a URL
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = explode('/', $url);

// Rota principal
$controller = $url[0] ?? 'home';
$action = $url[1] ?? 'index';
$param = $url[2] ?? null;

// Rotas da Loja/Vendas
if ($controller === 'comprar') {
    require_once __DIR__ . '/controllers/VendaController.php';
    $ctrl = new VendaController();
    
    if ($action === 'index') {
        $ctrl->exibirFormulario();
    } elseif ($action === 'processar') {
        $ctrl->processar();
    } elseif ($action === 'sucesso') {
        $ctrl->sucesso();
    }
    exit;
}

if ($controller === 'compra') {
    require_once __DIR__ . '/controllers/VendaController.php';
    $ctrl = new VendaController();
    
    if ($action === 'sucesso') {
        $ctrl->sucesso();
    }
    exit;
}

if ($controller === 'minhas-compras') {
    require_once __DIR__ . '/controllers/VendaController.php';
    $ctrl = new VendaController();
    $ctrl->minhasCompras();
    exit;
}

// Rotas de Assinatura
if ($controller === 'assinar') {
    require_once __DIR__ . '/controllers/AssinaturaController.php';
    $ctrl = new AssinaturaController();
    
    if ($action === 'index') {
        $ctrl->exibirFormulario();
    } elseif ($action === 'processar') {
        $ctrl->processar();
    }
    exit;
}

if ($controller === 'assinatura') {
    require_once __DIR__ . '/controllers/AssinaturaController.php';
    $ctrl = new AssinaturaController();
    
    if ($action === 'sucesso') {
        $ctrl->sucesso();
    }
    exit;
}

if ($controller === 'minhas-assinaturas') {
    require_once __DIR__ . '/controllers/AssinaturaController.php';
    $ctrl = new AssinaturaController();
    $ctrl->minhasAssinaturas();
    exit;
}

// Rotas de Login/Cadastro
if ($controller === 'login') {
    require_once __DIR__ . '/controllers/UserController.php';
    $ctrl = new UserController();
    $ctrl->login();
    exit;
}

if ($controller === 'cadastro') {
    require_once __DIR__ . '/controllers/UserController.php';
    $ctrl = new UserController();
    $ctrl->cadastro();
    exit;
}

if ($controller === 'logout') {
    require_once __DIR__ . '/controllers/UserController.php';
    $ctrl = new UserController();
    $ctrl->logout();
    exit;
}

// Rotas Admin
if ($controller === 'admin') {
    
    // Admin - Usuários
    if ($action === 'usuarios') {
        require_once __DIR__ . '/controllers/AdminController.php';
        $ctrl = new AdminController();
        
        if ($param === 'editar') {
            $ctrl->editarUsuarioForm($_GET['id']);
        } elseif ($param === 'salvar') {
            $ctrl->editarUsuarioSalvar();
        } elseif ($param === 'deletar') {
            $ctrl->deletarUsuario($_GET['id']);
        } else {
            $ctrl->listarUsuarios();
        }
    }
    
    // Admin - Produtos
    elseif ($action === 'produtos') {
        require_once __DIR__ . '/controllers/ProdutoController.php';
        $ctrl = new ProdutoController();
        
        if ($param === 'novo') {
            $ctrl->cadastrarProdutoForm();
        } elseif ($param === 'salvar') {
            $ctrl->cadastrarProdutoSalvar();
        } elseif ($param === 'editar') {
            $ctrl->editarProdutoForm($_GET['id']);
        } elseif ($param === 'deletar') {
            $ctrl->deletarProduto($_GET['id']);
        } else {
            $ctrl->listarProdutos();
        }
    }
    
    // Admin - Planos
    elseif ($action === 'planos') {
        require_once __DIR__ . '/controllers/PlanoController.php';
        $ctrl = new PlanoController();
        
        if ($param === 'novo') {
            $ctrl->cadastrarPlanoForm();
        } elseif ($param === 'salvar') {
            $ctrl->cadastrarPlanoSalvar();
        } elseif ($param === 'editar') {
            $ctrl->editarPlanoForm($_GET['id']);
        } elseif ($param === 'deletar') {
            $ctrl->deletarPlano($_GET['id']);
        } else {
            $ctrl->listarPlanos();
        }
    }
    
    // Admin - Vendas ⭐ ROTA ATUALIZADA
    elseif ($action === 'vendas') {
        require_once __DIR__ . '/controllers/VendaController.php';
        $ctrl = new VendaController();
        
        if ($param === 'cancelar') {
            $ctrl->cancelarVenda();
        } elseif ($param === 'status') {
            $ctrl->atualizarStatus();
        } else {
            $ctrl->listarVendas();
        }
    }
    
    // Admin - Assinaturas
    elseif ($action === 'assinaturas') {
        require_once __DIR__ . '/controllers/AssinaturaController.php';
        $ctrl = new AssinaturaController();
        
        if ($param === 'cancelar') {
            $ctrl->cancelarAssinatura($_GET['id']);
        } elseif ($param === 'renovar') {
            $ctrl->renovarAssinatura($_GET['id']);
        } else {
            $ctrl->listarAssinaturas();
        }
    }
    
    exit;
}

// API
if ($controller === 'api') {
    if ($action === 'produtos') {
        require_once __DIR__ . '/controllers/ProdutoController.php';
        $ctrl = new ProdutoController();
        $ctrl->listarProdutosAPI();
    } elseif ($action === 'planos') {
        require_once __DIR__ . '/controllers/PlanoController.php';
        $ctrl = new PlanoController();
        $ctrl->listarPlanosAPI();
    }
    exit;
}

// Página não encontrada
http_response_code(404);
echo "<!DOCTYPE html>
<html>
<head>
    <title>404 - Página não encontrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1d1d1d;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            text-align: center;
        }
        h1 {
            font-size: 6rem;
            margin: 0;
            color: #a6ff00;
        }
        p {
            font-size: 1.5rem;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class='error-container'>
        <h1>404</h1>
        <p>Página não encontrada</p>
        <p>Rota: <code>$controller/$action</code></p>
        <a href='/'>← Voltar para Home</a>
    </div>
</body>
</html>";