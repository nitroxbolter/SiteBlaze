<?php
session_start(); // Inicia a sessão
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php'; // Incluindo o arquivo de conexão

// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta o usuário no banco de dados
    $sql = "SELECT password, type FROM usuarios WHERE username = '$username'";
    $result = $conn->query($sql);

    // Variável para armazenar mensagem de erro
    $error_message = "";

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verifica a senha
        if (password_verify($password, $row['password'])) {
            // Armazena o nome do usuário e o tipo na sessão
            $_SESSION['username'] = $username;
            $_SESSION['type'] = $row['type'];

            // Redireciona com base no nível de acesso
            if ($row['type'] == 1) {
                header('Location: possloguin.php');
            } elseif ($row['type'] == 2) {
                header('Location: main.php'); // Para nível 2
            } elseif ($row['type'] == 3) {
                header('Location: admin.php'); // Para nível 3
            }
            exit(); // Para garantir que o script pare aqui
        } else {
            $error_message = "Senha incorreta.";
        }
    } else {
        $error_message = "Usuário não encontrado.";
    }
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4; /* Cor de fundo opcional */
        }
        .error-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #f00;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .error-container h2 {
            color: #f00;
        }
        .error-container button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php if (!empty($error_message)): ?>
        <div class="error-container">
            <h2><?php echo $error_message; ?></h2>
            <form action="login.php" method="get">
                <button type="submit">Tentar Novamente</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
