<?php
session_start();

// Verificar se a requisição é do tipo POST e se o ID do produto foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['produto_id'])) {
    $produto_id = $_POST['produto_id'];

    // Remover o produto do carrinho, se existir
    if (isset($_SESSION['carrinho'][$produto_id])) {
        unset($_SESSION['carrinho'][$produto_id]);
        $response = ['success' => true, 'message' => 'Produto removido do carrinho!'];
    } else {
        $response = ['success' => false, 'message' => 'Produto não encontrado no carrinho.'];
    }
} else {
    $response = ['success' => false, 'message' => 'ID do produto não enviado'];
}

// Enviar resposta JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
