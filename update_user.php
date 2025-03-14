<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['type'] != 3) {
    header('Location: login.php'); // Redireciona se não estiver logado ou não for administrador
    exit();
}

include 'db_connect.php'; // Incluindo o arquivo de conexão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $new_type = $_POST['type'];

    // Atualiza o nível de acesso do usuário no banco de dados
    $sql = "UPDATE usuarios SET type = $new_type WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php'); // Redireciona de volta para a página de administração
        exit();
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}

$conn->close(); // Fechar a conexão
?>
