<?php
session_start();

// Verificar se a requisição é do tipo POST e se o ID do produto foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['produto_id'])) {
    $produto_id = $_POST['produto_id'];


    // Configurações de conexão ao banco de dados
    $host = "192.168.0.110"; // Endereço IPv6 do servidor MySQL
    $usuario_bd = "fcovieira";
    $senha_bd = "Master3631@#Fvo";
    $banco = "bditem";

    // Conectar ao banco de dados
    $conexao = new mysqli($host, $usuario_bd, $senha_bd, $banco);
    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }

    // Consultar informações do produto no banco de dados
    $consulta_produto = "SELECT produto, descricao, estilo, valor FROM produtos WHERE produto = ?";
    $stmt = $conexao->prepare($consulta_produto);
    $stmt->bind_param("s", $produto_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar se o produto foi encontrado
    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $produto = $row['produto'];
        $descricao_produto = $row['descricao'];
        $estilo_produto = $row['estilo'];
        $valor_produto = $row['valor'];

        // Inicializar o carrinho se ainda não existir na sessão
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Adicionar o produto ao carrinho
        if (array_key_exists($produto, $_SESSION['carrinho'])) {
            $_SESSION['carrinho'][$produto]['quantidade']++;
        } else {
            $_SESSION['carrinho'][$produto] = [
                'produto_id' => $produto_id,
                'descricao' => $descricao_produto,
                'estilo' => $estilo_produto,
                'valor' => $valor_produto,
                'quantidade' => 1
            ];
        }

        $stmt->close();
        $conexao->close();

        // Retornar resposta JSON com sucesso e informações do produto
        $cartItems = $_SESSION['carrinho'];
        echo json_encode([
            'success' => true,
            'message' => 'Produto adicionado ao carrinho!',
            'produto_id' => $produto_id,
            'produto_descricao' => $descricao_produto,
            'produto_estilo' => $estilo_produto,
            'produto_valor' => $valor_produto,
            'cartItems' => $cartItems
        ]);
        exit;
    } else {
        // Produto não encontrado no banco de dados
        echo json_encode(['success' => false, 'message' => 'Produto não encontrado']);
        exit;
    }
} else {
    // Dados insuficientes na requisição
    echo json_encode(['success' => false, 'message' => 'Dados insuficientes']);
    exit;
}
?>
