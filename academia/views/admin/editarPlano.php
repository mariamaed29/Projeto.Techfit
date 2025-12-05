<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Editar Plano</title>
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
        form textarea,
        form select {
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
            min-height: 120px;
            resize: vertical;
        }

        form input:focus,
        form textarea:focus,
        form select:focus {
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
    </style>
</head>
<body>

<h1>✏️ Editar Plano</h1>

<form action="/admin/planos/salvar" method="post">
    <input type="hidden" name="id" value="<?= $plano['id'] ?>">

    <label for="titulo">Título do Plano: *</label>
    <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($plano['titulo']) ?>" required>

    <label for="valor">Valor Mensal (R$): *</label>
    <input type="number" id="valor" name="valor" step="0.01" value="<?= $plano['valor'] ?>" required>

    <label for="duracao">Duração:</label>
    <select id="duracao" name="duracao">
        <option value="mensal" <?= ($plano['duracao'] ?? 'mensal') === 'mensal' ? 'selected' : '' ?>>Mensal</option>
        <option value="trimestral" <?= ($plano['duracao'] ?? '') === 'trimestral' ? 'selected' : '' ?>>Trimestral</option>
        <option value="semestral" <?= ($plano['duracao'] ?? '') === 'semestral' ? 'selected' : '' ?>>Semestral</option>
        <option value="anual" <?= ($plano['duracao'] ?? '') === 'anual' ? 'selected' : '' ?>>Anual</option>
    </select>

    <label for="beneficios">Benefícios: *</label>
    <textarea id="beneficios" name="beneficios" required><?= htmlspecialchars($plano['beneficios']) ?></textarea>

    <button type="submit">💾 Salvar Alterações</button>
</form>

<a href="/admin/planos">← Voltar</a>

</body>
</html>