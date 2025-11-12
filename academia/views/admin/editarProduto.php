<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Editar Produto</title></head>
<body>

<h1>Editar Produto</h1>
<form action="/admin/produtos/salvar" method="post">
    <input type="hidden" name="id" value="<?= $produto['id'] ?>">

    Nome: <input name="nome" value="<?= $produto['nome'] ?>" required><br><br>
    Preço: <input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required><br><br>
    Descrição: <textarea name="descricao"><?= $produto['descricao'] ?></textarea><br><br>
    URL da imagem: <input name="imagem" value="<?= $produto['imagem'] ?>"><br><br>
    <button type="submit">Salvar</button>
</form>
<br>
<a href="/admin/produtos">Voltar</a>

</body>
</html>
