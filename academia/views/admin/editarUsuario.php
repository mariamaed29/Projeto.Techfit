<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Editar Produto</title></head>
<body>

<h1>Editar Produto</h1>
<form action="/admin/usuarios" method="post">
    <input type="hidden" name="id" value="<?= $usuarios['id'] ?>">

    Nome: <input name="nome" value="<?= $usuarios['nome'] ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= $usuarios['email'] ?>" required><br><br>
    Sennha: <textarea name="senha"><?= $usuarios['senha'] ?><br><br>
    <button type="submit">Salvar</button>
</form>
<br>
<a href="/admin/usuarios">Voltar</a>

</body>
</html>
