<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Novo Produto</title></head>
<body>

<h1>Novo Produto</h1>
<form action="/admin/produtos/criar" method="post">
    Nome: <input name="nome" required><br><br>
    Preço: <input type="number" step="0.01" name="preco" required><br><br>
    Descrição: <textarea name="descricao"></textarea><br><br>
    URL da imagem: <input name="imagem"><br><br>
    <button type="submit">Salvar</button>
</form>
<br>
<a href="/admin/produtos">Voltar</a>

</body>
</html>
