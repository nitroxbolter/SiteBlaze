<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #0a0a0a;
        }
        .container {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 800px; /* Largura da caixa */
        }
        h1 {
            text-align: center;
            font-size: 1.3em;
            background-color: red; /* Tarja vermelha */
            color: white; /* Texto branco */
            padding: 10px; /* Espaçamento interno */
            margin: -15px -15px 15px; /* Margem negativa para sobrepor a borda */
            border-radius: 8px 8px 0 0; /* Bordas arredondadas apenas no topo */
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        input[type="number"]:focus {
            border-color: #28a745;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
            outline: none;
        }
        input[type="number"]:hover {
            border-color: #999;
        }
        button {
            width: 100%;
            padding: 6px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            font-size: 0.8em;
        }
        button:hover {
            background-color: #218838;
        }
        .clear-button {
            background-color: red;
        }
        .clear-button:hover {
            background-color: #cc0000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.7em;
            background-color: #242121;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: center;
            color: white;
        }
        tr.selected {
            background-color: #28a745 !important;
        }
        #resultTable1, #resultTable2 {
            display: none;
        }
        .alert {
            color: red;
            font-size: 0.8em;
            margin-top: 10px;
            text-align: center;
        }
        .profit-banner {
            background-color: #28a745;
            color: white;
            padding: 8px;
            margin-bottom: 5px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .tables-container {
            max-height: 300px;
            overflow-y: auto;
            margin-top: 15px;
        }
        .aposta-cell {
            cursor: pointer;
        }
        .aposta-cell:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        /* Remove as setas no Chrome, Safari, Edge, Opera */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .buttons-profit-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 15px;
        }
        .buttons-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 30%;
        }
        .profit-info {
            width: 65%;
            text-align: left;
        }
        .risk-button {
            background-color: #0066cc; /* Azul mais vibrante */
        }
        .risk-button:hover {
            background-color: #0052a3; /* Azul mais escuro para hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciamento</h1>
        <div class="input-container">
            <div class="input-item">
                <label for="banca">Banca (R$):</label>
                <input type="number" id="banca" name="banca" step="0.01" required>
            </div>
            <div class="input-item">
                <label for="entradas">Número de Tiros:</label>
                <input type="number" id="entradas" name="entradas" required>
            </div>
            <div class="input-item">
                <label for="brancos">Meta de Brancos:</label>
                <input type="number" id="brancos" name="brancos" min="0" value="0" required>
            </div>
        </div>
        <div class="buttons-profit-container">
            <div class="buttons-container">
                <button type="button" onclick="calcularTabela()">Calcular</button>
                <button type="button" class="clear-button" onclick="limparTabela()">Limpar</button>
                <button type="button" class="risk-button" onclick="window.location.href='calculadora.php'">Calculadora Risco</button>
            </div>
            <div class="profit-info">
                <div class="profit-banner" id="profitMessage"></div>
                <div class="profit-banner" id="profit30DaysMessage"></div>
                <div class="profit-banner" id="totalProfitMessage"></div>
            </div>
        </div>

        <div class="alert" id="alertMessage"></div>

        <div class="tables-container">
    <table id="resultTable1">
        <thead>
            <tr>
                <th>Entrada</th>
                <th>Aposta (R$)</th>
                <th>Total Acumulado (R$)</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


<script>
    function calcularTabela() {
        const banca = parseFloat(document.getElementById('banca').value);
        const entradas = parseInt(document.getElementById('entradas').value);
        const brancos = parseInt(document.getElementById('brancos').value);
        const multiplicador = 1.08;

        let tableBody1 = document.querySelector('#resultTable1 tbody');
        tableBody1.innerHTML = '';
        document.getElementById('alertMessage').innerText = '';
        document.getElementById('profitMessage').style.display = 'none';
        document.getElementById('profit30DaysMessage').style.display = 'none';
        document.getElementById('totalProfitMessage').style.display = 'none';

        let aposta = banca / ((Math.pow(multiplicador, entradas) - 1) / (multiplicador - 1));
        let total = 0;

        if (aposta < 0.10) {
            document.getElementById('alertMessage').innerText = 'A banca não suporta o valor mínimo de entrada de R$ 0,10.';
            return;
        }

        for (let i = 1; i <= entradas; i++) {
            if (total + aposta > banca) {
                let row = document.createElement('tr');
                row.innerHTML = `<td colspan="3">Excedeu a banca</td>`;
                tableBody1.appendChild(row);
                break;
            }

            total += aposta;

            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${i}</td>
                <td class="aposta-cell">${aposta.toFixed(2)}</td>
                <td>${total.toFixed(2)}</td>
            `;
            
            row.addEventListener('click', function() {
                document.querySelectorAll('#resultTable1 tbody tr').forEach(tr => {
                    tr.classList.remove('selected');
                });
                this.classList.add('selected');
            });

            const apostaCell = row.querySelector('.aposta-cell');
            apostaCell.addEventListener('click', function(e) {
                document.querySelectorAll('#resultTable1 tbody tr').forEach(tr => {
                    tr.classList.remove('selected');
                });
                
                this.parentElement.classList.add('selected');
                
                const valor = this.textContent;
                navigator.clipboard.writeText(valor).then(() => {
                    const originalColor = this.style.backgroundColor;
                    this.style.backgroundColor = '#4CAF50';
                    setTimeout(() => {
                        this.style.backgroundColor = originalColor;
                    }, 200);
                }).catch(err => {
                    console.error('Erro ao copiar texto: ', err);
                });
            });

            tableBody1.appendChild(row);
            aposta *= multiplicador;
        }

        document.getElementById('resultTable1').style.display = 'table';

        const lucroPorBranco = (parseFloat(document.getElementById('banca').value) / ((Math.pow(multiplicador, entradas) - 1) / (multiplicador - 1))) * 14;

        const totalLucroMetaBrancos = lucroPorBranco * brancos;

        const lucro30Dias = totalLucroMetaBrancos * 30;

        document.getElementById('profitMessage').innerText = `Lucro por branco: R$ ${lucroPorBranco.toFixed(2)}`;
        document.getElementById('profitMessage').style.display = 'block';
        document.getElementById('profit30DaysMessage').innerText = `Lucro estimado em 30 dias: R$ ${lucro30Dias.toFixed(2)}`;
        document.getElementById('profit30DaysMessage').style.display = 'block';
        document.getElementById('totalProfitMessage').innerText = `Lucro total pela meta de brancos: R$ ${totalLucroMetaBrancos.toFixed(2)}`;
        document.getElementById('totalProfitMessage').style.display = 'block';
    }

    function limparTabela() {
        document.getElementById('banca').value = '';
        document.getElementById('entradas').value = '';
        document.getElementById('brancos').value = 0;
        document.getElementById('resultTable1').style.display = 'none';
        document.querySelector('#resultTable1 tbody').innerHTML = '';
        document.getElementById('alertMessage').innerText = '';
        document.getElementById('profitMessage').style.display = 'none';
        document.getElementById('profit30DaysMessage').style.display = 'none';
        document.getElementById('totalProfitMessage').style.display = 'none';
    }
</script>


</body>
</html>
