<?php
// index.php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao WhiteHunter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('arquivos/blazes.gif'); /* Imagem de fundo */
            background-size: 100%; /* Ajuste do tamanho da imagem */
            background-repeat: no-repeat; /* Impede a repetição da imagem */
            background-position: center; /* Centraliza a imagem */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .welcome-container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .welcome-container h1 {
            margin-bottom: 20px;
        }
        .welcome-container a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .welcome-container a:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

<div class="welcome-container">
    <h1>Bem-vindo ao WhiteHunter!</h1>
    <p>Explore nosso site e aproveite nossos serviços.</p>
    <a href="login.php">Login</a>
    <a href="cadastro.php">Cadastro</a>
</div>

</body>
</html>
