<!DOCTYPE html>
<html>
<head>
    <title>Update Log - Double Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .log-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }

        .log-title {
            color: red;
            text-align: center;
            font-size: 1.8em;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .update-entry {
            margin-bottom: 30px;
            padding: 15px;
            border-radius: 6px;
            background-color: #f8f9fa;
            transition: transform 0.2s;
        }

        .update-entry:hover {
            transform: translateX(10px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .version {
            color: #0066cc;
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .date {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        .changes {
            list-style-type: none;
            padding: 0;
        }

        .changes li {
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }

        .changes li:before {
            content: "•";
            color: #28a745;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .new-feature {
            background-color: #e8f5e9;
            border-left: 4px solid #28a745;
        }

        .improvement {
            background-color: #e3f2fd;
            border-left: 4px solid #0066cc;
        }
    </style>
</head>
<body>
    <div class="log-container">
        <h1 class="log-title">Double Manager Update Log</h1>

        <!-- Versão 1.6 -->
        <div class="update-entry new-feature">
            <div class="version">Versão 1.6</div>
            <div class="date">13 de Março de 2025</div>
            <ul class="changes">
                <li>Sistema de dados em tempo real.</li>
                <li>Sistema automatico de rastreio do Branco.</li>
                <li>Visualisação da ultima cor e ultimo Branco.</li>
                <li>Menu modificado, em cascata.</li>
                <li>Sistema de sinal via PopUp.</li>
            </ul>
        </div>

        <!-- Versão 1.5 -->
        <div class="update-entry new-feature">
            <div class="version">Versão 1.5</div>
            <div class="date">15 de Março de 2024</div>
            <ul class="changes">
                <li>Adicionada Calculadora de Risco avançada para análise de ciclos</li>
                <li>Cálculo automático de quantos ciclos sua banca suporta</li>
                <li>Visualização detalhada de prejuízo por ciclo</li>
                <li>Interface intuitiva para cálculo de gales</li>
                <li>Sistema de alerta para banca insuficiente</li>
            </ul>
        </div>

        <!-- Versão 1.4 -->
        <div class="update-entry improvement">
            <div class="version">Versão 1.4</div>
            <div class="date">10 de Março de 2024</div>
            <ul class="changes">
                <li>Implementada funcionalidade de cópia rápida na lista de gerenciamento</li>
                <li>Clique único para copiar valores de apostas</li>
                <li>Feedback visual ao copiar valores</li>
                <li>Melhorias na interface do usuário</li>
                <li>Otimização no desempenho geral do sistema</li>
            </ul>
        </div>

        <!-- Versão 1.3 -->
        <div class="update-entry improvement">
            <div class="version">Versão 1.3</div>
            <div class="date">5 de Março de 2024</div>
            <ul class="changes">
                <li>Correções de bugs menores</li>
                <li>Melhorias na responsividade</li>
                <li>Atualização no sistema de cálculo</li>
                <li>Interface mais intuitiva</li>
            </ul>
        </div>
    </div>
</body>
</html> 