<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Gerenciar Planos</title>
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

        /* Mensagens */
        .mensagem {
            max-width: 900px;
            width: 100%;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .sucesso {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .erro {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Botões */
        .btn {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            margin: 10px 5px;
        }

        .btn-novo {
            background: var(--azul);
            color: var(--branco);
        }

        .btn-voltar {
            background: #6c757d;
            color: var(--branco);
        }

        .btn:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        /* Tabela */
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 900px;
            background: var(--branco);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            margin-top: 20px;
        }

        th, td {
            text-align: left;
            padding: 12px 14px;
            font-size: 1rem;
        }

        th {
            background-color: var(--azul);
            color: var(--branco);
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        tr:hover td {
            background: var(--verde);
            color: #000;
            transition: 0.2s;
        }

        .acoes a {
            padding: 6px 12px;
            margin: 0 3px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-editar {
            background: #ffc107;
            color: #000;
        }

        .btn-deletar {
            background: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>

<h1>📋 Gerenciar Planos</h1>

<!-- Mensagens de sucesso/erro -->
<?php if (isset($_SESSION['sucesso'])): ?>
    <div class="mensagem sucesso">
        ✅ <?= htmlspecialchars($_SESSION['sucesso']) ?>
    </div>
    <?php unset($_SESSION['sucesso']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['erro'])): ?>
    <div class="mensagem erro">
        ❌ <?= htmlspecialchars($_SESSION['erro']) ?>
    </div>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<!-- Botões de ação -->
<div>
    <a href="/admin/planos/novo" class="btn btn-novo">➕ Novo Plano</a>
    <a href="/adm.html" class="btn btn-voltar">⬅️ Voltar</a>
</div>

<!-- Tabela de planos -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Valor</th>
            <th>Benefícios</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($planos)): ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px; color: #666;">
                    Nenhum plano cadastrado ainda.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($planos as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['id']) ?></td>
                <td><strong><?= htmlspecialchars($p['titulo']) ?></strong></td>
                <td>R$ <?= number_format($p['valor'], 2, ',', '.') ?></td>
                <td><?= htmlspecialchars(substr($p['beneficio'], 0, 50)) ?><?= strlen($p['beneficio']) > 50 ? '...' : '' ?></td>
                <td class="acoes">
                    <a href="/admin/planos/editar?id=<?= $p['id'] ?>" class="btn-editar">✏️ Editar</a>
                    <a href="/admin/planos/deletar?id=<?= $p['id'] ?>" 
                       class="btn-deletar"
                       onclick="return confirm('Tem certeza que deseja excluir este plano?')">
                        🗑️ Deletar
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>