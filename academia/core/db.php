<?php
$host = "127.0.0.1";
$user = "root";
$pass = "senaisp"; // sua senha
$dbname = "academia";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
