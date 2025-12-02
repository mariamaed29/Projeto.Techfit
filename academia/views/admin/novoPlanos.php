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
            color: #dc