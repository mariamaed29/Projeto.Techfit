<?php
require_once __DIR__ . '/../core/db.php';

class ProductModel {

    public function buscarTodos() {
        global $conn;
        $sql = "SELECT * FROM produtos ORDER BY id DESC";
        $res = $conn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarPorId($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function criar($nome, $preco, $descricao, $imagem) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO produtos (nome, preco, descricao, imagem) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $nome, $preco, $descricao, $imagem);
        $stmt->execute();
    }

    public function editar($id, $nome, $preco, $descricao, $imagem) {
        global $conn;
        $stmt = $conn->prepare("UPDATE produtos SET nome=?, preco=?, descricao=?, imagem=? WHERE id=?");
        $stmt->bind_param("sdssi", $nome, $preco, $descricao, $imagem, $id);
        $stmt->execute();
    }

    public function deletar($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM produtos WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
