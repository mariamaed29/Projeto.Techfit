<?php
session_start();
require_once __DIR__ . '/../models/ProdutoModel.php';

// Pega o ID do produto da URL
$produto_id = isset($_GET['produto_id']) ? (int)$_GET['produto_id'] : 0;

if ($produto_id <= 0) {
    header('Location: loja.php');
    exit;
}

// Busca os detalhes do produto usando o Model
$produtoModel = new ProdutoModel();
$produto = $produtoModel->buscarPorId($produto_id);

if (!$produto) {
    echo "Produto não encontrado!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar - <?php echo htmlspecialchars($produto['nome']); ?></title>
    <style>
        body {
            background: #1a1a1a;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .comprar-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background: #2a2a2a;
            border-radius: 10px;
            border: 2px solid #00a8ff;
        }
        
        .produto-detalhes {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .produto-imagem {
            width: 300px;
            height: 300px;
            background: #3a3a3a;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
        }
        
        .produto-info {
            flex: 1;
        }
        
        .produto-info h1 {
            color: #b8ff00;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .produto-info .preco {
            font-size: 32px;
            color: #00a8ff;
            margin: 20px 0;
            font-weight: bold;
        }
        
        .produto-info .descricao {
            color: #ccc;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .form-compra {
            background: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .form-compra h2 {
            color: #b8ff00;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            color: #b8ff00;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            background: #2a2a2a;
            border: 1px solid #444;
            border-radius: 5px;
            color: white;
            font-size: 14px;
            box-sizing: border-box;
        }
        
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #00a8ff;
        }
        
        .botoes {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .btn-confirmar {
            background: #00a8ff;
            color: white;
        }
        
        .btn-confirmar:hover {
            background: #0088cc;
            transform: scale(1.02);
        }
        
        .btn-voltar {
            background: #444;
            color: white;
        }
        
        .btn-voltar:hover {
            background: #555;
        }
        
        @media (max-width: 768px) {
            .produto-detalhes {
                flex-direction: column;
            }
            
            .produto-imagem {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="comprar-container">
        <div class="produto-detalhes">
            <div class="produto-imagem">
                📦
            </div>
            <div class="produto-info">
                <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
                <p class="descricao"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                <div class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
            </div>
        </div>
        
        <form class="form-compra" method="POST" action="processar-compra.php">
            <h2>Finalizar Compra</h2>
            
            <input type="hidden" name="produto_id" value="<?php echo $produto_id; ?>">
            
            <div class="form-group">
                <label>Quantidade:</label>
                <input type="number" name="quantidade" value="1" min="1" required>
            </div>
            
            <div class="form-group">
                <label>Forma de Pagamento:</label>
                <select name="forma_pagamento" required>
                    <option value="">Selecione...</option>
                    <option value="cartao">Cartão de Crédito</option>
                    <option value="boleto">Boleto Bancário</option>
                    <option value="pix">PIX</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Endereço de Entrega:</label>
                <input type="text" name="endereco" required placeholder="Rua, número, complemento">
            </div>
            
            <div class="form-group">
                <label>CEP:</label>
                <input type="text" name="cep" required placeholder="00000-000" maxlength="9">
            </div>
            
            <div class="botoes">
                <button type="button" class="btn btn-voltar" onclick="window.location.href='loja.php'">
                    ← Voltar
                </button>
                <button type="submit" class="btn btn-confirmar">
                    🔒 Confirmar Compra
                </button>
            </div>
        </form>
    </div>
</body>
</html>