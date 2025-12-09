<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Gerenciar Assinaturas</title>
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

        table {
            border-collapse: collapse;
            width: 95%;
            max-width: 1400px;
            background: var(--branco);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        th, td {
            text-align: left;
            padding: 12px 14px;
            font-size: 0.9rem;
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
            font-size: 0.85rem;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-renovar {
            background: #28a745;
            color: white;
        }

        .btn-renovar:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .btn-cancelar {
            background: #dc3545;
            color: white;
        }

        .btn-cancelar:hover {
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

        .badge-ativa {
            background: #28a745;
            color: white;
        }

        .badge-vencida {
            background: #ffc107;
            color: #000;
        }

        .badge-cancelada {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<h1>📋 Gerenciar Assinaturas</h1>

<?php if (isset($_GET['msg'])): ?>
    <div class="msg success">
        <?php 
            if ($_GET['msg'] === 'cancelada') echo '✅ Assinatura cancelada com sucesso!';
            if ($_GET['msg'] === 'renovada') echo '✅ Assinatura renovada com sucesso!';
        ?>
    </div>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Plano</th>
        <th>Valor</th>
        <th>Status</th>
        <th>Vencimento</th>
        <th>Cadastrado em</th>
        <th>Ações</th>
    </tr>

    <?php if (empty($assinaturas)): ?>
        <tr>
            <td colspan="10" style="text-align: center; padding: 30px;">Nenhuma assinatura encontrada</td>
        </tr>
    <?php else: ?>
        <?php foreach ($assinaturas as $ass): ?>
        <tr>
            <td><?= $ass['id'] ?></td>
            <td><?= htmlspecialchars($ass['nome']) ?></td>
            <td><?= htmlspecialchars($ass['email']) ?></td>
            <td><?= htmlspecialchars($ass['telefone']) ?></td>
            <td><strong><?= htmlspecialchars($ass['plano_titulo']) ?></strong></td>
            <td>R$ <?= number_format($ass['plano_valor'], 2, ',', '.') ?></td>
            <td>
                <span class="badge badge-<?= $ass['status'] ?>">
                    <?= ucfirst($ass['status']) ?>
                </span>
            </td>
            <td><?= date('d/m/Y', strtotime($ass['data_vencimento'])) ?></td>
            <td><?= date('d/m/Y', strtotime($ass['created_at'])) ?></td>
            <td>
                <div class="actions">
                    <?php if ($ass['status'] === 'ativa' || $ass['status'] === 'vencida'): ?>
                        <a href="/admin/assinaturas/renovar?id=<?= $ass['id'] ?>" 
                           class="btn btn-renovar"
                           onclick="return confirm('Deseja renovar a assinatura de <?= htmlspecialchars($ass['nome']) ?>?')">
                           🔄 Renovar
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($ass['status'] === 'ativa'): ?>
                        <a href="/admin/assinaturas/cancelar?id=<?= $ass['id'] ?>" 
                           class="btn btn-cancelar"
                           onclick="return confirm('⚠️ Tem certeza que deseja cancelar a assinatura de <?= htmlspecialchars($ass['nome']) ?>?')">
                           ❌ Cancelar
                        </a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>

</table>

<a href="/adm.html" class="btn-back">← Voltar ao Painel</a>

</body>
</html>