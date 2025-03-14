import json
import websocket
import time
from datetime import datetime
import os

# Variáveis globais
buffer = ""
processed_ids = set()  # Conjunto para armazenar IDs já processados
file_path = r"C:\xampp\htdocs\dados.json"  # Caminho do arquivo JSON
ultimos_resultados = []  # Lista para armazenar os últimos 10 resultados
ultimo_sinal = None  # Variável para armazenar o último sinal enviado

# Definir padrões com identificadores e suas respectivas apostas
padroes_configurados = {
    1: {
        "sequencia": ["P", "P", "P", "P", "V"],
        "aposta": "⚫",  # Círculo preto
        "descricao": "Quebra ENTRADA NO ⚫"
    },
    2: {
        "sequencia": ["P", "P", "P", "P", "P", "V"],
        "aposta": "⚫",  # Círculo vermelho
        "descricao": "Dupla ENTRADA NO ⚫"
    },
    3: {
        "sequencia": ["V", "V", "V", "V", "P"],
        "aposta": "🔴",  # Círculo vermelho
        "descricao": "Qubra de Padão ENTRADA NO 🔴"
    },
    4: {
        "sequencia": ["V", "V", "V", "V", "V", "P"],
        "aposta": "🔴",  # Círculo vermelho
        "descricao": "Qubra de Padão ENTRADA NO 🔴"
    },
    5: {
        "sequencia": ["B"],
        "aposta": "⚪",  # Círculo vermelho
        "descricao": "Branco Duplo ENTRADA NO ⚪"
    },
    6: {
        "sequencia": ["B", "V"],
        "aposta": "⚪",  # Círculo vermelho
        "descricao": "Branco Banguela ENTRADA NO ⚪"
    },
    7: {
        "sequencia": ["B", "P"],
        "aposta": "⚪",  # Círculo vermelho
        "descricao": "Branco Banguela ENTRADA NO ⚪"
    },
    8: {
        "sequencia": ["B", "P", "P"],
        "aposta": "⚪",  # Círculo vermelho
        "descricao": "Branco Dentado ENTRADA NO ⚪"
    },
    9: {
        "sequencia": ["B", "P", "V"],
        "aposta": "⚪",  # Círculo vermelho
        "descricao": "Branco Dentado ENTRADA NO ⚪"
    },
    10: {
        "sequencia": ["B", "V", "P"],
        "aposta": "⚪",  # Círculo vermelho
        "descricao": "Branco Dentado ENTRADA NO ⚪"
    },
    11: {
        "sequencia": ["B", "V", "V"],
        "aposta": "⚪",  # Círculo vermelho
        "descricao": "Branco Dentado ENTRADA NO ⚪"
    }
}

def on_message(ws, message):
    """Callback para mensagens recebidas."""
    try:
        process_message(message)  # Processa a mensagem recebida
    except Exception as e:
        print(f"Erro ao processar a mensagem: {e}")

def on_error(ws, error):
    """Callback para erros."""
    print(f"Erro: {error}")  # Adicionando log de erro

def on_close(ws, close_status_code, close_msg):
    """Callback para fechamento da conexão."""
    print("Conexão fechada")

def on_open(ws):
    """Callback para conexão aberta."""
    subscribe_message = "420" + json.dumps(["cmd", {
        "id": "subscribe",
        "payload": {
            "room": "double_room_1"
        }
    }])
    ws.send(subscribe_message)

def start_websocket():
    """Inicia a conexão websocket e mantém o loop rodando."""
    websocket_url = "wss://api-gaming.blaze.bet.br/replication/?EIO=3&transport=websocket"
    ws = websocket.WebSocketApp(websocket_url,
                                on_open=on_open,
                                on_message=on_message,
                                on_error=on_error,
                                on_close=on_close)
    while True:
        try:
            ws.run_forever()
        except Exception as e:
            print(f"Erro ao manter a conexão: {e}. Tentando reconectar em 5 segundos...")
            time.sleep(5)

def process_message(message):
    global buffer
    buffer += message
    try:
        while buffer:
            if buffer.startswith("42"):  # Se a mensagem começar com "42"
                data = json.loads(buffer[2:])  # Carrega o conteúdo JSON ignorando os dois primeiros caracteres
                buffer = ""  # Limpa o buffer após processar a mensagem completa

                if isinstance(data, list) and len(data) > 1:
                    informacoes_relevantes = extract_relevant_info(data)
                    if informacoes_relevantes:
                        msg_id = informacoes_relevantes['id']

                        if msg_id not in processed_ids:
                            processed_ids.add(msg_id)  # Marca o ID como processado

                            minuto = informacoes_relevantes['minute']
                            cor_resultado = informacoes_relevantes['color']
                            roll_resultado = informacoes_relevantes['roll']

                            # Exibe a informação na tela
                            print(f"ID: {msg_id}, Minuto: {minuto}, Cor: {cor_resultado}, Roll: {roll_resultado}")

                            # Salva as informações em um arquivo JSON
                            save_to_json({
                                'id': msg_id,
                                'minute': minuto,
                                'color': cor_resultado,
                                'roll': roll_resultado
                            })

                            # Adiciona à lista dos últimos resultados
                            adicionar_resultado(informacoes_relevantes)

            else:
                buffer = ""  # Limpa o buffer se a mensagem não começar com "42"
                break
    except Exception as e:
        print(f"Erro ao processar a mensagem: {e}")

def extract_relevant_info(data):
    try:
        payload = data[1].get('payload', {})  # Acessa o campo 'payload' de forma segura
        if payload.get("status") != "rolling":  # Verifica se o status é "rolling"
            return None

        created_at = payload.get("created_at")
        if created_at:
            created_at_dt = datetime.fromisoformat(created_at[:-1])  # Remove o 'Z' do final
            minute = created_at_dt.minute

            # Adicionando o valor de 'roll' ao dicionário
            informacoes_relevantes = {
                "id": payload.get("id"),
                "color": payload.get("color"),  # Cor recebida no payload
                "minute": minute,
                "roll": payload.get("roll")  # Valor do roll
            }
            return informacoes_relevantes
        return None
    except (KeyError, IndexError) as e:
        print(f"Erro ao extrair informações: {e}")
        return None

def save_to_json(data):
    """Salva os dados no arquivo JSON."""
    try:
        # Verificar se o arquivo existe e se está vazio
        if not os.path.exists(file_path):
            existing_data = []
        else:
            try:
                with open(file_path, 'r', encoding='utf-8') as file:
                    existing_data = json.load(file)
            except json.JSONDecodeError:  # Caso o arquivo JSON esteja corrompido
                existing_data = []

        # Adiciona os novos dados
        existing_data.append(data)

        # Grava os dados no arquivo
        with open(file_path, 'w', encoding='utf-8') as file:
            json.dump(existing_data, file, indent=4, ensure_ascii=False)

        print(f"Dados salvos no arquivo JSON: {data}")
    except Exception as e:
        print(f"Erro ao salvar os dados no arquivo: {e}")

def converter_roll_para_cor(roll):
    """Converte o valor de roll para a cor correspondente."""
    if roll == 0:
        return "B"  # Cor preta (0)
    elif 1 <= roll <= 7:
        return "V"  # Cor verde (1 a 7)
    elif 8 <= roll <= 14:
        return "P"  # Cor preta (8 a 14)
    else:
        return "B"  # Se o valor de roll for fora da faixa, usa preto por padrão

def adicionar_resultado(dado):
    """Adiciona o dado na lista de últimos 10 resultados, convertendo o roll para a cor."""
    cor = converter_roll_para_cor(dado['roll'])  # Converte o valor do roll para a cor correspondente
    ultimos_resultados.append(cor)  # Armazena a cor

    # Mantém apenas os últimos 10 resultados
    if len(ultimos_resultados) > 10:
        ultimos_resultados.pop(0)

    # Exibe a lista atualizada dos últimos resultados
    print(f"Últimos resultados: {ultimos_resultados}")

    # Chama a função de monitoramento de padrões
    monitorar_padroes()

def monitorar_padroes():
    """Monitora os padrões nos últimos resultados."""
    global ultimo_sinal

    if len(ultimos_resultados) >= 5:  # Garantir que temos resultados suficientes para o maior padrão
        for padrao_id, config in padroes_configurados.items():
            sequencia = config["sequencia"]
            tamanho_padrao = len(sequencia)
            
            # Pegar os últimos N resultados, onde N é o tamanho do padrão
            ultimos_n = ultimos_resultados[-tamanho_padrao:]
            
            # Verificar se o padrão corresponde
            if ultimos_n == sequencia:
                # Mensagem modificada para usar o formato mais limpo
                novo_sinal = f"🎯 SINAL CONFIRMADO!\n\n{config['descricao']}"
                
                if novo_sinal != ultimo_sinal:
                    ultimo_sinal = novo_sinal
                    print(f"Padrão {padrao_id} detectado!")
                    print(f"Sequência encontrada: {ultimos_n}")
                    enviar_sinal(novo_sinal)
                else:
                    print("Aguardando novo padrão...")

def enviar_sinal(sinal):
    """Envia o sinal de aposta."""
    print("="*50)
    print("SINAL DETECTADO!")
    print(sinal)
    print("="*50)
    
    # Salvar o sinal em um arquivo
    sinal_data = {
        "mensagem": sinal,
        "timestamp": time.time(),
        "ativo": True
    }
    
    try:
        with open(r"C:\xampp\htdocs\sinal.json", 'w') as f:
            json.dump(sinal_data, f)
    except Exception as e:
        print(f"Erro ao salvar sinal: {e}")

# Iniciar o WebSocket
start_websocket()
