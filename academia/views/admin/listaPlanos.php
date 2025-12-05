<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Gerenciar Planos</title>
    <style>
        :root {
            --azul: #007bff;
            --verde: #a6ff00;
            --branco: #ffffff;
            --shadow: 0 8px 32px rgba(0,0,0,0.25);
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
            min-height: 100vh;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--verde);
            font-weight: 900;
            margin-bottom: 30px;
            text-align: center;
        }

        .msg {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .msg.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .btn-novo {
            display: inline-block;
            margin-bottom: 20px;
            padding: 12px 24px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-novo:hover {
            background: #218838;
            transform: scale(1.05);
        }

        table {
            border-collapse: collapse;
            width: 95%;
            max-width: 1200px;
            background: var(--branco);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
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

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-edit {
            background: #ffc107;
            color: #000;
        }

        .btn-edit:hover {
            background: #e0a800;
            transform: scale(1.05);
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: scale(1.05);
        }

        .btn-back {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 22px;
            border-radius: 30px;
            background: #6c757d;
            color: white;
            font-weight: bold;
            text-decoration: none;
            box-shadow: var(--shadow);
            transition: 0.3s;
        }

        .btn-back:hover {
            background: #5a6268;
            transform: scale(1.05);
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .badge-ativo {
            background: #28a745;
            color: white;
        }

        .badge-inativo {
            background: #dc3545;
            color: white;
        }

        .beneficios {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>

<h1>💪 Gerenciar Planos</h1>

<?php if (isset($_GET['msg'])): ?>
    <div class="msg success">
        <?php 
            if ($_GET['msg'] === 'cadastrado') echo '✅ Plano cadastrado com sucesso!';
            if ($_GET['msg'] === 'editado') echo '✅ Plano editado com sucesso!';
            if ($_GET['msg'] === 'deletado') echo '✅ Plano deletado com sucesso!';
        ?>
    </div>
<?php endif; ?>

<a href="/admin/planos/novo" class="btn-novo">➕ Novo Plano</a>

<table>
    <tr>
        <th>Título</th>
        <th>Valor/Mês</th>
        <th>Duração</th>
        <th>Benefícios</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>

    <?php if (empty($planos)): ?>
        <tr>
            <td colspan="6" style="text-align: center; padding: 30px;">Nenhum plano cadastrado</td>
        </tr>
    <?php else: ?>
        <?php foreach ($planos as $plano): ?>
        <tr>
            <td><strong><?= htmlspecialchars($plano['titulo']) ?></strong></td>
            <td>R$ <?= number_format($plano['valor'], 2, ',', '.') ?></td>
            <td><?= ucfirst($plano['duracao'] ?? 'mensal') ?></td>
            <td class="beneficios" title="<?= htmlspecialchars($plano['beneficios']) ?>">
                <?= htmlspecialchars(substr($plano['beneficios'], 0, 60)) ?>...
            </td>
            <td>
                <span class="badge <?= $plano['ativo'] ? 'badge-ativo' : 'badge-inativo' ?>">
                    <?= $plano['ativo'] ? 'Ativo' : 'Inativo' ?>
                </span>
            </td>
            <td>
                <div class="actions">
                    <a href="/admin/planos/editar?id=<?= $plano['id'] ?>" class="btn btn-edit">✏️ Editar</a>
                    <a href="/admin/planos/deletar?id=<?= $plano['id'] ?>" 
                       class="btn btn-delete" 
                       onclick="return confirm('⚠️ Tem certeza que deseja excluir o plano <?= htmlspecialchars($plano['titulo']) ?>?')">
                       🗑️ Excluir
                    </a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>

</table>

<a href="/adm.html" class="btn-back">← Voltar ao Painel</a>

</body>
</html>