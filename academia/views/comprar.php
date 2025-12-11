<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>Finalizar Compra</title>
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .compra-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            border: 2px solid #007bff;
            max-width: 900px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        h1 {
            color: #a6ff00;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 900;
        }

        .produto-info {
            background: rgba(166, 255, 0, 0.1);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            border: 1px solid #a6ff00;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .produto-imagem {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
        }

        .produto-detalhes {
            flex: 1;
            color: #fff;
        }

        .produto-nome {
            font-size: 1.5rem;
            font-weight: bold;
            color: #a6ff00;
            margin-bottom: 10px;
        }

        .produto-preco {
            font-size: 1.8rem;
            color: #007bff;
            font-weight: bold;
        }

        form {
            color: #fff;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h3 {
            color: #007bff;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #007bff;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 1rem;
        }

        input::placeholder {
            color: #aaa;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #a6ff00;
            background: rgba(255, 255, 255, 0.15);
        }

        .quantidade-control {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 15px 0;
        }

        .quantidade-control button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #007bff;
            background: rgba(0, 123, 255, 0.2);
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .quantidade-control button:hover {
            background: #007bff;
            transform: scale(1.1);
        }

        .quantidade-control input {
            width: 80px;
            text-align: center;
            margin: 0;
        }

        .total-container {
            background: rgba(0, 123, 255, 0.2);
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            border: 2px solid #007bff;
        }

        .total-label {
            font-size: 1.2rem;
            color: #aaa;
        }

        .total-valor {
            font-size: 2rem;
            color: #a6ff00;
            font-weight: bold;
        }

        button[type="submit"] {
            width: 100%;
            padding: 16px;
            margin-top: 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button[type="submit"]:hover {
            background: #a6ff00;
            color: #000;
            transform: scale(1.05);
        }

        .btn-voltar {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-voltar:hover {
            background: #5a6268;
            transform: scale(1.05);
        }

        select option {
            background: #2d2d2d;
            color: #fff;
        }

        .estoque-info {
            color: #ffc107;
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="compra-container">
    <h1><i class="fa-solid fa-shopping-cart"></i> Finalizar Compra</h1>

    <div class="produto-info">
        <?php if ($produto['imagem']): ?>
            <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="produto-imagem">
        <?php else: ?>
            <img src="https://via.placeholder.com/120" alt="Produto" class="produto-imagem">
        <?php endif; ?>
        
        <div class="produto-detalhes">
            <div class="produto-nome"><?= htmlspecialchars($produto['nome']) ?></div>
            <div class="produto-preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></div>
            <div class="estoque-info">
                <i class="fa-solid fa-box"></i> <?= $produto['estoque'] ?> unidades disponíveis
            </div>
        </div>
    </div>

    <form action="/comprar/processar" method="post" id="formCompra">
        <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">
        <input type="hidden" name="preco_unitario" id="preco_unitario" value="<?= $produto['preco'] ?>">
        
        <div class="form-section">
            <h3><i class="fa-solid fa-user"></i> Dados Pessoais</h3>
            <input type="text" name="nome" placeholder="Nome completo" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="telefone" placeholder="Telefone" required>
            <input type="text" name="cpf" placeholder="CPF" maxlength="14" required>
        </div>

        <div class="form-section">
            <h3><i class="fa-solid fa-box"></i> Quantidade</h3>
            <div class="quantidade-control">
                <button type="button" onclick="diminuir()"><i class="fa-solid fa-minus"></i></button>
                <input type="number" name="quantidade" id="quantidade" value="1" min="1" max="<?= $produto['estoque'] ?>" readonly>
                <button type="button" onclick="aumentar()"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>

        <div class="form-section">
            <h3><i class="fa-solid fa-credit-card"></i> Forma de Pagamento</h3>
            <select name="forma_pagamento" id="forma_pagamento" required onchange="toggleCartao()">
                <option value="cartao_credito">Cartão de Crédito</option>
                <option value="cartao_debito">Cartão de Débito</option>
                <option value="pix">PIX</option>
                <option value="dinheiro">Dinheiro</option>
            </select>

            <div id="dadosCartao">
                <input type="text" name="cartao" id="cartao" placeholder="Número do Cartão" maxlength="19">
                <input type="text" name="digito" placeholder="CVV" maxlength="4">
                <input type="month" name="validade" placeholder="Validade (MM/AA)">
            </div>
        </div>

        <div class="total-container">
            <div class="total-label">Total a Pagar:</div>
            <div class="total-valor" id="totalValor">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></div>
        </div>

        <button type="submit">
            <i class="fa-solid fa-check-circle"></i> Confirmar Compra
        </button>
    </form>

    <center><a href="/loja.html" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i> Voltar para Loja</a></center>
</div>

<script>
const maxEstoque = <?= $produto['estoque'] ?>;
const precoUnitario = parseFloat(<?= $produto['preco'] ?>);

// Máscara para CPF
document.querySelector('input[name="cpf"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = value;
});

// Máscara para cartão
const cartaoInput = document.getElementById('cartao');
if (cartaoInput) {
    cartaoInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        e.target.value = value;
    });
}

// Controle de quantidade
function aumentar() {
    const input = document.getElementById('quantidade');
    const atual = parseInt(input.value);
    if (atual < maxEstoque) {
        input.value = atual + 1;
        atualizarTotal();
    }
}

function diminuir() {
    const input = document.getElementById('quantidade');
    const atual = parseInt(input.value);
    if (atual > 1) {
        input.value = atual - 1;
        atualizarTotal();
    }
}

function atualizarTotal() {
    const quantidade = parseInt(document.getElementById('quantidade').value);
    const total = precoUnitario * quantidade;
    document.getElementById('totalValor').textContent = 
        'R$ ' + total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Toggle campos do cartão
function toggleCartao() {
    const forma = document.getElementById('forma_pagamento').value;
    const dadosCartao = document.getElementById('dadosCartao');
    const cartaoInput = document.getElementById('cartao');
    
    if (forma === 'cartao_credito' || forma === 'cartao_debito') {
        dadosCartao.style.display = 'block';
        cartaoInput.required = true;
    } else {
        dadosCartao.style.display = 'none';
        cartaoInput.required = false;
    }
}

toggleCartao();
</script>

</body>
</html>