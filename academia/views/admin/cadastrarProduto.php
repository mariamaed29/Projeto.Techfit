<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Cadastrar Produto</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Roboto, sans-serif;
        }

        body {
            background: #1d1d1dc2;
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 10px;
            min-height: 100vh;
        }

        h1 {
            font-size: 2.5rem;
            color: #a6ff00;
            font-weight: 900;
            margin-bottom: 30px;
            text-align: center;
        }

        form {
            width: 100%;
            max-width: 600px;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        }

        form label {
            font-weight: bold;
            color: #000;
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 2px solid #007bff;
            margin-bottom: 18px;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
            background: #f7f7f7;
        }

        form textarea {
            min-height: 100px;
            resize: vertical;
        }

        form input:focus,
        form textarea:focus {
            border-color: #a6ff00;
            background: #ffffff;
        }

        form button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #007bff;
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        form button:hover {
            background: #a6ff00;
            color: #000;
            transform: scale(1.03);
        }

        a {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 22px;
            border-radius: 30px;
            background: #6c757d;
            color: #ffffff;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }

        a:hover {
            background: #5a6268;
            transform: scale(1.05);
        }

        .info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<h1>➕ Cadastrar Produto</h1>

<form action="/admin/produtos/salvar" method="post">
    <label for="nome">Nome do Produto: *</label>
    <input type="text" id="nome" name="nome" required placeholder="Ex: Whey Protein 1kg">

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao" placeholder="Descrição detalhada do produto"></textarea>

    <label for="preco">Preço (R$): *</label>
    <input type="number" id="preco" name="preco" step="0.01" required placeholder="0.00">

    <label for="imagem">URL da Imagem:</label>
    <input type="url" id="imagem" name="imagem" placeholder="https://exemplo.com/imagem.jpg">

    <label for="estoque">Quantidade em Estoque:</label>
    <input type="number" id="estoque" name="estoque" value="0" min="0" placeholder="0">

    <div class="info">
        💡 Campos marcados com * são obrigatórios
    </div>

    <button type="submit">💾 Salvar Produto</button>
</form>

<a href="/admin/produtos">← Voltar</a>

</body>
</html>