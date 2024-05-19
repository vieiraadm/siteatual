<?php
session_start();

// Verificar se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar os dados do formulário
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $valor = $_POST['valor'] ?? '';

    // Verificar se todos os campos obrigatórios estão preenchidos e se os dados são válidos
    if (!empty($nome) && !empty($sobrenome) && !empty($email) && !empty($telefone) && is_numeric($valor)) {
        // Configurações de conexão ao banco de dados
        $host = "192.168.0.110"; // Endereço IPv6 do servidor MySQL
        $usuario_bd = "fcovieira";
        $senha_bd = "Master3631@#Fvo";
        $banco = "bdcompra";

        // Conectar ao banco de dados
        $conexao = new mysqli($host, $usuario_bd, $senha_bd, $banco);
        if ($conexao->connect_error) {
            die("Erro na conexão: " . $conexao->connect_error);
        }

        // Preparar e executar a inserção dos dados na tabela compras
        $inserir_dados = "INSERT INTO compras (nome, sobrenome, email, telefone, valor) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($inserir_dados);
        $stmt->bind_param("ssssd", $nome, $sobrenome, $email, $telefone, $valor);
        $resultado = $stmt->execute();

        // Verificar se a inserção foi bem-sucedida
        if ($resultado && $stmt->affected_rows > 0) {
            // Definir a variável $totalCompra após processar os dados do formulário
            $totalCompra = $valor;

            // Definir as variáveis de sessão para os dados da compra e do usuário
            $_SESSION['compraRegistrada'] = true;
            $_SESSION['totalCompra'] = $totalCompra;
            $_SESSION['nomeUsuario'] = $nome;
            $_SESSION['emailUsuario'] = $email;
            $_SESSION['telefoneUsuario']=$telefone;

            // Definir os dados da compra na sessão após processar os dados do formulário
            $_SESSION['compraDados'] = [
                'itens' => $_SESSION['carrinho'], // Itens do carrinho
                'total' => $totalCompra, // Total da compra
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone,
            ];

            // Redirecionar para a página comprafinal.php
            header("Location: comprafinal.php");
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao registrar a compra no banco de dados.']);
        }

        // Fechar a conexão com o banco de dados
        $stmt->close();
        $conexao->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Todos os campos do formulário devem ser preenchidos.']);
    }
} else {
    // Se o método não for POST, retornar erro
    echo json_encode(['status' => 'error', 'message' => 'Método não permitido para esta requisição.']);
}
?>
