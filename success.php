<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Realizado</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .message {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .login-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .login-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="message">
        Cadastro realizado com sucesso! Você pode fazer login agora.
    </div>
    <a href="login.php" class="login-button">Login</a>
</body>
</html>
