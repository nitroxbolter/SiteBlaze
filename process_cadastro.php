<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php'; // Incluindo o arquivo de conexão

// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash da senha
    $email = $_POST['email'];

    // Montar a consulta SQL
    $sql = "INSERT INTO usuarios (username, password, email) VALUES ('$username', '$password', '$email')";

    // Executar a consulta
    if ($conn->query($sql) === TRUE) {
        // Redirecionar para a página de sucesso
        header('Location: success.php');
        exit(); // Para garantir que o script pare aqui
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close(); // Fechar a conexão
?>
