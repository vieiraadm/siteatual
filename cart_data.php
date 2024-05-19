<?php
// Iniciar ou retomar a sessão
session_start();

// Verificar se há itens no carrinho
if (!empty($_SESSION['carrinho'])) {
    $cartItems = $_SESSION['carrinho'];
} else {
    $cartItems = []; // Carrinho vazio por padrão
}

// Função para calcular o total de itens no carrinho
function calcularTotalItens($cartItems) {
    $totalItems = 0;
    foreach ($cartItems as $item) {
        $totalItems += $item['quantidade'];
    }
    return $totalItems;
}

// Calcular o total de itens no carrinho
$totalItems = calcularTotalItens($cartItems);

// Retornar os dados em formato JSON
echo json_encode(['total_items' => $totalItems]);
?>
