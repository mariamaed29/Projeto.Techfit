<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>Minhas Assinaturas</title>
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
        }

        h1 {
            text-align: center;
            color: #a6ff00;
            margin-bottom: 40px;
            font-weight: 900;
            font-size: 2.5rem;
        }

        .assinatura-card {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid #007bff;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .assinatura-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(166, 255, 0, 0.3);
            border-color: #a6ff00;
        }

        .assinatura-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }

        .plano-titulo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #a6ff00;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .badge-ativa {
            background: #28a745;
            color: white;
        }

        .badge-vencida {
            background: #ffc107;
            color: #000;
        }

        .badge-cancelada {
            background: #dc3545;
            color: white;
        }

        .assinatura-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            background: rgba(0, 123, 255, 0.1);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #007bff;
        }

        .info-label {
            font-size: 0.85rem;
            color: #aaa;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: bold;
            color: #fff;
        }

        .beneficios {
            background: rgba(166, 255, 0, 0.1);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #a6ff00;
            margin-top: 15px;
        }

        .beneficios h4 {
            color: #a6ff00;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .beneficios ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .beneficios li {
            padding: 5px 0;
            color: #fff;
        }

        .beneficios li:before {
            content: "✓ ";
            color: #a6ff00;
            font-weight: bold;
            margin-right: 8px;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 20px;
            color: #444;
        }

        .btn-voltar {
            display: inline-block;
            margin: 30px auto;
            padding: 12px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
            text-align: center;
        }

        .btn-voltar:hover {
            background: #a6ff00;
            color: #000;
            transform: scale(1.05);
        }

        .alerta-vencimento {
            background: #fff3cd;
            border: 2px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alerta-vencimento i {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
      <header>
    <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top shadow-sm">
      <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="pág.inicial.html">
          <img src="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" alt="Logo" width="40">
          <strong>TechFit</strong>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item"><a class="nav-link" href="pág.inicial.html"><i class="fa-solid fa-house"></i> Início</a></li>
            <li class="nav-item"><a class="nav-link" href="../../Planos.html"><i class="fa-solid fa-weight-hanging"></i> Planos</a></li>
            <li class="nav-item"><a class="nav-link" href="treinos.html"><i class="fa-solid fa-person-running"></i> Treinos</a></li>
            <li class="nav-item"><a class="nav-link" href="loja.html"><i class="fa-solid fa-cart-shopping"></i> Loja</a></li>
            <li class="nav-item"><a class="nav-link active" href="desafios.html"><i class="fa-solid fa-calendar-days"></i> Desafios</a></li>
            <li class="nav-item"><a class="nav-link" href="/minhas-assinaturas"><i class="fa-solid fa-file-contract"></i> Minhas Assinaturas</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <br>

<div class="container">
    <h1><i class="fa-solid fa-file-contract"></i> Minhas Assinaturas</h1>

    <?php if (empty($assinaturas)): ?>
        <div class="empty-state">
            <i class="fa-solid fa-inbox"></i>
            <h3>Você ainda não possui assinaturas</h3>
            <p>Confira nossos planos e comece a treinar hoje!</p>
            <a href="/Planos.html" class="btn-voltar">Ver Planos Disponíveis</a>
        </div>
    <?php else: ?>
        <?php foreach ($assinaturas as $ass): ?>
            <div class="assinatura-card">
                <div class="assinatura-header">
                    <div class="plano-titulo">
                        <i class="fa-solid fa-dumbbell"></i> 
                        <?= htmlspecialchars($ass['plano_titulo']) ?>
                    </div>
                    <span class="badge badge-<?= $ass['status'] ?>">
                        <?= ucfirst($ass['status']) ?>
                    </span>
                </div>

                <?php if ($ass['status'] === 'vencida'): ?>
                    <div class="alerta-vencimento">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                        <div>
                            <strong>Atenção!</strong> Sua assinatura está vencida. 
                            Entre em contato conosco para renovar.
                        </div>
                    </div>
                <?php endif; ?>

                <div class="assinatura-info">
                    <div class="info-item">
                        <div class="info-label">Valor Mensal</div>
                        <div class="info-value">
                            R$ <?= number_format($ass['plano_valor'], 2, ',', '.') ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Data de Vencimento</div>
                        <div class="info-value">
                            <?php 
                                $vencimento = strtotime($ass['data_vencimento']);
                                $dias_restantes = floor(($vencimento - time()) / (60 * 60 * 24));
                                echo date('d/m/Y', $vencimento);
                                
                                if ($dias_restantes > 0 && $dias_restantes <= 7 && $ass['status'] === 'ativa') {
                                    echo " <small style='color: #ffc107;'>(Vence em {$dias_restantes} dias)</small>";
                                }
                            ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Data de Assinatura</div>
                        <div class="info-value">
                            <?= date('d/m/Y', strtotime($ass['created_at'])) ?>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Cartão</div>
                        <div class="info-value">
                            <?= htmlspecialchars($ass['cartao_mascarado'] ?? '****') ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($ass['beneficios'])): ?>
                    <div class="beneficios">
                        <h4><i class="fa-solid fa-star"></i> Benefícios do Plano</h4>
                        <ul>
                            <?php 
                                $beneficios = explode("\n", $ass['beneficios']);
                                foreach ($beneficios as $beneficio): 
                                    $beneficio = trim($beneficio);
                                    if (!empty($beneficio)):
                            ?>
                                <li><?= htmlspecialchars($beneficio) ?></li>
                            <?php 
                                    endif;
                                endforeach; 
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div style="text-align: center;">
        <a href="../../public/pág.inicial.html" class="btn-voltar">
            <i class="fa-solid fa-home"></i> Voltar para Home
        </a>
    </div>
</div>

</body>
</html>