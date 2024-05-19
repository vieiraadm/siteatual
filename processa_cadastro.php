<?php
// Função para conectar ao banco de dados
function conectarBanco() {
    $host = "192.168.0.110";
    $usuario = "fcovieira";
    $senha = "Master3631@#Fvo";
    $banco = "bdsite";

    $conn = new mysqli($host, $usuario, $senha, $banco);

    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }

    return $conn;
}

// Função para verificar se o e-mail já está em uso
function verificarEmail($email, $conn) {
    $sql_verifica_email = "SELECT id FROM bdsite WHERE email = '$email'";
    $resultado = $conn->query($sql_verifica_email);

    if ($resultado === FALSE) {
        die("Erro na consulta SQL: " . $conn->error);
    }

    return $resultado->num_rows > 0;
}

// Conexão ao banco de dados
$conn = conectarBanco();

// Recebe os dados do formulário
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Verifica se o e-mail já está cadastrado
if (verificarEmail($email, $conn)) {
    echo json_encode(array("status" => "error", "message" => "E-mail já em uso"));
} else {
    // Prepara a consulta SQL para inserção dos dados
    $sql = "INSERT INTO bdsite (nome, sobrenome, email, senha) VALUES ('$nome', '$sobrenome', '$email', '$senha')";

    // Executa a consulta SQL
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("status" => "success", "message" => "Cadastro realizado com sucesso!"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Erro ao cadastrar: " . $conn->error));
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
