from flask import Flask, request, jsonify
import requests

app = Flask(__name__)

def get_chatgpt_response(prompt):
    api_key = 'sk-proj-75SYZMTYr8HG91TaXQ61T3BlbkFJFp4ZENb69daQCX7Niz85'
    url = 'https://api.openai.com/v1/engines/davinci-codex/completions'

    headers = {
        'Content-Type': 'application/json',
        'Authorization': f'Bearer {api_key}',
    }

    data = {
        'prompt': prompt,
        'max_tokens': 1000,
        'n': 1,
        'stop': None,
        'temperature': 0.9,
    }

    response = requests.post(url, headers=headers, json=data)
    return response.json()['choices'][0]['text']

@app.route('/chatbot', methods=['POST'])
def chatbot():
    user_input = request.json.get('message')
    response_text = get_chatgpt_response(user_input)
    return jsonify({'response': response_text})

if __name__ == '__main__':
    app.run(debug=True)
