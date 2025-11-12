<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Usuários</title>
</head>
<body>

<h1>Lista de Usuários</h1>

<table border="1" cellpadding="6">
<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Email</th>
    <th>Tipo</th>
</tr>

<?php foreach ($usuarios as $user): ?>
<tr>
    <td><?= $user['id'] ?></td>
    <td><?= $user['nome'] ?></td>
    <td><?= $user['email'] ?></td>
    <td><?= $user['tipo'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<br>
<a href="/adm.html">Voltar</a>

</body>
</html>
