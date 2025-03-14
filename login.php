<?php
// index.php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            background-image: url('arquivos/loguin.png'); /* Imagem de fundo */
            background-size: 100%; /* Faz a imagem cobrir toda a tela */
            background-repeat: no-repeat; /* Impede a repetição da imagem */
            background-position: center; /* Centraliza a imagem */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.8); /* Fundo levemente transparente */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center; /* Centraliza o texto e os elementos internos */
        }
        .login-container h2 {
            margin-bottom: 20px;
            position: relative; /* Para posicionar a tarja em relação ao texto */
            display: inline-block; /* Garante que o fundo vermelho se ajuste ao texto */
        }
        .login-container h2 span {
            background-color: red; /* Tarja vermelha */
            color: white; /* Cor do texto */
            padding: 5px 150px; /* Espaçamento ao redor do texto */
            border-radius: 5px; /* Bordas arredondadas da tarja */
            font-size: 28px; /* Tamanho da fonte */
            font-weight: bold; /* Negrito */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Sombra do texto */
        }
        .login-container input {
            width: 300px; /* Define a largura dos campos de entrada */
            padding: 10px;
            margin: 10px 0; /* Espaçamento entre os campos */
            border: 1px solid #ccc;
            border-radius: 5px;
            display: block; /* Garante que os campos fiquem em blocos separados */
            margin-left: auto; /* Centraliza os campos */
            margin-right: auto; /* Centraliza os campos */
        }
        .login-container button {
            width: 200px; /* Define a largura do botão */
            padding: 10px;
            background-color: red; /* Fundo vermelho */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px auto 0; /* Centraliza o botão */
            display: inline-block; /* Alinha ao lado do botão de registro */
        }
        .login-container button:hover {
            background-color: darkred; /* Fundo vermelho escuro ao passar o mouse */
        }
        .register-button {
            background-color: transparent; /* Fundo transparente */
            color: blue; /* Texto azul */
            border: none; /* Sem bordas */
            text-decoration: underline; /* Texto sublinhado */
            cursor: pointer; /* Cursor de ponteiro */
            margin-left: 10px; /* Espaçamento à esquerda */
        }
        .register-button:hover {
            color: darkblue; /* Cor ao passar o mouse */
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2><span>Login</span></h2>
    <form action="process_login.php" method="POST">
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
        <a href="cadastro.php" class="register-button">Registre-se</a> <!-- Botão de registro -->
    </form>
</div>

</body>
</html>
