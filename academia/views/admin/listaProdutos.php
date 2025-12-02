<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Gerenciar Planos - TecFit</title>
    <style>  
        :root {
            --azul: #007bff;
            --preto: #000000;
            --cinza: #2c2c2c;
            --branco: #ffffff;
            --verde: #a6ff00;
            --vermelho: #dc3545;
            --radius: 16px;
            --shadow: 0 8px 32px rgba(0,0,0,0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Roboto, sans-serif;
        }

        html, body {
            height: 100%;
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
            margin-bottom: 20px;
            text-align: center;
        }

        /* Mensagens de feedback */
        .alert {
            max-width: 900px;
            width: 100%;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            animation: slideIn 0.3s ease;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .actions-bar {
            max-width: 900px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--azul);
            color: var(--branco);
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            color: var(--branco);
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-danger {
            background: var(--vermelho);
            color: var(--branco);
            font-size: 0.9rem;
            padding: 8px 16px;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-warning {
            background: #ffc107;
            color: var(--preto);
            font-size: 0.9rem;
            padding: 8px 16px;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 900px;
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
            background-color: #f8f9fa;
        }

        tr:hover td {
            background: #e9ecef;
            transition: 0.2s;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            table {
                font-size: 0.85rem;
            }
            
            th, td {
                padding: 8px;
            }
            
            .actions-bar {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

<h1>📋 Gerenciar Planos</h1>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        ✅ <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
        ❌ <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="actions-bar">
    <a href="/admin/planos/novo" class="btn btn-primary">➕ Novo Plano</a>
    <a href="/adm.html" class="btn btn-secondary">← Voltar ao Painel</a>
</div>

<?php if (empty($planos)): ?>
    <div class="empty-state">
        <i>📦</i>
        <p>Nenhum plano cadastrado ainda.</p>
        <a href="/admin/planos/novo" class="btn btn-primary" style="margin-top: 15px;">Criar Primeiro Plano</a>
    </div>
<?php else: ?>
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
            <?php foreach ($planos as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><strong><?= htmlspecialchars($p['titulo'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                <td>R$ <?= number_format($p['valor'], 2, ',', '.') ?></td>
                <td><?= htmlspecialchars(mb_substr($p['beneficio'], 0, 50), ENT_QUOTES, 'UTF-8') ?><?= strlen($p['beneficio']) > 50 ? '...' : '' ?></td>
                <td>
                    <div class="action-buttons">
                        <a href="/admin/planos/editar?id=<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>" 
                           class="btn btn-warning"
                           title="Editar plano">
                            ✏️ Editar
                        </a>
                        <a href="/admin/planos/deletar?id=<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>" 
                           class="btn btn-danger"
                           onclick="return confirm('⚠️ Tem certeza que deseja excluir o plano \'<?= htmlspecialchars($p['titulo'], ENT_QUOTES, 'UTF-8') ?>\'?\n\nEsta ação não pode ser desfeita.');"
                           title="Deletar plano">
                            🗑️ Deletar
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>