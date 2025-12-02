<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Editar Plano</title>
    <style>
        :root {
            --azul: #007bff;
            --verde: #a6ff00;
            --branco: #ffffff;
        }

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
        }

        h1 {
            font-size: 2.5rem;
            color: var(--verde);
            font-weight: 900;
            margin-bottom: 30px;
            text-align: center;
        }

        .erro {
            max-width: 600px;
            width: 100%;
            background: #f8d7da;
            color: #721c24;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        form {
            width: 100%;
            max-width: 600px;
            background: var(--branco);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        }

        label {
            font-weight: bold;
            color: #000;
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 2px solid var(--azul);
            margin-bottom: 18px;
            font-size: 1rem;
            outline: none;
            background: #f7f7f7;
        }

        textarea {
            height: 110px;
            resize: vertical;
        }

        input:focus, textarea:focus {
            border-color: var(--verde);
            background: #ffffff;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: var(--azul);
            color: var(--branco);
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: var(--verde);
            color: #000;
            transform: scale(1.03);
        }

        .btn-voltar {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 22px;
            border-radius: 30px;
            background: #ff4d4d;
            color: var(--branco);
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-voltar:hover {
            background: #e60000;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<h1>✏️ Editar Plano</h1>

<?php if (isset($_SESSION['erro'])): ?>
    <div class="erro">
        ❌ <?= htmlspecialchars($_SESSION['erro']) ?>
    </div>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<form action="/admin/planos/salvar" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id']) ?>">

    <label for="titulo">Título *</label>
    <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($produto['titulo']) ?>" required>

    <label for="valor">Valor (R$) *</label>
    <input type="number" id="valor" name="valor" step="0.01" min="0.01" value="<?= htmlspecialchars($produto['valor']) ?>" required>

    <label for="beneficio">Benefícios *</label>
    <textarea id="beneficio" name="beneficio" required><?= htmlspecialchars($produto['beneficios']) ?></textarea>

    <button type="submit">💾 Salvar Alterações</button>
</form>

<a href="/admin/planos" class="btn-voltar">⬅️ Voltar</a>

</body>
</html>