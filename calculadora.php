<?php
// Funções de cálculo
function calcularCiclos($banca, $apostaInicial, $numGales) {
    $resultados = [];
    $bancaAtual = $banca;
    $ciclo = 1;
    $apostaAtual = $apostaInicial;
    
    // Calcula o valor total necessário para o primeiro ciclo
    $valorNecessario = $apostaInicial;
    for ($i = 1; $i <= $numGales; $i++) {
        $valorNecessario += ($apostaInicial * pow(2, $i));
    }
    
    // Só continua se a banca for suficiente para pelo menos um ciclo
    if ($banca < $valorNecessario) {
        return null; // Retorna null se a banca for insuficiente
    }
    
    while ($bancaAtual >= $apostaAtual) {
        $cicloAtual = [
            'numero' => $ciclo,
            'bancaInicial' => $bancaAtual,
            'apostas' => [],
            'prejuizoTotal' => 0
        ];
        
        $apostaDesteCiclo = $apostaAtual;
        for ($i = 0; $i <= $numGales; $i++) {
            $cicloAtual['apostas'][] = [
                'nivel' => $i === 0 ? 'Entrada' : "Gale $i",
                'valor' => $apostaDesteCiclo
            ];
            $cicloAtual['prejuizoTotal'] += $apostaDesteCiclo;
            $apostaDesteCiclo *= 2;
        }
        
        $bancaAtual -= $cicloAtual['prejuizoTotal'];
        $cicloAtual['bancaRestante'] = $bancaAtual;
        
        $resultados[] = $cicloAtual;
        $apostaAtual = $cicloAtual['prejuizoTotal'];
        $ciclo++;
    }
    
    return $resultados;
}

// Processar o formulário se foi enviado
$resultados = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calcular'])) {
    $banca = floatval($_POST['banca'] ?? 0);
    $apostaInicial = floatval($_POST['aposta'] ?? 0);
    $numGales = intval($_POST['gales'] ?? 0);
    
    if ($banca > 0 && $apostaInicial > 0 && $numGales >= 0) {
        $resultados = calcularCiclos($banca, $apostaInicial, $numGales);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Calculadora de Risco</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .calculator-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .input-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            gap: 20px;
        }

        .input-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 1.1em;
            font-weight: bold;
            width: 100%;
            text-align: center;
        }

        input[type="number"] {
            width: 80%;
            padding: 8px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 0.9em;
            text-align: center;
            -moz-appearance: textfield;
            -webkit-appearance: none;
            appearance: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        input[type="number"]:focus {
            border-color: #28a745;
            box-shadow: 0 2px 8px rgba(40,167,69,0.2);
            outline: none;
        }

        input[type="number"]:hover {
            border-color: #999;
        }

        .buttons-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .calculate-button {
            background-color: #28a745;
        }

        .clear-button {
            background-color: red;
        }

        .results {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .cycle {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        /* Remove spinners dos inputs numéricos */
        input[type="number"] {
            width: 80%;
            padding: 8px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 0.9em;
            text-align: center;
            -moz-appearance: textfield; /* Remove spinners no Firefox */
            -webkit-appearance: none; /* Remove spinners no Chrome/Safari/Edge */
            appearance: none; /* Padrão */
        }

        /* Remove spinners no Chrome, Safari, Edge, Opera */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Adicione estilo para o texto em vermelho */
        .cycle strong, .cycle-info {
            color: red;
        }
    </style>
</head>
<body>
    <div class="calculator-container">
        <h2 style="text-align: center; color: red;">Calculadora de Risco</h2>
        
        <form method="POST">
            <div class="input-container">
                <div class="input-item">
                    <label>Banca (R$):</label>
                    <input type="number" name="banca" step="0.01" value="<?= $_POST['banca'] ?? '' ?>">
                </div>
                <div class="input-item">
                    <label>Aposta Inicial (R$):</label>
                    <input type="number" name="aposta" step="0.01" value="<?= $_POST['aposta'] ?? '' ?>">
                </div>
                <div class="input-item">
                    <label>Número de Gales:</label>
                    <input type="number" name="gales" value="<?= $_POST['gales'] ?? '' ?>">
                </div>
            </div>

            <div class="buttons-container">
                <button type="submit" name="calcular" class="calculate-button">Calcular</button>
                <button type="submit" name="limpar" class="clear-button">Limpar</button>
            </div>
        </form>

        <?php if ($resultados): ?>
        <div class="results">
            <?php foreach ($resultados as $ciclo): ?>
                <div class="cycle">
                    <strong>Ciclo <?= $ciclo['numero'] ?></strong><br>
                    
                    <?php foreach ($ciclo['apostas'] as $aposta): ?>
                        <?= $aposta['nivel'] ?>: R$ <?= number_format($aposta['valor'], 2, ',', '.') ?><br>
                    <?php endforeach; ?>
                    
                    <span class="cycle-info">Prejuízo do Ciclo: R$ <?= number_format($ciclo['prejuizoTotal'], 2, ',', '.') ?></span><br>
                    Banca Restante: R$ <?= number_format($ciclo['bancaRestante'], 2, ',', '.') ?>
                </div>
            <?php endforeach; ?>
            
            <strong>Resultado Final:</strong><br>
            Total de Ciclos Possíveis: <?= count($resultados) ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
