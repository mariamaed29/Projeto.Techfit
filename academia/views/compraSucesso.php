<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>Compra Confirmada</title>
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .sucesso-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 50px;
            border-radius: 20px;
            border: 2px solid #28a745;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: #fff;
        }

        .icone-sucesso {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 20px;
            animation: bounce 1s;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        h1 {
            color: #a6ff00;
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 900;
        }

        .pedido-numero {
            background: rgba(0, 123, 255, 0.2);
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            border: 1px solid #007bff;
            font-size: 1.2rem;
        }

        .detalhes {
            background: rgba(166, 255, 0, 0.1);
            padding: 25px;
            border-radius: 12px;
            margin: 30px 0;
            border: 1px solid #a6ff00;
            text-align: left;
        }

        .detalhes h3 {
            color: #a6ff00;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .detalhe-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .detalhe-item:last-child {
            border-bottom: none;
        }

        .detalhe-label {
            color: #aaa;
        }

        .detalhe-valor {
            color: #fff;
            font-weight: bold;
        }

        .total-item {
            font-size: 1.3rem;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #007bff;
        }

        .total-item .detalhe-valor {
            color: #a6ff00;
            font-size: 1.5rem;
        }

        .btn-home {
            display: inline-block;
            margin: 15px 10px;
            padding: 14px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-home:hover {
            background: #a6ff00;
            color: #000;
            transform: scale(1.05);
        }

        .btn-loja {
            background: #28a745;
        }

        .btn-loja:hover {
            background: #218838;
            color: #fff;
        }

        .info-adicional {
            margin-top: 20px;
            padding: 15px;
            background: rgba(0, 123, 255, 0.1);
            border-radius: 8px;
            border: 1px solid #007bff;
            font-size: 0.95rem;
        }

        .produto-comprado {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .produto-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .produto-info-texto {
            flex: 1;
            text-align: left;
        }

        .produto-nome {
            font-size: 1.2rem;
            color: #a6ff00;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="sucesso-container">
    <div class="icone-sucesso">
        <i class="fa-solid fa-circle-check"></i>
    </div>

    <h1>Compra Confirmada!</h1>
    <p style="font-size: 1.2rem; margin-bottom: 20px;">
        Parabéns! Sua compra foi processada com sucesso.
    </p>

    <div class="pedido-numero">
        <strong>Pedido Nº:</strong> #<?= str_pad($venda['id'], 6, '0', STR_PAD_LEFT) ?>
    </div>

    <div class="detalhes">
        <h3><i class="fa-solid fa-receipt"></i> Detalhes da Compra</h3>
        
        <div class="produto-comprado">
            <?php if ($venda['produto_imagem']): ?>
                <img src="<?= htmlspecialchars($venda['produto_imagem']) ?>" alt="Produto" class="produto-img">
            <?php else: ?>
                <img src="https://via.placeholder.com/80" alt="Produto" class="produto-img">
            <?php endif; ?>
            <div class="produto-info-texto">
                <div class="produto-nome"><?= htmlspecialchars($venda['produto_nome']) ?></div>
                <div style="color: #aaa;">Quantidade: <?= $venda['quantidade'] ?></div>
            </div>
        </div>

        <div class="detalhe-item">
            <span class="detalhe-label">Nome:</span>
            <span class="detalhe-valor"><?= htmlspecialchars($venda['nome_cliente']) ?></span>
        </div>

        <div class="detalhe-item">
            <span class="detalhe-label">Email:</span>
            <span class="detalhe-valor"><?= htmlspecialchars($venda['email_cliente']) ?></span>
        </div>

        <div class="detalhe-item">
            <span class="detalhe-label">Valor Unitário:</span>
            <span class="detalhe-valor">R$ <?= number_format($venda['valor_unitario'], 2, ',', '.') ?></span>
        </div>

        <div class="detalhe-item">
            <span class="detalhe-label">Quantidade:</span>
            <span class="detalhe-valor"><?= $venda['quantidade'] ?></span>
        </div>

        <div class="detalhe-item">
            <span class="detalhe-label">Forma de Pagamento:</span>
            <span class="detalhe-valor">
                <?php
                    $formas = [
                        'cartao_credito' => 'Cartão de Crédito',
                        'cartao_debito' => 'Cartão de Débito',
                        'pix' => 'PIX',
                        'dinheiro' => 'Dinheiro'
                    ];
                    echo $formas[$venda['forma_pagamento']] ?? ucfirst($venda['forma_pagamento']);
                ?>
            </span>
        </div>

        <?php if ($venda['cartao_mascarado']): ?>
        <div class="detalhe-item">
            <span class="detalhe-label">Cartão:</span>
            <span class="detalhe-valor"><?= htmlspecialchars($venda['cartao_mascarado']) ?></span>
        </div>
        <?php endif; ?>

        <div class="detalhe-item total-item">
            <span class="detalhe-label">TOTAL:</span>
            <span class="detalhe-valor">R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?></span>
        </div>
    </div>

    <div class="info-adicional">
        <p><i class="fa-solid fa-envelope"></i> Enviamos um email de confirmação para <strong><?= htmlspecialchars($venda['email_cliente']) ?></strong></p>
        <p style="margin-top: 10px;"><i class="fa-solid fa-info-circle"></i> Você pode retirar seu produto na academia</p>
    </div>

    <div>
        <a href="/loja.html" class="btn-home btn-loja">
            <i class="fa-solid fa-store"></i> Voltar para Loja
        </a>
        <a href="/pág.inicial.html" class="btn-home">
            <i class="fa-solid fa-house"></i> Ir para Home
        </a>
    </div>
</div>

</body>
</html>