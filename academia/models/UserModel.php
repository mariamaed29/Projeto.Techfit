<?php
require_once __DIR__ . "/../core/db.php";

class UserModel {

    public function login($email, $senha) {
        global $conn;

        $email = $conn->real_escape_string($email);
        $sql = "SELECT * FROM usuarios WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($senha, $user['senha'])) {
                return $user;
            }
        }
        return false;
    }

    public function cadastrar($nome, $email, $senha) {
        global $conn;

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senhaHash')";
        return $conn->query($sql);
    }
    public function buscarTodos() {
    global $conn;
    $result = $conn->query("SELECT id, nome, email, tipo FROM usuarios");
    return $result->fetch_all(MYSQLI_ASSOC);
}

}
