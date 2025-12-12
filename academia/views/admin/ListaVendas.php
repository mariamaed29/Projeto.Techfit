<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Gerenciar Vendas - Admin</title>
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

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            width: 95%;
            max-width: 1400px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--branco);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: var(--shadow);
        }

        .stat-valor {
            font-size: 2rem;
            font-weight: bold;
            color: var(--azul);
        }

        .stat-label {
            color: #666;
            margin-top: 5px;
        }

        .filters {
            width: 95%;
            max-width: 1400px;
            background: var(--branco);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filters select, .filters input {
            padding: 10px 15px;
            border: 2px solid var(--azul);
            border-radius: 8px;
            font-size: 1rem;
            background: #f7f7f7;
        }

        .filters button {
            padding: 10px 20px;
            background: var(--azul);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .filters button:hover {
            background: var(--verde);
            color: #000;
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

        .produto-mini {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .produto-mini img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: bold;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-status {
            background: #17a2b8;
            color: white;
        }

        .btn-status:hover {
            background: #138496;
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

        .btn-detalhes {
            background: #6c757d;
            color: white;
        }

        .btn-detalhes:hover {
            background: #5a6268;
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

        .badge-confirmada {
            background: #28a745;
            color: white;
        }

        .badge-pendente {
            background: #ffc107;
            color: #000;
        }

        .badge-cancelada {
            background: #dc3545;
            color: white;
        }

        .badge-entregue {
            background: #17a2b8;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-content h3 {
            margin-bottom: 20px;
            color: #333;
        }

        .modal-content select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid var(--azul);
            border-radius: 8px;
            font-size: 1rem;
        }

        .modal-content button {
            margin: 5px;
        }

        .detalhes-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }

        .detalhe-item {
            padding: 10px;
            background: #f7f7f7;
            border-radius: 6px;
        }

        .detalhe-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 3px;
        }

        .detalhe-valor {
            font-weight: bold;
            color: #333;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #ddd;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            background: var(--branco);
            border: 1px solid var(--azul);
            border-radius: 6px;
            text-decoration: none;
            color: var(--azul);
            font-weight: bold;
        }

        .pagination .active {
            background: var(--azul);
            color: white;
        }

        .pagination a:hover {
            background: var(--verde);
            color: #000;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<h1>🛒 Gerenciar Vendas</h1>

<?php if (isset($_GET['msg'])): ?>
    <div class="msg success">
        <?php 
            if ($_GET['msg'] === 'cancelada') echo '✅ Venda cancelada com sucesso!';
            if ($_GET['msg'] === 'atualizada') echo '✅ Status atualizado com sucesso!';
        ?>
    </div>
<?php endif; ?>

<!-- Estatísticas -->
<div class="stats">
    <?php
        $totalVendas = count($vendas);
        $totalFaturamento = array_sum(array_column($vendas, 'valor_total'));
        $vendasConfirmadas = count(array_filter($vendas, fn($v) => $v['status'] === 'confirmada'));
        $vendasEntregues = count(array_filter($vendas, fn($v) => $v['status'] === 'entregue'));
        $vendasCanceladas = count(array_filter($vendas, fn($v) => $v['status'] === 'cancelada'));
    ?>
    <div class="stat-card">
        <div class="stat-valor"><?= $totalVendas ?></div>
        <div class="stat-label">Total de Vendas</div>
    </div>
    <div class="stat-card">
        <div class="stat-valor">R$ <?= number_format($totalFaturamento, 2, ',', '.') ?></div>
        <div class="stat-label">Faturamento Total</div>
    </div>
    <div class="stat-card">
        <div class="stat-valor"><?= $vendasConfirmadas ?></div>
        <div class="stat-label">Confirmadas</div>
    </div>
    <div class="stat-card">
        <div class="stat-valor"><?= $vendasEntregues ?></div>
        <div class="stat-label">Entregues</div>
    </div>
    <div class="stat-card">
        <div class="stat-valor"><?= $vendasCanceladas ?></div>
        <div class="stat-label">Canceladas</div>
    </div>
</div>

<!-- Filtros -->
<div class="filters">
    <form method="get" action="/admin/vendas" style="display: flex; gap: 15px; flex-wrap: wrap; width: 100%;">
        <select name="status">
            <option value="">Todos os Status</option>
            <option value="pendente">Pendente</option>
            <option value="confirmada">Confirmada</option>
            <option value="entregue">Entregue</option>
            <option value="cancelada">Cancelada</option>
        </select>
        
        <input type="text" name="cliente" placeholder="Buscar por cliente..." value="<?= $_GET['cliente'] ?? '' ?>">
        
        <input type="date" name="data_inicio" placeholder="Data início">
        <input type="date" name="data_fim" placeholder="Data fim">
        
        <button type="submit"><i class="fa-solid fa-search"></i> Filtrar</button>
        <a href="/admin/vendas" class="btn btn-detalhes"><i class="fa-solid fa-rotate-right"></i> Limpar</a>
    </form>
</div>

<!-- Tabela de Vendas -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Cliente</th>
            <th>Qtd</th>
            <th>Valor Total</th>
            <th>Pagamento</th>
            <th>Status</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($vendas)): ?>
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <i class="fa-solid fa-inbox"></i>
                        <h3>Nenhuma venda encontrada</h3>
                        <p>As vendas aparecerão aqui quando forem realizadas</p>
                    </div>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($vendas as $venda): ?>
            <tr>
                <td><strong>#<?= str_pad($venda['id'], 6, '0', STR_PAD_LEFT) ?></strong></td>
                <td>
                    <div class="produto-mini">
                        <?php if (!empty($venda['produto_imagem'])): ?>
                            <img src="<?= htmlspecialchars($venda['produto_imagem']) ?>" alt="Produto">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/50" alt="Produto">
                        <?php endif; ?>
                        <strong><?= htmlspecialchars($venda['produto_nome']) ?></strong>
                    </div>
                </td>
                <td>
                    <div><?= htmlspecialchars($venda['nome_cliente']) ?></div>
                    <small style="color: #666;"><?= htmlspecialchars($venda['email_cliente']) ?></small>
                </td>
                <td><?= $venda['quantidade'] ?></td>
                <td><strong>R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?></strong></td>
                <td><?php
                    $formas = [
                        'cartao_credito' => 'C. Crédito',
                        'cartao_debito' => 'C. Débito',
                        'pix' => 'PIX',
                        'dinheiro' => 'Dinheiro'
                    ];
                    echo $formas[$venda['forma_pagamento']] ?? ucfirst($venda['forma_pagamento']);
                ?></td>
                <td>
                    <span class="badge badge-<?= $venda['status'] ?>">
                        <?= ucfirst($venda['status']) ?>
                    </span>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($venda['data_venda'])) ?></td>
                <td>
                    <div class="actions">
                        <button class="btn btn-detalhes" onclick="abrirDetalhes(<?= htmlspecialchars(json_encode($venda)) ?>)">
                            <i class="fa-solid fa-eye"></i> Ver
                        </button>
                        
                        <?php if ($venda['status'] !== 'cancelada'): ?>
                            <button class="btn btn-status" onclick="abrirModalStatus(<?= $venda['id'] ?>, '<?= $venda['status'] ?>')">
                                <i class="fa-solid fa-edit"></i> Status
                            </button>
                        <?php endif; ?>
                        
                        <?php if ($venda['status'] === 'confirmada' || $venda['status'] === 'pendente'): ?>
                            <a href="/admin/vendas/cancelar?id=<?= $venda['id'] ?>" 
                               class="btn btn-cancelar"
                               onclick="return confirm('⚠️ Tem certeza que deseja cancelar esta venda?')">
                               <i class="fa-solid fa-times"></i> Cancelar
                            </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="/adm.html" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Voltar ao Painel</a>

<!-- Modal de Status -->
<div id="modalStatus" class="modal">
    <div class="modal-content">
        <h3><i class="fa-solid fa-edit"></i> Atualizar Status</h3>
        <form id="formStatus" method="post">
            <select name="status" id="selectStatus" required>
                <option value="pendente">Pendente</option>
                <option value="confirmada">Confirmada</option>
                <option value="entregue">Entregue</option>
                <option value="cancelada">Cancelada</option>
            </select>
            <button type="submit" class="btn btn-status">💾 Salvar</button>
            <button type="button" class="btn btn-cancelar" onclick="fecharModal('modalStatus')">✖ Fechar</button>
        </form>
    </div>
</div>

<!-- Modal de Detalhes -->
<div id="modalDetalhes" class="modal">
    <div class="modal-content">
        <h3><i class="fa-solid fa-receipt"></i> Detalhes da Venda</h3>
        <div id="conteudoDetalhes"></div>
        <button type="button" class="btn btn-detalhes" onclick="fecharModal('modalDetalhes')" style="width: 100%; margin-top: 15px;">
            ✖ Fechar
        </button>
    </div>
</div>

<script>
function abrirModalStatus(id, statusAtual) {
    document.getElementById('formStatus').action = '/admin/vendas/status/' + id;
    document.getElementById('selectStatus').value = statusAtual;
    document.getElementById('modalStatus').style.display = 'flex';
}

function abrirDetalhes(venda) {
    const formas = {
        'cartao_credito': 'Cartão de Crédito',
        'cartao_debito': 'Cartão de Débito',
        'pix': 'PIX',
        'dinheiro': 'Dinheiro'
    };
    
    const html = `
        <div class="detalhes-grid">
            <div class="detalhe-item">
                <div class="detalhe-label">Pedido</div>
                <div class="detalhe-valor">#${String(venda.id).padStart(6, '0')}</div>
            </div>
            <div class="detalhe-item">
                <div class="detalhe-label">Status</div>
                <div class="detalhe-valor"><span class="badge badge-${venda.status}">${venda.status.charAt(0).toUpperCase() + venda.status.slice(1)}</span></div>
            </div>
            <div class="detalhe-item" style="grid-column: 1 / -1;">
                <div class="detalhe-label">Produto</div>
                <div class="detalhe-valor">${venda.produto_nome}</div>
            </div>
            <div class="detalhe-item">
                <div class="detalhe-label">Cliente</div>
                <div class="detalhe-valor">${venda.nome_cliente}</div>
            </div>
            <div class="detalhe-item">
                <div class="detalhe-label">Email</div>
                <div class="detalhe-valor">${venda.email_cliente}</div>
            </div>
            <div class="detalhe-item">
                <div class="detalhe-label">Telefone</div>
                <div class="detalhe-valor">${venda.telefone_cliente || 'Não informado'}</div>
            </div>
            <div class="detalhe-item">
                <div class="detalhe-label">CPF</div>
                <div class="detalhe-valor">${venda.cpf_cliente}</div>
            </div>
            <div class="detalhe-item">
                <div class="detalhe-label">Quantidade</div>
                <div class="detalhe-valor">${venda.quantidade} un</div>
            </div>
            <div class="detalhe-item">
                <div class="detalhe-label">Valor Unitário</div>
                <div class="detalhe-valor">R$ ${parseFloat(venda.valor_unitario).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</div>
            </div>
            <div class="detalhe-item">
                <div class="detalhe-label">Forma de Pagamento</div>
                <div class="detalhe-valor">${formas[venda.forma_pagamento] || venda.forma_pagamento}</div>
            </div>
            ${venda.cartao_mascarado ? `
            <div class="detalhe-item">
                <div class="detalhe-label">Cartão</div>
                <div class="detalhe-valor">${venda.cartao_mascarado}</div>
            </div>` : ''}
            <div class="detalhe-item" style="grid-column: 1 / -1; background: #d4edda; border: 2px solid #28a745;">
                <div class="detalhe-label">VALOR TOTAL</div>
                <div class="detalhe-valor" style="font-size: 1.5rem; color: #28a745;">R$ ${parseFloat(venda.valor_total).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</div>
            </div>
            <div class="detalhe-item" style="grid-column: 1 / -1;">
                <div class="detalhe-label">Data da Venda</div>
                <div class="detalhe-valor">${new Date(venda.data_venda).toLocaleString('pt-BR')}</div>
            </div>
        </div>
    `;
    
    document.getElementById('conteudoDetalhes').innerHTML = html;
    document.getElementById('modalDetalhes').style.display = 'flex';
}

function fecharModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}
</script>

</body>
</html>