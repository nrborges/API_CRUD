<?php
include "conexao.php"; 

$method = $_SERVER['REQUEST_METHOD'];

if($method === 'DELETE') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if (preg_match('/^[0-9a-fA-F-]{36}$/', $id)) {
            $sql = "DELETE FROM usuarios WHERE id = '$id'";
            if ($conn->query($sql)) {
                http_response_code(200);
                echo json_encode(["mensagem" => "Usuário excluído com sucesso!"], JSON_UNESCAPED_UNICODE);
            } else{
                http_response_code(500);
                echo json_encode(["erro" => "Erro ao excluir usuário."], JSON_UNESCAPED_UNICODE);
            }
        } else {
            http_response_code(400);
            echo json_encode(["erro" => "UUid inválido."], JSON_UNESCAPED_UNICODE);
        }
    } else {
            http_response_code(400);
            echo json_encode(["erro" => "Informe  ID do usuário."], JSON_UNESCAPED_UNICODE);
        }
}


?>