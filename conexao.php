<?php
//conexão com o banco

$host = "localhost";
$user = "root";
$pass = "Nohby887069.";
$db = "sistema_cadastro";

$conn = new mysqli($host, $user, $pass, $db);

//validar conexão
if ($conn->connect_error){ 
    htpp_response_code(500);
    echo json_encode(["erro" => "Falha na conexão"], JSON_UNESCAPED_UNICODE);
    exit();
}
?>