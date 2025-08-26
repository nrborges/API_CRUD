<?php
include 'conexao.php';
require_once "gerarUuid.php";
require_once "validarSenha.php";
//vai rodar aplicações em json, padrão de português
header("Content-Type: application/json; charset=UTF-8");

//libera acesso a qualquer api e sistema
header("Access-Control-Allow-Origin *");

//acesso aos métodos (POST, GET, ...)
header("Access-Control-Allow-Methods: POST, PUT");

header("Access-Control-Allow-Headers: Content-Type");


//valida o metodo que vai ser usado (POST, GET, ...)
$method = $_SERVER["REQUEST_METHOD"];

//CREATE - POST
if($method == "POST"){

    //recebe os arquivos, le o conteudo bruto da requisição, transforma string em json e vira array associativo
    $data = json_decode(file_get_contents("php://input"), true);
    if(isset(
        //salva tudo na variável $data - cria um array
        $data['nome'],
        $data['email'],
        $data['senha'],
        $data['telefone'],
        $data['endereco'],
        $data['estado'],
        $data['data_nascimento']
    )){
        //salva tudo em outra variável - desestrutura o array
        $nome = $data['nome'];
        $email = $data['email'];

        //faz um if pra validação do email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            http_response_code(400);
            echo json_encode(['erro' => 'Email inválido. Formato esperado: seuemail@gmail.com.'], JSON_UNESCAPED_UNICODE);
            exit();
        }

        //tratamento email repetido (já cadastrado)
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($conn, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            http_response_code(400);
            echo json_encode(['erro' => 'Email já cadastrado.'], JSON_UNESCAPED_UNICODE);
            exit();
        }

    //pega a senha que o usuário enviou em JSON e guarda na variável $senhaForte
    $senhaForte = $data['senha'];

    //valida se a senha tem os requisitos de segrança
    if (!validarSenha($senhaForte)) {
        http_response_code(400);
        echo json_encode(['erro' => 'Senha inválida. Deve ter no mínimo 8 caracteres, 1 maiúscula e 1 especial (!@#$%&*?).'], JSON_UNESCAPED_UNICODE);
        exit();
    }
    //se a senha passar, é criptografada
    $senha = password_hash($senhaForte, PASSWORD_DEFAULT);

    $telefone = $data['telefone'];

        //faz um if pra validação do telefone 
        if(!preg_match('/^\(?\d{2}\)?\s?(9?\d{4})-?\d{4}$/', $telefone)){
            http_response_code(400);
            echo json_encode(['erro' => 'Telefone inválido. Formato esperado: (31) 98613-3282 ou 31985219436.'], JSON_UNESCAPED_UNICODE);
            exit();
        }

        $endereco = $data['endereco'];
        $estado = $data['estado'];
        $data_nascimento = $data['data_nascimento'];

        //validação da data de nascimento
        if(!DateTime::createFromFormat('Y-m-d', $data_nascimento)){
            http_response_code(400);
            echo json_encode(['erro' => 'Data de nascimento inválida. Use o formato YYYY-MM-DD.'], JSON_UNESCAPED_UNICODE);
            exit();
}


    }else {
        //retorna erro se algum campo vier vazio
        http_response_code(400);
        echo json_encode(['erro' => 'Todos os campos são obrigatórios'],
        JSON_UNESCAPED_UNICODE
    );
    exit();
    }

    //recebe a função de gerar o UUid
    $id = gerarUuid();

    //insere no banco
    $sql = "INSERT INTO usuarios (id, nome, email, senha, telefone, endereco, estado, data_nascimento)
    VALUES ('$id','$nome', '$email', '$senha', '$telefone', '$endereco', '$estado', '$data_nascimento')";


    if($conn->query($sql)){
        $result = $conn->query("SELECT id, nome, email, telefone, endereco, estado, data_nascimento, criado_em FROM usuarios WHERE id='$id'");
        $cliente = $result->fetch_assoc();
        echo json_encode(["mensagem" => "Cliente cadastrado com sucesso", "Cliente " => $cliente], JSON_UNESCAPED_UNICODE);
    }else{
        htpp_response_code(400);
        echo json_encode(["erro" => $conn->error], JSON_UNESCAPED_UNICODE);
    }

}


?>