<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Produtos</title></head>
<body>

<h1>Gerenciar Produtos</h1>
<a href="/admin/produtos/novo">+ Novo Produto</a><br><br>

<table border="1" cellpadding="6">
<tr><th>ID</th><th>Nome</th><th>Preço</th><th>Descrição</th><th>Imagem</th><th>Ações</th></tr>

<?php foreach ($produtos as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['nome'] ?></td>
    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
    <td><?= $p['descricao'] ?></td>
    <td><img src="<?= $p['imagem'] ?>" width="60"></td>
    <td>
        <a href="/admin/produtos/editar?id=<?= $p['id'] ?>">✏️</a>
        <a href="/admin/produtos/deletar?id=<?= $p['id'] ?>" onclick="return confirm('Excluir produto?')">🗑</a>
    </td>
</tr>
<?php endforeach; ?>

</table>
<br>
<a href="/adm.html">Voltar</a>

</body>
</html>
