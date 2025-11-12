<?php
require_once __DIR__ . '/../models/ProductModel.php';
session_start();

class ProductController {

    public function listar() {
        $model = new ProductModel();
        $produtos = $model->buscarTodos();
        include __DIR__ . '/../views/admin/listaProdutos.php';
    }

    public function novo() {
        include __DIR__ . '/../views/admin/novoProduto.php';
    }

    public function criar() {
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $descricao = $_POST['descricao'];
        $imagem = $_POST['imagem'];

        $model = new ProductModel();
        $model->criar($nome, $preco, $descricao, $imagem);

        header("Location: /admin/produtos");
    }

    public function editarForm($id) {
        $model = new ProductModel();
        $produto = $model->buscarPorId($id);
        include __DIR__ . '/../views/admin/editarProduto.php';
    }

    public function editarSalvar() {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $descricao = $_POST['descricao'];
        $imagem = $_POST['imagem'];

        $model = new ProductModel();
        $model->editar($id, $nome, $preco, $descricao, $imagem);

        header("Location: /admin/produtos");
    }

    public function deletar($id) {
        $model = new ProductModel();
        $model->deletar($id);
        header("Location: /admin/produtos");
    }
}
