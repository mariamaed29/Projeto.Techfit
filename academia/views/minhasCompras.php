<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>Minhas Compras</title>
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
        }

        h1 {
            text-align: center;
            color: #a6ff00;
            margin-bottom: 40px;
            font-weight: 900;
            font-size: 2.5rem;
        }

        .compra-card {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid #007bff;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .compra-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(166, 255, 0, 0.3);
            border-color: #a6ff00;
        }

        .compra-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }

        .pedido-numero {
            font-size: 1.3rem;
            font-weight: bold;
            color: #a6ff00;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .badge-confirmada {
            background: #28a745;
            color: white;
        }

        .badge-cancelada {
            background: #dc3545;
            color: white;
        }

        .badge-pendente {
            background: #ffc107;
            color: #000;
        }

        .produto-info {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-bottom: 20px;
        }

        .produto-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #007bff;
        }

        .produto-detalhes {
            flex: 1;
        }

        .produto-nome {
            font-size: 1.3rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 10px;
        }

        .compra-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .info-item {
            background: rgba(0, 123, 255, 0.1);
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #007bff;
        }

        .info-label {
            font-size: 0.85rem;
            color: #aaa;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: bold;
            color: #fff;
        }

        .valor-total {
            background: rgba(166, 255, 0, 0.2);
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #a6ff00;
            margin-top: 15px;
            text-align: center;
        }

        .valor-total-label {
            font-size: 0.9rem;
            color: #aaa;
        }

        .valor-total-numero {
            font-size: 1.8rem;
            font-weight: bold;
            color: #a6ff00;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 20px;
            color: #444;
        }

        .btn-voltar, .btn-loja {
            display: inline-block;
            margin: 10px;
            padding: 12px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-voltar:hover, .btn-loja:hover {
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
    </style>
</head>
<body>

<div class="container">
    <h1><i class="fa-solid fa-shopping-bag"></i> Minhas Compras</h1>

    <?php if (empty($vendas)): ?>
        <div class="empty-state">
            <i class="fa-solid fa-shopping-cart"></i>
            <h3>Você ainda não realizou nenhuma compra</h3>
            <p>Confira nossos produtos e faça seu primeiro pedido!</p>
            <a href="/loja.html" class="btn-loja">
                <i class="fa-solid fa-store"></i> Ir para Loja
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($vendas as $venda): ?>
            <div class="compra-card">
                <div class="compra-header">
                    <div class="pedido-numero">
                        <i class="fa-solid fa-receipt"></i> 
                        Pedido #<?= str_pad($venda['id'], 6, '0', STR_PAD_LEFT) ?>
                    </div>
                    <span class="badge badge-<?= $venda['status'] ?>">
                        <?= ucfirst($venda['status']) ?>
                    </span>
                </div>

                <div class="produto-info">
                    <?php if (!empty($venda['produto_imagem'])): ?>
                        <img src="<?= htmlspecialchars($venda['produto_imagem']) ?>" alt="<?= htmlspecialchars($venda['produto_nome']) ?>" class="produto-img">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/100" alt="Produto" class="produto-img">
                    <?php endif; ?>
                    
                    <div class="produto-detalhes">
                        <div class="produto-nome"><?= htmlspecialchars($venda['produto_nome']) ?></div>
                        <div style="color: #aaa;">
                            <i class="fa-solid fa-calendar"></i> 
                            <?= date('d/m/Y às H:i', strtotime($venda['data_venda'])) ?>
                        </div>
                    </div>
                </div>

                <div class="compra-info">
                    <div class="info-item">
                        <div class="info-label">Quantidade</div>
                        <div class="info-value"><?= $venda['quantidade'] ?> un</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Valor Unitário</div>
                        <div class="info-value">R$ <?= number_format($venda['valor_unitario'], 2, ',', '.') ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Forma de Pagamento</div>
                        <div class="info-value">
                            <?php
                                $formas = [
                                    'cartao_credito' => 'Cartão de Crédito',
                                    'cartao_debito' => 'Cartão de Débito',
                                    'pix' => 'PIX',
                                    'dinheiro' => 'Dinheiro'
                                ];
                                echo $formas[$venda['forma_pagamento']] ?? ucfirst($venda['forma_pagamento']);
                            ?>
                        </div>
                    </div>

                    <?php if (!empty($venda['cartao_mascarado'])): ?>
                    <div class="info-item">
                        <div class="info-label">Cartão</div>
                        <div class="info-value"><?= htmlspecialchars($venda['cartao_mascarado']) ?></div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="valor-total">
                    <div class="valor-total-label">VALOR TOTAL</div>
                    <div class="valor-total-numero">
                        R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 30px;">
        <a href="../.../public/loja.html" class="btn-loja">
            <i class="fa-solid fa-store"></i> Continuar Comprando
        </a>
        <a href="../../public/pág.inicial.html" class="btn-voltar">
            <i class="fa-solid fa-home"></i> Voltar para Home
        </a>
    </div>
</div>

</body>
</html>