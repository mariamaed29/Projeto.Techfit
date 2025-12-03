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
            --verde: #a6ff00;
            --branco: #ffffff;
            --vermelho: #dc3545;
            --amarelo: #ffc107;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Roboto, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            padding: 50px 20px;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--verde);
            font-weight: 900;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Mensagens */
        .alert {
            max-width: 1200px;
            margin: 0 auto 20px;
            padding: 15px 20px;
            border-radius: 8px;
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
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Barra de ações */
        .actions-bar {
            max-width: 1200px;
            margin: 0 auto 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            display: inline-block;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--azul);
            color: var(--branco);
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,123,255,0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: var(--branco);
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-warning {
            background: var(--amarelo);
            color: #000;
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .btn-danger {
            background: var(--vermelho);
            color: var(--branco);
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        /* Container da tabela */
        .table-container {
            max-width: 1200px;
            margin: 0 auto;
            background: var(--branco);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 15px;
            font-size: 1rem;
        }

        th {
            background-color: var(--azul);
            color: var(--branco);
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #dee2e6;
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        .valor {
            color: var(--azul);
            font-weight: bold;
            font-size: 1.1rem;
        }

        .beneficios {
            max-width: 300px;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        /* Estado vazio */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                font-size: 0.85rem;
            }

            th, td {
                padding: 10px;
            }

            .actions-bar {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<h1>📋 Gerenciar Planos</h1>

<?php if (isset($_SESSION['sucesso'])): ?>
    <div class="alert alert-success">
        ✅ <?= htmlspecialchars($_SESSION['sucesso'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <?php unset($_SESSION['sucesso']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['erro'])): ?>
    <div class="alert alert-error">
        ❌ <?= htmlspecialchars($_SESSION['erro'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<div class="actions-bar">
    <a href="/admin/planos/novo" class="btn btn-primary">➕ Novo Plano</a>
    <a href="/adm.html" class="btn btn-secondary">⬅️ Voltar ao Painel</a>
</div>

<?php if (empty($planos)): ?>
    <div class="table-container">
        <div class="empty-state">
            <div style="font-size: 4rem;">📦</div>
            <h3>Nenhum plano cadastrado</h3>
            <p style="margin: 15px 0;">Comece criando o primeiro plano da academia!</p>
            <a href="/admin/planos/novo" class="btn btn-primary">Criar Primeiro Plano</a>
        </div>
    </div>
<?php else: ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Valor</th>
                    <th>Benefícios</th>
                    <th style="text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($planos as $p): ?>
                <tr>
                    <td><strong>#<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                    <td><strong><?= htmlspecialchars($p['titulo'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                    <td class="valor">R$ <?= number_format($p['valor'], 2, ',', '.') ?></td>
                    <td class="beneficios">
                        <?php 
                        // ✅ CORRIGIDO: agora usa 'beneficios' (plural)
                        $texto = htmlspecialchars($p['beneficios'] ?? '', ENT_QUOTES, 'UTF-8');
                        echo mb_substr($texto, 0, 80);
                        echo strlen($texto) > 80 ? '...' : '';
                        ?>
                    </td>
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
    </div>
<?php endif; ?>

</body>
</html>

<!-- ============================================ -->
<!-- 3. CORREÇÃO: listaProdutos.php -->
<!-- ============================================ -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Gerenciar Produtos - TecFit</title>
    <style>  
        /* (Mesmo CSS da listaPlanos.php) */
        :root {
            --azul: #007bff;
            --verde: #a6ff00;
            --branco: #ffffff;
            --vermelho: #dc3545;
            --amarelo: #ffc107;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Roboto, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            padding: 50px 20px;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--verde);
            font-weight: 900;
            margin-bottom: 20px;
            text-align: center;
        }

        .alert {
            max-width: 1200px;
            margin: 0 auto 20px;
            padding: 15px 20px;
            border-radius: 8px;
            font-weight: 500;
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

        .actions-bar {
            max-width: 1200px;
            margin: 0 auto 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            display: inline-block;
            cursor: pointer;
            border: none;
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

        .btn-warning {
            background: var(--amarelo);
            color: #000;
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .btn-danger {
            background: var(--vermelho);
            color: var(--branco);
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .table-container {
            max-width: 1200px;
            margin: 0 auto;
            background: var(--branco);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 15px;
        }

        th {
            background-color: var(--azul);
            color: var(--branco);
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        tbody tr {
            border-bottom: 1px solid #dee2e6;
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .produto-imagem {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .valor {
            color: var(--azul);
            font-weight: bold;
            font-size: 1.1rem;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
    </style>
</head>
<body>

<h1>🛒 Gerenciar Produtos</h1>

<?php if (isset($_SESSION['sucesso'])): ?>
    <div class="alert alert-success">
        ✅ <?= htmlspecialchars($_SESSION['sucesso'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <?php unset($_SESSION['sucesso']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['erro'])): ?>
    <div class="alert alert-error">
        ❌ <?= htmlspecialchars($_SESSION['erro'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<div class="actions-bar">
    <a href="/admin/produtos/novo" class="btn btn-primary">➕ Novo Produto</a>
    <a href="/adm.html" class="btn btn-secondary">⬅️ Voltar ao Painel</a>
</div>

<?php if (empty($produtos)): ?>
    <div class="table-container">
        <div class="empty-state">
            <div style="font-size: 4rem;">📦</div>
            <h3>Nenhum produto cadastrado</h3>
            <p style="margin: 15px 0;">Adicione produtos para a loja da academia!</p>
            <a href="/admin/produtos/novo" class="btn btn-primary">Criar Primeiro Produto</a>
        </div>
    </div>
<?php else: ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Descrição</th>
                    <th style="text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><strong>#<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                    <td>
                        <?php if (!empty($p['imagem'])): ?>
                            <img src="<?= htmlspecialchars($p['imagem'], ENT_QUOTES, 'UTF-8') ?>" 
                                 alt="<?= htmlspecialchars($p['nome'], ENT_QUOTES, 'UTF-8') ?>" 
                                 class="produto-imagem"
                                 onerror="this.src='https://via.placeholder.com/60?text=Sem+Img'">
                        <?php else: ?>
                            <div style="width:60px;height:60px;background:#ddd;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.8rem;">📦</div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($p['nome'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                    <td class="valor">R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                    <td style="max-width:300px;color:#666;font-size:0.9rem;">
                        <?php 
                        $desc = htmlspecialchars($p['descricao'] ?? '', ENT_QUOTES, 'UTF-8');
                        echo mb_substr($desc, 0, 60);
                        echo strlen($desc) > 60 ? '...' : '';
                        ?>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="/admin/produtos/editar?id=<?= $p['id'] ?>" 
                               class="btn btn-warning">
                                ✏️ Editar
                            </a>
                            <a href="/admin/produtos/deletar?id=<?= $p['id'] ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('⚠️ Excluir <?= htmlspecialchars($p['nome'], ENT_QUOTES, 'UTF-8') ?>?');">
                                🗑️ Deletar
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

</body>
</html>