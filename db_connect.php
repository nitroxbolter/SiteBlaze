<?php
$servername = "sql303.infinityfree.com"; // Nome do host
$username = "if0_37500639";              // Nome de usuário do MySQL
$password = "ukdL7W7yuCMR2b";             // Sua senha do MySQL
$dbname = "if0_37500639_database";             // Nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
//echo "Conexão bem-sucedida!";
?>
