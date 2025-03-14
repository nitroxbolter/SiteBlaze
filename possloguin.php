<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whitesniper - Acesso Nível 1</title>
    <style>
        body {
            display: flex;
            flex-direction: column; /* Alinha os itens na coluna */
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .message {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px; /* Espaço abaixo da mensagem */
        }
        .back-button {
            display: block; /* Faz com que o botão seja um bloco */
            margin: 0 auto; /* Centraliza o botão */
            padding: 10px 20px;
            font-size: 18px;
            color: white;
            background-color: #007bff; /* Cor de fundo do botão */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #0056b3; /* Cor do botão ao passar o mouse */
        }
    </style>
</head>
<body>
    <div class="message">
        Olá, <?php echo htmlspecialchars($_SESSION['username']); ?>! Seu cadastro foi efetuado, aguarde liberação do seu serviço.
    </div>
    <button class="back-button" onclick="window.location.href='login.php'">Voltar para Login</button> <!-- Botão para voltar -->
</body>
</html>
