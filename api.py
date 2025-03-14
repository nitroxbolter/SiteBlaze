import json
import websocket
import time
import os
from datetime import datetime
import subprocess

# Iniciar monitor.py como um subprocess
subprocess.Popen(["python", "monitor.py"])

# Caminho do arquivo JSON onde os dados serão armazenados
file_path = r"C:\xampp\htdocs\dados.json"

# Variáveis globais
buffer = ""
processed_ids = set()

def on_message(ws, message):
    """Callback para mensagens recebidas."""
    try:
        process_message(message)
    except Exception as e:
        print(f"Erro ao processar a mensagem: {e}")

def on_error(ws, error):
    """Callback para erros."""
    print(f"Erro: {error}")

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

                            print(f"ID: {msg_id}, Minuto: {minuto}, Cor: {cor_resultado}, Roll: {roll_resultado}")

                            # Salva as informações em um arquivo JSON
                            save_to_json({
                                'id': msg_id,
                                'minute': minuto,
                                'color': cor_resultado,
                                'roll': roll_resultado
                            })
            else:
                buffer = ""
                break
    except Exception as e:
        print(f"Erro ao processar a mensagem: {e}")

def extract_relevant_info(data):
    try:
        payload = data[1].get('payload', {})
        if payload.get("status") != "rolling":
            return None

        created_at = payload.get("created_at")
        if created_at:
            created_at_dt = datetime.fromisoformat(created_at[:-1])
            minute = created_at_dt.minute

            return {
                "id": payload.get("id"),
                "color": payload.get("color"),
                "minute": minute,
                "roll": payload.get("roll")
            }
        return None
    except (KeyError, IndexError) as e:
        print(f"Erro ao extrair informações: {e}")
        return None

def save_to_json(data):
    """Salva os dados no arquivo JSON, mantendo no máximo 60 registros."""
    try:
        if not os.path.exists(file_path):
            existing_data = []
        else:
            try:
                with open(file_path, 'r', encoding='utf-8') as file:
                    existing_data = json.load(file)
            except json.JSONDecodeError:
                existing_data = []

        existing_data.append(data)
        if len(existing_data) > 60:
            existing_data.pop(0)

        with open(file_path, 'w', encoding='utf-8') as file:
            json.dump(existing_data, file, indent=4, ensure_ascii=False)
    except Exception as e:
        print(f"Erro ao salvar os dados no arquivo: {e}")

# Iniciar o WebSocket
start_websocket()
