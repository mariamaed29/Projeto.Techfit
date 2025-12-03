<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Novo Plano - TecFit</title>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Roboto, sans-serif;
        }

        html, body {
            height: 100%;
        }

        body {
            background: #1d1d1dc2;
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 10px;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--verde);
            font-weight: 900;
            margin-bottom: 30px;
            text-align: center;
        }

        .alert {
            max-width: 600px;
            width: 100%;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        form {
            width: 100%;
            max-width: 600px;
            background: var(--branco);
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .form-group {
            margin-bottom: 20px;
        }

        form label {
            font-weight: bold;
            color: var(--preto);
            display: block;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        form label .required {
            color: #dc3545;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 2px solid var(--azul);
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
            background: #f7f7f7;
        }

        form textarea {
            height: 120px;
            resize: vertical;
            font-family: inherit;
        }

        form input:focus,
        form textarea:focus {
            border-color: var(--verde);
            background: #ffffff;
        }

        .helper-text {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: -12px;
            margin-bottom: 18px;
        }

        form button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: var(--azul);
            color: var(--branco);
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        form button:hover {
            background: var(--verde);
            color: var(--preto);
            transform: scale(1.03);
        }

        .btn-voltar {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 22px;
            border-radius: 30px;
            background: #6c757d;
            color: var(--branco);
            font-weight: bold;
            text-decoration: none;
            box-shadow: var(--shadow);
            transition: 0.3s;
        }

        .btn-voltar:hover {
            background: #5a6268;
            transform: scale(1.05);
        }

        .example {
            background: #e7f3ff;
            border-left: 4px solid var(--azul);
            padding: 10px;
            margin-top: 8px;
            border-radius: 4px;
            font-size: 0.9rem;
            color: #004085;
        }
    </style>
</head>
<body>

<h1>➕ Novo Plano</h1>

<?php if (isset($_SESSION['erro'])): ?>
    <div class="alert alert-error">
        ❌ <?= htmlspecialchars($_SESSION['erro']) ?>
    </div>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<form action="/admin/planos/criar" method="post">
    <div class="form-group">
        <label for="titulo">
            Título do Plano <span class="required">*</span>
        </label>
        <input 
            type="text" 
            id="titulo" 
            name="titulo" 
            placeholder="Ex: Plano Mensal, Plano Anual"
            required
            maxlength="100"
        >
    </div>

    <div class="form-group">
        <label for="valor">
            Valor (R$) <span class="required">*</span>
        </label>
        <input 
            type="number" 
            id="valor" 
            name="valor" 
            step="0.01" 
            min="0.01"
            placeholder="Ex: 99.90"
            required
        >
    </div>

    <div class="form-group">
        <label for="beneficios">
            Benefícios <span class="required">*</span>
        </label>
        <textarea 
            id="beneficios" 
            name="beneficios" 
            placeholder="Liste os benefícios do plano..."
            required
        ></textarea>
        <div class="example">
            <strong>💡 Exemplo:</strong><br>
            - Acesso ilimitado à academia<br>
            - Aulas de musculação<br>
            - Avaliação física mensal<br>
            - Área de cardio
        </div>
    </div>

    <button type="submit">💾 Criar Plano</button>
</form>

<a href="/admin/planos" class="btn-voltar">⬅️ Voltar</a>

</body>
</html>