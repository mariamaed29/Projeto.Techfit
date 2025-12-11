<?php
class RelatorioModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function usuariosPorMes() {
        $sql = "SELECT MONTH(data_cadastro) AS mes, COUNT(*) AS total
                FROM usuarios
                GROUP BY MONTH(data_cadastro)";
        $result = $this->conn->query($sql);

        $dados = [];
        while ($row = $result->fetch_assoc()) {
            $dados[] = $row;
        }
        return $dados;
    }
}
