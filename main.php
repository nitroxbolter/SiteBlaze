<?php
session_start(); // Inicia a sessão
// Assumindo que o nome do usuário está armazenado na variável de sessão 'username'
$usuarioLogado = isset($_SESSION['username']) ? $_SESSION['username'] : 'Visitante';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>White Hunter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('arquivos/telahome.png');
            background-size: cover;
            background-position: center;
            color: #000000;
            display: flex;
            height: 100vh;
        }
        .menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            z-index: 1000;
        }
        
        .menu-button {
            width: 100%;
            padding: 15px;
            background-color: rgb(47, 47, 218);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
            position: relative;
            z-index: 1001;
        }
        
        .menu-button:hover {
            background-color: rgb(37, 37, 173);
        }
        
        .menu-icon {
            font-size: 20px;
        }
        
        .menu-text {
            font-size: 16px;
            font-weight: bold;
        }
        
        .menu-content {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            border-right: 2px solid #0056b3;
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.5s ease-in-out;
            opacity: 0;
        }
        
        .menu-content.active {
            max-height: calc(100vh - 50px);
            opacity: 1;
            padding: 20px;
            overflow-y: auto;
        }
        
        .menu ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        .menu li {
            margin: 10px 0;
        }
        
        .menu a {
            display: block;
            padding: 12px 15px;
            color: #0056b3;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .menu a:hover {
            background-color: #0056b3;
            color: white;
            transform: translateX(5px);
        }
        
        .corfundomenu {
            position: relative;
            overflow: hidden;
        }
        
        .corfundomenu::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #0056b3;
            transition: width 0.3s;
        }
        
        .corfundomenu:hover::after {
            width: 100%;
        }
        
        .dark-theme .menu-content {
            background-color: rgba(0, 0, 0, 0.95);
        }
        
        .dark-theme .menu a {
            color: white;
        }
        
        .dark-theme .menu a:hover {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
            flex-grow: 1;
        }
        .theme-toggle {
            background-color: rgb(47, 47, 218); /* Cor de fundo roxa */
            color: white; /* Cor do texto */
            border: none; /* Remova a borda */
            padding: 10px 20px; /* Ajuste o preenchimento */
            cursor: pointer; /* Cursor em forma de mão ao passar sobre o botão */
            border-radius: 5px; /* Bordas arredondadas (opcional) */
            transition: background-color 0.3s; /* Transição suave ao passar o mouse */
            position: absolute; /* Para permitir o posicionamento absoluto */
            top: 20px; /* Distância do topo */
            right: 10px; /* Distância da direita */
        }
        
        .theme-toggle:hover {
            background-color: rgb(47, 47, 218); /* Cor de fundo ao passar o mouse */
        }
        .theme-toggle.transparent {
            background-color: rgba(255, 255, 255, 0);
            color: #007bff;
            border: 2px solid #007bff;
        }
        .frame {
            border: 2px solid #0056b3;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(240, 240, 240, 0.8);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, border-color 0.3s;
            text-align: center;
        }
        h1 {
            color: #0056b3;
            margin: 20px 0;
        }
        .frame img {
            display: block;
            margin: 0 auto;
            max-width: 100px;
        }
        .frame p {
            margin-bottom: 20px;
        }
        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin: 0 10px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        table.results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            color: #000000;
            transition: color 0.3s;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #0056b3;
            color: white;
        }
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        .result-input {
            background-color: #e9ecef;
            color: #000000;
        }
        .result6 {
            background-color: #28a745;
            color: #000000;
        }
        .result10 {
            background-color: #ffc107;
            color: #000000;  
        }
        .result12 {
            background-color: #dc3545;
            color: #000000;       
        }
        .pago-cell {
            cursor: pointer;
        }
        .dark-theme body {
            background-color: #343a40;
            color: #ffffff;
        }
        .dark-theme .menu {
            background-color: rgba(0, 0, 0, 0.8);
            border-right: 2px solid #007bff;
        }
        .dark-theme .menu th {
            background-color: #007bff;
        }
        .dark-theme .results-table th {
            background-color: rgb(47, 47, 218);
        }
        .dark-theme .frame {
            background-color: rgba(50, 50, 50, 0.8);
        }
        .dark-theme .result-input {
            background-color: #6c757d;
        }
        .dark-theme .result6 {
            background-color: #218838;
        }
        .dark-theme .result10 {
            background-color: #e0a800;
        }
        .dark-theme .result12 {
            background-color: #c82333;
        }
        .dark-theme .pago-cell {
            color: #ffffff;
        }
        .developer-info {
            margin-top: 20px;
            text-align: center;
            font-size: 0.8em;
            color: #666;
        }
        .version-text {
            display: block;
            font-size: 0.9em;
            margin-bottom: 2px;
        }
        .developer-text {
            display: block;
            font-size: 0.8em;
            margin-bottom: 10px;
        }
        .update-log-btn {
            background-color: #0066cc;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .update-log-btn:hover {
            background-color: #0052a3;
        }
        /* Estilos para os resultados da Blaze */
        .blaze-container {
            margin: 20px 0;
        }

        .last-numbers-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
        }

        .number-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px;
            border-radius: 10px;
        }

        .roll-label {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .roll-box {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            margin: 5px;
            border: 2px solid #333;
            border-radius: 10px;
            background-color: #f0f0f0;
        }

        .roll-inner {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border: 2px solid #333;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .minute-display {
            margin-top: 5px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
            background-color: rgba(0, 0, 0, 0.1);
            padding: 3px 8px;
            border-radius: 5px;
        }

        .roll-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .roll-box-outer {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            margin: 5px;
            border: 2px solid #333;
            border-radius: 10px;
            background-color: #f0f0f0;
        }

        .roll-box-inner {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border: 2px solid #333;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        /* Estilos para as previsões de brancos */
        .container-previsoes {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 50px;
        }

        .possible-whites-container {
            border: 2px solid #000;
            padding: 15px 20px; /* Espaçamento interno */
            border-radius: 5px;
        }

        .boxes-container {
            display: flex;
            justify-content: center;
            margin-top: 10px; /* Espaço entre o título e os quadrados */
        }

        .prediction-container {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            margin: 0 5px;
        }

        .white-box {
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #000;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 20px;
            color: white;
        }

        .min-text {
            font-size: 12px;
            color: white;
            text-transform: capitalize;
        }

        #prediction6 {
            background-color: #90EE90;
        }

        #prediction10 {
            background-color: #FFB74D;
        }

        #prediction12 {
            background-color: #FF8A80;
        }

        .predictions-history {
            margin-top: 10px;
            width: fit-content;
        }

        .predictions-table {
            border-collapse: collapse;
            margin-top: 10px;
        }

        .predictions-table td {
            padding: 5px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .predictions-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .green { background-color: #90EE90; }
        .orange { background-color: #FFB74D; }
        .red { background-color: #FF8A80; }

        .extended-history-container {
            margin-top: 30px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            border: 2px solid #333;
        }

        .history-label {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            color: #333;
        }

        .extended-roll-container {
            display: flex;
            justify-content: center;
        }

        .roll-history {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            max-width: 900px; /* Ajuste conforme necessário */
        }

        .history-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
        }

        .history-roll {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border: 2px solid #333;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        .history-minute {
            font-size: 12px;
            font-weight: bold;
            color: #666;
        }

        .sinal-container {
            position: fixed;
            top: 80px;  /* Ajustado para ficar abaixo do botão do menu */
            left: 20px;  /* Ajustado para ficar mais próximo da borda esquerda */
            transform: none;
            z-index: 1000;
            background-color: rgba(0, 0, 0, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            max-width: 300px;
            width: auto;
            animation: slideInLeft 0.5s ease-out;
        }

        @keyframes slideInLeft {
            from {
                left: -350px;
                opacity: 0;
            }
            to {
                left: 20px;
                opacity: 1;
            }
        }

        .sinal-content {
            color: white;
            text-align: center;
        }

        .sinal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .sinal-title {
            font-size: 20px;  /* Reduzido um pouco */
            font-weight: bold;
            color: #ffd700;
        }

        .sinal-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0 5px;
        }

        .sinal-close:hover {
            color: #ff4444;
        }

        .sinal-mensagem {
            font-size: 16px;  /* Reduzido um pouco */
            line-height: 1.5;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            margin-top: 10px;
            white-space: pre-line;  /* Para respeitar as quebras de linha do sinal */
        }

        /* Ajuste para tema escuro */
        .dark-theme .sinal-container {
            background-color: rgba(0, 0, 0, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .title-box {
            background-color: #FF8A80; /* Mesmo vermelho do último quadrado */
            padding: 5px 15px;
            border-radius: 50px;
            display: inline-block;
            border: 1px solid #666;
            margin-bottom: 10px;
        }

        .title-box p {
            margin: 0;
            color: black;
            font-weight: normal;
        }

        p {
            margin-bottom: 10px;
        }
    </style>
    <script>
        function padZero(value) {
            return value < 10 ? '0' + value : value;
        }

        function calculateNextWhites(lastWhiteMinute) {
            return {
                plus6: padZero((lastWhiteMinute + 6) % 60),
                plus10: padZero((lastWhiteMinute + 10) % 60),
                plus12: padZero((lastWhiteMinute + 12) % 60)
            };
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-theme');
            document.querySelector('.theme-toggle').classList.toggle('transparent');
        }

        function openGenPage() {
            window.open('gerenciamento.php', 'Gerenciamento', 'width=600,height=400');
        }

        function openmenPage() {
            window.open('https://drive.google.com/file/d/1GxqejD4ByY5nZdI16LQFo7LVeB3hsYta/view?usp=sharing', 'Mentoria', 'width=600,height=400');
        }

        function openinstaPage() {
            window.open('https://www.instagram.com/whitehunter14x/', 'Instagram', 'width=600,height=400');
        }

        function opentelePage() {
            window.open('https://t.me/+LpcnAY71meYyOTgx', 'Chat Oficial', 'width=600,height=400');
        }

        function opensala24() {
            window.open('https://t.me/+6ZcO1CrVHXZiODk5', 'Sala 24H', 'width=600,height=400');
        }

        function opensalacores() {
            window.open('https://t.me/+Cjii4fwI9ZZhMDBh', 'Sala Cores', 'width=600,height=400');
        }

        function openrobin() {
            window.open('https://robinblaze.com.br/', 'Robin', 'width=600,height=400');
        }
        
        function openlogoutPage() {
            window.location.href = 'login.php';
        }
    </script>
</head>
<body>
<div class="menu">
    <button id="menuButton" class="menu-button">
        <span class="menu-icon">☰</span>
        <span class="menu-text">Menu</span>
    </button>
    
    <div id="menuContent" class="menu-content">
        <p class="usuario-nome">Bem-vindo! <?php echo htmlspecialchars($usuarioLogado); ?>.</p>
        <ul>
            <li><a class="corfundomenu" href="#" onclick="openGenPage()">Gerenciamento</a></li>
            <li><a class="corfundomenu" href="#" onclick="openmenPage()">Mentoria</a></li>
            <li><a class="corfundomenu" href="#" onclick="openinstaPage()">Instagram</a></li>
            <li><a class="corfundomenu" href="#" onclick="opentelePage()">Chat Oficial</a></li>     
            <li><a class="corfundomenu" href="#" onclick="opensala24()">Sala 24h</a></li>
            <li><a class="corfundomenu" href="#" onclick="opensalacores()">Sala Cores</a></li>
            <li><a class="corfundomenu" href="#" onclick="openrobin()">Robin</a></li>
            <li><a class="corfundomenu" href="#" onclick="openlogoutPage()">Logout</a></li>
        </ul>
        
        <div class="developer-info">
            <span class="version-text">V1.5</span>
            <span class="developer-text">Developer Eduardo Gaier</span>
            <button class="update-log-btn" onclick="openUpdateLog()">Update Log</button>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="frame" style="text-align: center;">
        <h1 class="titulo-vermelho" style="background-color: red; color: white; padding: 10px; border-radius: 5px; display: inline-block;">White Hunter 14x</h1>
        
        <!-- Container para os resultados da Blaze -->
        <div class="blaze-container">
            <div class="last-numbers-container">
                <div class="number-container">
                    <p class="roll-label">Último Número</p>
                    <div class="roll-box">
                        <div class="roll-inner" id="last-roll-box"></div>
                    </div>
                    <div class="minute-display" id="last-roll-minute"></div>
                </div>
                
                <div class="number-container">
                    <p class="roll-label">Último Branco</p>
                    <div class="roll-box">
                        <div class="roll-inner" id="last-white-box"></div>
                    </div>
                    <div class="minute-display" id="last-white-minute"></div>
                </div>
            </div>

            <!-- Container para previsões de brancos -->
            <div class="container-previsoes">
                <div class="possible-whites-container">
                    <p>Possíveis Brancos</p>
                    <div class="boxes-container">
                        <div class="roll-label">
                            <div class="white-box" id="prediction6"></div>
                            <span class="min-text">Min</span>
                        </div>
                        <div class="roll-label">
                            <div class="white-box" id="prediction10"></div>
                            <span class="min-text">Min</span>
                        </div>
                        <div class="prediction-container">
                            <div class="white-box" id="prediction12"></div>
                            <span class="min-text">Min</span>
                        </div>
                    </div>
                </div>

                <div class="predictions-history">
                    <p class="predictions-label">Histórico de Previsões</p>
                    <table class="predictions-table">
                        <tr>
                            <td class="green">--</td>
                            <td class="orange">--</td>
                            <td class="red">--</td>
                        </tr>
                        <tr>
                            <td class="green">--</td>
                            <td class="orange">--</td>
                            <td class="red">--</td>
                        </tr>
                        <tr>
                            <td class="green">--</td>
                            <td class="orange">--</td>
                            <td class="red">--</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Tabela de Roll em Quadrados -->
            <div class="roll-container" id="roll-container"></div>

            <!-- Adicionar após o roll-container existente -->
            <div class="extended-history-container">
                <p class="history-label">Histórico Estendido</p>
                <div class="extended-roll-container">
                    <div class="roll-history" id="extended-roll-container"></div>
                </div>
            </div>
        </div>
        <button class="theme-toggle" onclick="toggleTheme()">Alternar Tema</button>

        <!-- Adicionar após a div blaze-container -->
        <div id="sinalContainer" class="sinal-container" style="display: none;">
            <div class="sinal-content">
                <div class="sinal-header">
                    <span class="sinal-title">🎯POSSIVEL ENTRADA!</span>
                    <button class="sinal-close" onclick="fecharSinal()">×</button>
                </div>
                <div id="sinalMensagem" class="sinal-mensagem"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function openUpdateLog() {
        // Calcula o centro da tela
        const width = 800; // Largura média em pixels
        const height = window.innerHeight - 100; // Altura total menos 100px de margem
        const left = (window.innerWidth - width) / 2;
        const top = 50; // 50px do topo da tela

        // Configurações da janela popup
        const features = `
            width=${width},
            height=${height},
            left=${left},
            top=${top},
            scrollbars=yes,
            resizable=no,
            status=no,
            location=no,
            toolbar=no,
            menubar=no
        `;

        window.open('updatelog.php', 'UpdateLog', features);
    }

    let ultimoSinalTimestamp = 0;

    function verificarSinais() {
        fetch('sinal.json?' + new Date().getTime())  // Evita cache
            .then(response => response.json())
            .then(data => {
                if (data.ativo && data.timestamp > ultimoSinalTimestamp) {
                    ultimoSinalTimestamp = data.timestamp;
                    mostrarSinal(data.mensagem);
                }
            })
            .catch(error => console.log('Nenhum sinal novo'));
    }

    function mostrarSinal(mensagem) {
        const sinalContainer = document.getElementById('sinalContainer');
        const sinalMensagem = document.getElementById('sinalMensagem');
        
        sinalMensagem.textContent = mensagem;
        sinalContainer.style.display = 'block';
        
        // Reproduzir som de notificação
        const audio = new Audio('notification.mp3');  // Você precisará adicionar este arquivo
        audio.play();
    }

    function fecharSinal() {
        const sinalContainer = document.getElementById('sinalContainer');
        sinalContainer.style.display = 'none';
        
        // Marcar sinal como inativo
        fetch('sinal.json')
            .then(response => response.json())
            .then(data => {
                data.ativo = false;
                return fetch('marcar_sinal_lido.php');  // Você precisará criar este arquivo
            });
    }

    // Verificar sinais a cada 5 segundos
    setInterval(verificarSinais, 5000);

    let historicoPrevisoes = [];
    let ultimaPrevisao = null;

    function atualizarHistoricoPrevisoes(previsoes) {
        // Verificar se é diferente da última previsão
        if (!ultimaPrevisao || 
            ultimaPrevisao.plus6 !== previsoes.plus6 || 
            ultimaPrevisao.plus10 !== previsoes.plus10 || 
            ultimaPrevisao.plus12 !== previsoes.plus12) {
            
            ultimaPrevisao = {...previsoes};
            historicoPrevisoes.unshift(previsoes);
            
            if (historicoPrevisoes.length > 3) {
                historicoPrevisoes.pop();
            }

            const rows = document.querySelectorAll('.predictions-table tr');
            historicoPrevisoes.forEach((prev, index) => {
                if (rows[index]) {
                    const cells = rows[index].getElementsByTagName('td');
                    cells[0].textContent = prev.plus6;
                    cells[1].textContent = prev.plus10;
                    cells[2].textContent = prev.plus12;
                }
            });
        }
    }

    setInterval(function() {
        fetch('dados.json')
            .then(response => response.json())
            .then(data => {
                const rollContainer = document.getElementById("roll-container");
                const lastRollBox = document.getElementById("last-roll-box");
                const lastWhiteBox = document.getElementById("last-white-box");
                const lastRollMinute = document.getElementById("last-roll-minute");
                const lastWhiteMinute = document.getElementById("last-white-minute");

                // Encontrar o último branco (0)
                let lastWhiteIndex = -1;
                for (let i = data.length - 1; i >= 0; i--) {
                    if (data[i].roll === 0) {
                        lastWhiteIndex = i;
                        break;
                    }
                }

                const maxNumbers = 10;
                const latestRolls = data.slice(-maxNumbers);
                const lastRoll = latestRolls[latestRolls.length - 1];

                // Atualizar último número e seu minuto
                lastRollBox.textContent = lastRoll.roll;
                lastRollMinute.textContent = `Minuto: ${padZero(lastRoll.minute)}`;

                let lastRollBgColor, lastRollTextColor;
                if (lastRoll.roll >= 1 && lastRoll.roll <= 7) {
                    lastRollBgColor = 'red';
                    lastRollTextColor = 'black';
                } else if (lastRoll.roll >= 8 && lastRoll.roll <= 14) {
                    lastRollBgColor = 'black';
                    lastRollTextColor = 'white';
                } else if (lastRoll.roll === 0) {
                    lastRollBgColor = 'white';
                    lastRollTextColor = 'black';
                } else {
                    lastRollBgColor = 'gray';
                    lastRollTextColor = 'black';
                }
                lastRollBox.style.backgroundColor = lastRollBgColor;
                lastRollBox.style.color = lastRollTextColor;

                // Atualizar último branco e seu minuto
                if (lastWhiteIndex !== -1) {
                    const lastWhite = data[lastWhiteIndex];
                    lastWhiteBox.textContent = '0';
                    lastWhiteBox.style.backgroundColor = 'white';
                    lastWhiteBox.style.color = 'black';
                    lastWhiteMinute.textContent = `Minuto: ${padZero(lastWhite.minute)}`;
                    
                    // Atualizar previsões
                    const predictions = calculateNextWhites(lastWhite.minute);
                    document.getElementById('prediction6').textContent = predictions.plus6;
                    document.getElementById('prediction10').textContent = predictions.plus10;
                    document.getElementById('prediction12').textContent = predictions.plus12;

                    // Adicionar ao histórico
                    atualizarHistoricoPrevisoes(predictions);
                }

                // Resto do código para atualizar o roll-container
                rollContainer.innerHTML = '';

                latestRolls.forEach(dataItem => {
                    const roll = dataItem.roll;
                    let rollBgColor, rollTextColor;

                    if (roll >= 1 && roll <= 7) {
                        rollBgColor = 'red';
                        rollTextColor = 'black';
                    } else if (roll >= 8 && roll <= 14) {
                        rollBgColor = 'black';
                        rollTextColor = 'white';
                    } else if (roll === 0) {
                        rollBgColor = 'white';
                        rollTextColor = 'black';
                    } else {
                        rollBgColor = 'gray';
                        rollTextColor = 'black';
                    }

                    const rollBoxOuter = document.createElement("div");
                    rollBoxOuter.className = "roll-box-outer";

                    const rollBoxInner = document.createElement("div");
                    rollBoxInner.className = "roll-box-inner";
                    rollBoxInner.style.backgroundColor = rollBgColor;
                    rollBoxInner.style.color = rollTextColor;
                    rollBoxInner.textContent = roll;

                    rollBoxOuter.appendChild(rollBoxInner);
                    rollContainer.prepend(rollBoxOuter);
                });

                // Atualizar o histórico estendido
                const extendedContainer = document.getElementById("extended-roll-container");
                const last25Rolls = data.slice(-64);
                extendedContainer.innerHTML = '';

                last25Rolls.forEach(item => {
                    const historyItem = document.createElement("div");
                    historyItem.className = "history-item";

                    const rollDiv = document.createElement("div");
                    rollDiv.className = "history-roll";
                    rollDiv.textContent = item.roll;

                    // Definir cores do número
                    let bgColor, textColor;
                    if (item.roll >= 1 && item.roll <= 7) {
                        bgColor = 'red';
                        textColor = 'black';
                    } else if (item.roll >= 8 && item.roll <= 14) {
                        bgColor = 'black';
                        textColor = 'white';
                    } else if (item.roll === 0) {
                        bgColor = 'white';
                        textColor = 'black';
                    } else {
                        bgColor = 'gray';
                        textColor = 'black';
                    }
                    rollDiv.style.backgroundColor = bgColor;
                    rollDiv.style.color = textColor;

                    const minuteDiv = document.createElement("div");
                    minuteDiv.className = "history-minute";
                    minuteDiv.textContent = padZero(item.minute);

                    historyItem.appendChild(rollDiv);
                    historyItem.appendChild(minuteDiv);
                    extendedContainer.prepend(historyItem);
                });
            });
    }, 5000);

    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.getElementById('menuButton');
        const menuContent = document.getElementById('menuContent');
        let isMenuOpen = false;

        menuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            isMenuOpen = !isMenuOpen;
            menuContent.classList.toggle('active');
            
            // Atualizar ícone do menu
            const menuIcon = menuButton.querySelector('.menu-icon');
            menuIcon.textContent = isMenuOpen ? '✕' : '☰';
        });

        // Fechar menu ao clicar fora
        document.addEventListener('click', function(event) {
            const isClickInsideMenu = menuButton.contains(event.target) || 
                                    menuContent.contains(event.target);
            
            if (!isClickInsideMenu && isMenuOpen) {
                isMenuOpen = false;
                menuContent.classList.remove('active');
                menuButton.querySelector('.menu-icon').textContent = '☰';
            }
        });
    });
</script>
</body>
</html>