# Testes Automatizados

## 1 - Como Iniciar o Docker

Este parte já cria um banco no formato da aplicação infoinova.

Entre na pasta "/testes" via terminal e inicie o Docker com o seguinte comando:

>> docker-compose up

A aplicação estará disponível em http://127.0.0.1 :
- http://127.0.0.1/test_index.php (deve mostrar as informações do PHP)
- http://127.0.0.1/test_dbtest.php (deve mostrar "Array ( [0] => ... [1] => ... )")

Em http://127.0.0.1:8000 , é possível acessar o PHPMYADMIN para consultar o banco de dados MySQL.
- username: tutorial
- password: secret

## 2 - Executando os Testes

Caso não tenha o Robot instalado, instale o Python3 e execute:

>> pip install -r requirements.txt

Com a aplicação executando via Docker, execute:

>> robot test_*.robot

## Como resolver possíveis erros:

Ao iniciar o Docker, é possível que aconteça erros de "already used address". Tente:

- Parar todas as imagens do Docker 
    >> docker stop $(docker ps -a -q)

- Parar um servidor Mysql local
    >> sudo service mysql stop