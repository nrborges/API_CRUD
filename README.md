
# API com PHP

Esta API foi desenvolvida em PHP para realizar operações de cadastro, listagem, consulta e exclusão de usuários.
Os usuários são identificados por UUIDs em vez de IDs numéricos.
Todos os retornos da API são em JSON e as requisições seguem o padrão REST.


## 🚀 Tecnologias usadas

- PHP
- MySQL
- Servidor Apache (XAMPP)



## 🌐 Base URL

Use o caminho do seu servidor, por exemplo:

- http://localhost/api.php
- http://seuservidor.com/api.php

## 📌 Cabeçalhos (Headers) Padrão

Headers enviados nas respostas

- Content-Type: application/json; charset=UTF-8

- Access-Control-Allow-Origin *

- Access-Control-Allow-Methods: POST, PUT

- Access-Control-Allow-Headers: Content-Type
## 🗄️ Banco de Dados



```sql
CREATE DATABASE IF NOT EXISTS sistema_cadastro;
USE sistema_cadastro;

CREATE TABLE usuarios (
ID CHAR PRIMARY KEY,,
nome VARCHAR(100) NOT NULL,
email VARCHAR(150) NOT NULL UNIQUE,
senha VARCHAR(255) NOT NULL,
telefone VARCHAR(200) NOT NULL,
endereco VARCHAR(100) NOT NULL,
estado CHAR(2) NOT NULL,
data_nascimento DATE NOT NULL, 
criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```




## ✅ Validações

- E-mail deve estar em formato válido (usuario@dominio.com)

- Senha mínimo 8 caracteres, 1 letra maiúscula e 1 caractere especial

- Telefone no formato (31) 98888-7777 ou 31988887777

- Data de Nascimento no formato YYYY-MM-DD
## 🔹 Criar Usuário

Para criar um novo usuário, rode o seguinte comando

```json
POST http://localhost/api/api.php
Content-Type: application/json

{
    "nome": "Ana Clara",
    "email": "anaclara5@gmail.com",
    "senha": "Nohby4591@",
    "telefone": "(31986538401",
    "endereco": "Rua A, 123",
    "estado": "MG",
    "data_nascimento": "2021-02-13"
}
```


## 🔹 Listar Usuários

Para listar todos os usuários, rode o seguinte comando

```json
GET http://localhost/api/listarUsuarios.php
Accept: application/json
```
## 🔹 Usuário por ID

Para buscar um usuário pelo ID, rode o seguinte comando

```json
GET http://localhost/api/listarUsuarios.php?id=
Accept: application/json
```
## 🔹 Deletar Usuário

Para deletar um usuário pelo ID, rode o seguinte comando

```json
DELETE http://localhost/api/deletarUsuario.php?id=
```
## ⚠️ Possíveis Erros

400 - Campo inválido ou obrigatório ausente

404 - Usuário não encontrado

405 - Método não permitido

500 - Erro interno no servidor
