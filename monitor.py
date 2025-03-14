import json
import time
import os

# Caminho do arquivo de dados
file_path = r"C:\xampp\htdocs\dados.json"

# Padrões configurados
padroes_configurados = {
    1: {"nome": "Quebra ENTRADA NO ⚫", "sequencia": ["P", "P", "P", "P", "V"], "cor_alvo": "⚫"},
    2: {"nome": "Dupla ENTRADA NO ⚫", "sequencia": ["P", "P", "P", "P", "P", "V"], "cor_alvo": "⚫"},
    3: {"nome": "Quebra de Padrão ENTRADA NO 🔴", "sequencia": ["V", "V", "V", "V", "P"], "cor_alvo": "🔴"},
    4: {"nome": "Branco Duplo ENTRADA NO ⚪", "sequencia": ["B"], "cor_alvo": "⚪"},
}

ultimo_id = None  # Variável global para armazenar o último ID

def converter_cor(cor):
    """Converte o valor da cor numérica para sua representação de letra."""
    return {0: "B", 1: "V", 2: "P"}.get(cor, "?")

def ler_ultimos_resultados():
    """Lê os últimos resultados do arquivo JSON e atualiza se houver um novo sinal com um ID diferente."""
    global ultimo_id  # Acessa a variável global
    
    if not os.path.exists(file_path):
        return []

    try:
        with open(file_path, 'r', encoding='utf-8') as file:
            dados = json.load(file)

            # Verifica se o arquivo contém uma lista de objetos
            if isinstance(dados, list):
                ultimos_resultados = []
                
                # Encontra o último item com número diferente de null
                ultimo_item = next((item for item in dados if item.get('number') is not None), None)
                
                if ultimo_item and ultimo_item.get("id") != ultimo_id:
                    # Só atualiza se encontrou um novo ID
                    ultimo_id = ultimo_item.get("id")
                    
                    # Coleta os últimos resultados
                    for dado in dados:
                        if isinstance(dado, dict):
                            ultimos_resultados.append(converter_cor(dado['color']))
                    
                    if ultimos_resultados:
                        print(f"Novo sinal detectado - ID: {ultimo_id}")
                        print(f"Últimos 15 resultados: {ultimos_resultados}")
                    return ultimos_resultados
                
                # Se não houve mudança no ID, retorna lista vazia para não processar novamente
                return []
            else:
                print(f"Erro: O conteúdo do arquivo JSON não é uma lista. Conteúdo: {dados}")
                return []
    except json.JSONDecodeError as e:
        print(f"Erro ao decodificar o JSON: {e}")
        return []
    except Exception as e:
        print(f"Erro ao ler o arquivo JSON: {e}")
        return []

def monitorar_padroes():
    """Monitora os padrões nos últimos 15 resultados."""
    print("Iniciando monitoramento...")
    while True:
        ultimos_resultados = ler_ultimos_resultados()

        # Verifica se a lista de resultados tem pelo menos 15 itens para monitorar
        if len(ultimos_resultados) >= 15:
            for padrao in padroes_configurados.values():
                sequencia = padrao["sequencia"]
                tamanho_padrao = len(sequencia)

                if ultimos_resultados[-tamanho_padrao:] == sequencia:
                    print(f"⚠️ Padrão detectado: {padrao['nome']}, Cor Alvo: {padrao['cor_alvo']}")

        time.sleep(2)  # Atualiza a cada 2 segundos

if __name__ == "__main__":
    monitorar_padroes()
