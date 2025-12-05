<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>Assinatura Confirmada</title>
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .sucesso-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 50px;
            border-radius: 20px;
            border: 2px solid #28a745;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: #fff;
        }

        .icone-sucesso {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 20px;
            animation: bounce 1s;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        h1 {
            color: #a6ff00;
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 900;
        }

        .detalhes {
            background: rgba(166, 255, 0, 0.1);
            padding: 25px;
            border-radius: 12px;
            margin: 30px 0;
            border: 1px solid #a6ff00;
            text-align: left;
        }

        .detalhes h3 {
            color: #a6ff00;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .detalhes p {
            margin: 10px 0;
            font-size: 1.1rem;
            color: #fff;
        }

        .detalhes strong {
            color: #a6ff00;
        }

        .btn-home {
            display: inline-block;
            margin-top: 30px;
            padding: 14px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-home:hover {
            background: #a6ff00;
            color: #000;
            transform: scale(1.05);
        }

        .info-adicional {
            margin-top: 20px;
            padding: 15px;
            background: rgba(0, 123, 255, 0.1);
            border-radius: 8px;
            border: 1px solid #007bff;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>

<div class="sucesso-container">
    <div class="icone-sucesso">
        <i class="fa-solid fa-circle-check"></i>
    </div>

    <h1>Assinatura Confirmada!</h1>
    <p style="font-size: 1.2rem; margin-bottom: 30px;">
        Parabéns! Sua assinatura foi processada com sucesso.
    </p>

    <div class="detalhes">
        <h3>📋 Detalhes da Assinatura</h3>
        <p><strong>Nome:</strong> <?= htmlspecialchars($assinatura['nome']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($assinatura['email']) ?></p>
        <p><strong>Plano:</strong> <?= htmlspecialchars($assinatura['plano_titulo']) ?></p>
        <p><strong>Valor:</strong> R$ <?= number_format($assinatura['plano_valor'], 2, ',', '.') ?>/mês</p>
        <p><strong>Vencimento:</strong> <?= date('d/m/Y', strtotime($assinatura['data_vencimento'])) ?></p>
        <p><strong>Status:</strong> <span style="color: #28a745; font-weight: bold;">ATIVA</span></p>
    </div>

    <div class="info-adicional">
        <p><i class="fa-solid fa-envelope"></i> Enviamos um email de confirmação para <strong><?= htmlspecialchars($assinatura['email']) ?></strong></p>
        <p style="margin-top: 10px;"><i class="fa-solid fa-info-circle"></i> Você receberá lembretes antes do vencimento</p>
    </div>

    <a href="/página.inicial.html" class="btn-home">
        <i class="fa-solid fa-house"></i> Voltar para Home
    </a>
</div>

</body>
</html>