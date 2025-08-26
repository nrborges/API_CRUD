<?php
include "conexao.php"; 

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido.'], JSON_UNESCAPED_UNICODE);
    exit();
}

// Verifica se veio id via query string
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Busca um usuário específico
    $sql = "SELECT id, nome, email, telefone, endereco, estado, data_nascimento, criado_em FROM usuarios WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        echo json_encode($usuario, JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode(['erro' => 'Usuário não encontrado'], JSON_UNESCAPED_UNICODE);
    }
} else {
    // lista todos os usuários
    $sql = "SELECT id, nome, email, telefone, endereco, estado, data_nascimento, criado_em FROM usuarios";
    $result = $conn->query($sql);

    $usuarios = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }

    echo json_encode($usuarios, JSON_UNESCAPED_UNICODE);
}
exit();
