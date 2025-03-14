<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['type'] != 3) {
    header('Location: login.php'); // Redireciona se não estiver logado ou não for administrador
    exit();
}

include 'db_connect.php'; // Incluindo o arquivo de conexão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['id'];
    $type = $_POST['type'];
    
    // Define a query SQL e os parâmetros
    if ($type == 2) { // Se o usuário for promovido a premium
        $premium_activation = date('Y-m-d'); // Define a data de ativação para hoje
        $sql_update = "UPDATE usuarios SET type = ?, premium_activation = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("isi", $type, $premium_activation, $user_id);
    } else { // Para outros tipos, removemos a data de ativação
        $sql_update = "UPDATE usuarios SET type = ?, premium_activation = NULL WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ii", $type, $user_id);
    }
    
    // Executa a query
    $stmt->execute();
    $stmt->close();
}

// Consulta para obter todos os usuários, incluindo data_cadastro e premium_activation
$sql = "SELECT id, username, email, type, data_cadastro, premium_activation FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #001f3f; /* Azul escuro */
            color: white; /* Texto branco para contraste */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center; /* Centraliza o texto nas células da tabela */
        }
        th {
            background-color: #f2f2f2;
            color: black; /* Cor do texto das cabeçalhos */
        }
        .message {
            margin: 20px 0;
            font-size: 24px;
        }
        .top-bar {
            margin-bottom: 20px;
        }
        .top-bar a {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .top-bar a:hover {
            background-color: #45a049;
        }
        h1 {
            text-align: center; /* Centraliza o texto do título */
        }
        button {
            background-color: red; /* Cor de fundo dos botões "Atualizar" */
            color: white; /* Cor do texto dos botões */
            border: none; /* Remove bordas */
            padding: 10px 15px; /* Adiciona padding */
            border-radius: 5px; /* Bordas arredondadas */
            cursor: pointer; /* Muda o cursor para pointer */
        }
        button:hover {
            opacity: 0.8; /* Efeito de hover nos botões */
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <a href="main.php">Home</a>
    </div>
    <h1>Painel de Administração</h1>
    <div class="message">Usuários:</div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Email</th>
                <th>Nível de Acesso</th>
                <th>Data de Cadastro</th>
                <th>Data de Ativação do Premium</th> <!-- Nova coluna -->
                <th>Premium (Dias Restantes)</th> <!-- Nova coluna -->
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Calcula os dias restantes do premium
                    $dias_restantes = '';
                    if ($row['type'] == 2 && !empty($row['premium_activation'])) {
                        $data_ativacao = new DateTime($row['premium_activation']);
                        $data_expiracao = $data_ativacao->modify('+30 days');
                        $data_atual = new DateTime();
                        $intervalo = $data_atual->diff($data_expiracao);
                        $dias_restantes = $intervalo->invert ? 'Expirado' : $intervalo->days . ' dias';
                    }

                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<form action='' method='POST'>";
                    echo "<td>
                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                            <select name='type'>
                                <option value='1'" . ($row['type'] == 1 ? " selected" : "") . ">Cadastrado</option>
                                <option value='2'" . ($row['type'] == 2 ? " selected" : "") . ">Premium</option>
                                <option value='3'" . ($row['type'] == 3 ? " selected" : "") . ">Admin</option>
                            </select>
                          </td>";
                    echo "<td>" . date('d/m/Y H:i:s', strtotime($row['data_cadastro'])) . "</td>";
                    echo "<td>" . (!empty($row['premium_activation']) ? date('d/m/Y', strtotime($row['premium_activation'])) : 'N/A') . "</td>"; // Exibe a data de ativação
                    echo "<td>" . $dias_restantes . "</td>"; // Exibe os dias restantes
                    echo "<td><button type='submit'>Atualizar</button></td>"; // Botão de atualizar
                    echo "</form>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Nenhum usuário encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close(); // Fechar a conexão
?>
