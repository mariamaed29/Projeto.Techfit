<?php
require_once __DIR__ . '/../Model/RelatorioModel.php';
require_once __DIR__ . '/../core/db.php';

class RelatorioController {

    public function graficoUsuarios() {
        header("Content-Type: application/json");
        
        $db = Database::getInstance()->getConnection();
        $model = new RelatorioModel($db);
        
        echo json_encode($model->usuariosPorMes());
    }
}
