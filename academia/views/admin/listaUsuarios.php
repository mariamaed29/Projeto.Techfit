<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">


<style>  
:root {
  --azul: #007bff;
  --preto: #000000;
  --cinza: #2c2c2c;
  --branco: #ffffff;
  --verde: #a6ff00;
  --radius: 16px;
  --shadow: 0 8px 32px rgba(0,0,0,0.25);
}

/* RESET */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", Roboto, sans-serif;
}

html, body {
  height: 100%;
}

/* FUNDO */
body {
  background: #1d1d1dc2;
  backdrop-filter: blur(10px);
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 50px 10px;
}

/* TÍTULO */
h1 {
  font-size: 2.5rem;
  color: var(--verde);
  font-weight: 900;
  margin-bottom: 30px;
  text-align: center;
}

/* TABELA */
table {
  border-collapse: collapse;
  width: 90%;
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
  background-color: #f1f1f1;
}

tr:hover td {
  background: var(--verde);
  color: var(--preto);
  transition: 0.2s;
}

/* BOTÃO VOLTAR */
a {
  display: inline-block;
  margin-top: 25px;
  padding: 12px 22px;
  border-radius: 30px;
  background: #ff4d4d;
  color: var(--branco);
  font-weight: bold;
  text-decoration: none;
  box-shadow: var(--shadow);
  transition: 0.3s;
}

a:hover {
  background: #e60000;
  transform: scale(1.05);
}

    </style>

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
