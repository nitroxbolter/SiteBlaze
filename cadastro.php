<?php
// cadastro.php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Cor de fundo padrão */
            background-image: url('arquivos/blazes.gif'); /* Imagem de fundo */
            background-size: 90%; /* Faz a imagem cobrir toda a tela */
            background-repeat: no-repeat; /* Impede a repetição da imagem */
            background-position: center; /* Centraliza a imagem */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .cadastro-container {
            background-color: rgba(255, 255, 255, 0.9); /* Fundo levemente transparente para melhor visibilidade */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center; /* Centraliza o texto */
        }
        .cadastro-container h2 {
            margin-bottom: 20px;
            position: relative; /* Para posicionar a tarja em relação ao texto */
            display: inline-block; /* Garante que o fundo vermelho se ajuste ao texto */
        }
        .cadastro-container h2 span {
            background-color: red; /* Tarja vermelha */
            color: white; /* Cor do texto */
            padding: 5px 20px; /* Espaçamento ao redor do texto */
            border-radius: 5px; /* Bordas arredondadas da tarja */
            font-size: 28px; /* Tamanho da fonte */
            font-weight: bold; /* Negrito */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Sombra do texto */
        }
        .cadastro-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .cadastro-container button {
            width: 100%;
            padding: 10px;
            background-color: red; /* Mudança para fundo vermelho */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px; /* Espaçamento abaixo do botão */
        }
        .cadastro-container button:hover {
            background-color: darkred; /* Fundo vermelho escuro ao passar o mouse */
        }
        .login-link {
            display: inline-block; /* Permite o alinhamento ao lado do botão */
            padding: 10px;
            background-color: transparent; /* Fundo transparente */
            color: blue; /* Texto azul */
            border: none; /* Sem bordas */
            text-decoration: underline; /* Texto sublinhado */
            cursor: pointer; /* Cursor de ponteiro */
        }
        .login-link:hover {
            color: darkblue; /* Cor ao passar o mouse */
        }
    </style>
</head>
<body>

<div class="cadastro-container">
    <h2><span>Cadastro</span></h2> <!-- Tarja vermelha ao redor do texto "Cadastro" -->
    <form action="process_cadastro.php" method="POST">
        <input type="text" name="username" placeholder="Usuário" required>
        <input type="password" name="password" placeholder="Senha" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <button type="submit">Cadastrar</button> <!-- Botão de Cadastro em vermelho -->
        <a href="login.php" class="login-link">Já tenho cadastro</a> <!-- Botão "Já tenho cadastro" -->
    </form>
</div>

</body>
</html>
