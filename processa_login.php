<?php
session_start();

// Informações de conexão ao banco de dados
$host = "192.168.0.110"; // Endereço IPv6 do servidor MySQL
$usuario_bd = "fcovieira";
$senha_bd = "Master3631@#Fvo";
$banco = "bdsite";

// Conexão ao banco de dados
$conn = new mysqli($host, $usuario_bd, $senha_bd, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
} else {
    echo "Conexão ao banco de dados estabelecida com sucesso!<br>";
}

// Recebe os dados do formulário de login
$email_informado = $_POST['email'];
$senha_informada = $_POST['password'];

// Evita SQL injection utilizando prepared statements
$stmt = $conn->prepare("SELECT * FROM bdsite WHERE email=? AND senha=?");
$stmt->bind_param("ss", $email_informado, $senha_informada);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se encontrou algum registro
if ($result->num_rows > 0) {
    echo "Usuário autenticado com sucesso!<br>";
    // Obtém os dados do usuário
    $exibeUsuario = $result->fetch_assoc();
    // Armazena o nome de usuário na sessão
    $_SESSION['email'] = $exibeUsuario['email'];
    // Usuário e senha válidos, redireciona para a página principal
    header("Location: indexcliente.php");
    exit();
} else {
    echo "Erro de autenticação: Usuário ou senha inválidos!<br>";
    // Usuário ou senha inválidos, redireciona para a página de login com um parâmetro de erro
    header("Location: index.php?error=1");
    exit();
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
