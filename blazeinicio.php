<?php
// Caminho do arquivo JSON
$jsonFilePath = 'dados.json';

// Verifique se o arquivo existe
if (!file_exists($jsonFilePath)) {
    die("Arquivo não encontrado.");
}

// Leia o conteúdo do arquivo JSON
$jsonData = file_get_contents($jsonFilePath);

// Converta os dados JSON para um array PHP
$dataArray = json_decode($jsonData, true);

// Verifique se a conversão foi bem-sucedida
if ($dataArray === null) {
    die("Erro ao ler os dados JSON.");
}

// Obtém o último número de roll
$lastRoll = end($dataArray)['roll'];

// Define a cor de fundo do último número
$lastRollColor = ($lastRoll >= 1 && $lastRoll <= 7) ? 'red' :
                 (($lastRoll >= 8 && $lastRoll <= 14) ? 'black' :
                 ($lastRoll == 0 ? 'white' : 'gray'));

$lastRollTextColor = ($lastRoll >= 8 && $lastRoll <= 14) ? 'white' : 'black';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados Blaze</title>
    <style>
        /* Estilo geral */
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        .container {
            text-align: center;
            margin-top: 30px;
        }

        /* Estilização do último número */
        .last-roll-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .last-roll-label {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .last-roll-box {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80px;
            height: 80px;
            border: 3px solid #333;
            border-radius: 15px;
            font-size: 20px;
            font-weight: bold;
            background-color: <?= $lastRollColor ?>;
            color: <?= $lastRollTextColor ?>;
        }

        /* Estilo da área dos quadrados */
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

    </style>
</head>
<body>
    <h1>Resultados da Blaze</h1>

    <div class="container">

        <!-- Último Número -->
        <div class="last-roll-container">
            <p class="last-roll-label">Último Número</p>
            <div class="last-roll-box" id="last-roll-box">
                <?= htmlspecialchars($lastRoll) ?>
            </div>
        </div>

        <!-- Tabela de Roll em Quadrados -->
        <div class="roll-container" id="roll-container">
            <?php foreach ($dataArray as $data): ?>
                <?php
                    // Determinar a cor de fundo com base no valor de "roll"
                    $roll = $data['roll'];
                    $bgColor = ($roll >= 1 && $roll <= 7) ? 'red' :
                               (($roll >= 8 && $roll <= 14) ? 'black' :
                               ($roll == 0 ? 'white' : 'gray'));

                    $textColor = ($roll >= 8 && $roll <= 14) ? 'white' : 'black';
                ?>

                <div class="roll-box-outer">
                    <div class="roll-box-inner" style="background-color: <?= $bgColor ?>; color: <?= $textColor ?>;">
                        <?= htmlspecialchars($roll) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
<script>
    // Função para atualizar a tabela a cada 5 segundos
    setInterval(function() {
        fetch('dados.json')
            .then(response => response.json())
            .then(data => {
                const rollContainer = document.getElementById("roll-container");
                const lastRollBox = document.getElementById("last-roll-box");

                // Limite de 10 números
                const maxNumbers = 10;
                const latestRolls = data.slice(-maxNumbers);

                // Limpa a área onde os roll serão exibidos
                rollContainer.innerHTML = '';

                // Exibe o último número de roll fora da tabela
                const lastRoll = latestRolls[latestRolls.length - 1].roll;
                lastRollBox.textContent = lastRoll;

                // Define a cor do último número
                let bgColor, textColor;
                if (lastRoll >= 1 && lastRoll <= 7) {
                    bgColor = 'red';
                    textColor = 'black';
                } else if (lastRoll >= 8 && lastRoll <= 14) {
                    bgColor = 'black';
                    textColor = 'white';
                } else if (lastRoll === 0) {
                    bgColor = 'white';
                    textColor = 'black';
                } else {
                    bgColor = 'gray';
                    textColor = 'black';
                }

                lastRollBox.style.backgroundColor = bgColor;
                lastRollBox.style.color = textColor;

                // Adiciona os novos números com a cor correspondente
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

                    // Criar o novo quadrado
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
            });
    }, 5000); // Atualiza a cada 5 segundos
</script>
</html>
