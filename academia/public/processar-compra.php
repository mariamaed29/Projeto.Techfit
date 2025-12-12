<?php
session_start();
require_once __DIR__ . '/../models/ProdutoModel.php';
require_once __DIR__ . '/../models/PedidoModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: loja.php');
    exit;
}

// Recebe os dados do formulário
$produto_id = isset($_POST['produto_id']) ? (int)$_POST['produto_id'] : 0;
$quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;
$forma_pagamento = isset($_POST['forma_pagamento']) ? $_POST['forma_pagamento'] : '';
$endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : '';
$cep = isset($_POST['cep']) ? trim($_POST['cep']) : '';

// Validações básicas
if ($produto_id <= 0 || $quantidade <= 0 || empty($forma_pagamento) || empty($endereco) || empty($cep)) {
    die("Dados inválidos! Por favor, preencha todos os campos. <a href='javascript:history.back()'>Voltar</a>");
}

// Busca o produto usando o Model
$produtoModel = new ProdutoModel();
$produto = $produtoModel->buscarPorId($produto_id);

if (!$produto) {
    die("Produto não encontrado! <a href='loja.php'>Voltar para a loja</a>");
}

// Verifica estoque disponível
if ($produto['estoque'] < $quantidade) {
    die("Estoque insuficiente! Disponível: {$produto['estoque']} unidades. <a href='javascript:history.back()'>Voltar</a>");
}

// Calcula o total
$total = $produto['preco'] * $quantidade;

// Cria o pedido no banco de dados
$pedidoModel = new PedidoModel();
$resultado = $pedidoModel->criarPedido(
    $produto_id,
    $produto['nome'],
    $quantidade,
    $produto['preco'],
    $forma_pagamento,
    $endereco,
    $cep
);

if (!$resultado['success']) {
    die("Erro ao processar pedido! Tente novamente. <a href='javascript:history.back()'>Voltar</a>");
}

// Atualiza o estoque do produto
$produtoModel->atualizarEstoque($produto_id, $quantidade);

$pedido_id = $resultado['pedido_id'];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Confirmada - Pedido #<?php echo $pedido_id; ?></title>
    <style>
        body {
            background: #1a1a1a;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .sucesso-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background: #2a2a2a;
            border-radius: 10px;
            border: 2px solid #b8ff00;
            text-align: center;
        }
        
        .icone-sucesso {
            font-size: 80px;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        h1 {
            color: #b8ff00;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .pedido-numero {
            color: #00a8ff;
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .detalhes-pedido {
            background: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }
        
        .detalhes-pedido h3 {
            color: #b8ff00;
            margin-bottom: 15px;
        }
        
        .detalhes-pedido p {
            color: #ccc;
            margin: 10px 0;
            line-height: 1.6;
        }
        
        .detalhes-pedido strong {
            color: #00a8ff;
        }
        
        .total {
            font-size: 28px;
            color: #b8ff00;
            margin: 20px 0;
            font-weight: bold;
            padding: 15px;
            background: #1a1a1a;
            border-radius: 8px;
        }
        
        .btn-voltar {
            display: inline-block;
            padding: 15px 40px;
            background: #00a8ff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .btn-voltar:hover {
            background: #0088cc;
            transform: scale(1.05);
        }
        
        .aviso {
            color: #ccc;
            font-size: 14px;
            margin-top: 20px;
            padding: 15px;
            background: #1a1a1a;
            border-radius: 5px;
            border-left: 3px solid #00a8ff;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #ffa500;
            color: white;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="sucesso-container">
        <div class="icone-sucesso">✅</div>
        <h1>Compra Realizada com Sucesso!</h1>
        <div class="pedido-numero">Pedido #<?php echo str_pad($pedido_id, 6, '0', STR_PAD_LEFT); ?></div>
        <div class="status-badge">⏳ Aguardando Pagamento</div>
        <p style="color: #ccc; margin-top: 15px;">Seu pedido foi registrado e será processado após a confirmação do pagamento.</p>
        
        <div class="detalhes-pedido">
            <h3>Detalhes do Pedido</h3>
            <p><strong>Produto:</strong> <?php echo htmlspecialchars($produto['nome']); ?></p>
            <p><strong>Quantidade:</strong> <?php echo $quantidade; ?></p>
            <p><strong>Preço Unitário:</strong> R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            <p><strong>Forma de Pagamento:</strong> 
                <?php 
                    $formas = [
                        'cartao' => 'Cartão de Crédito',
                        'boleto' => 'Boleto Bancário',
                        'pix' => 'PIX'
                    ];
                    echo $formas[$forma_pagamento] ?? ucfirst($forma_pagamento);
                ?>
            </p>
            <p><strong>Endereço de Entrega:</strong> <?php echo htmlspecialchars($endereco); ?></p>
            <p><strong>CEP:</strong> <?php echo htmlspecialchars($cep); ?></p>
        </div>
        
        <div class="total">
            Total: R$ <?php echo number_format($total, 2, ',', '.'); ?>
        </div>
        
        <div class="aviso">
            📧 Você receberá um email com os detalhes do pedido e instruções de pagamento em breve.<br>
            💾 Este pedido foi salvo no sistema com o ID #<?php echo $pedido_id; ?>
        </div>
        
        <a href="loja.html" class="btn-voltar">← Voltar para a Loja</a>
    </div>
</body>
</html>