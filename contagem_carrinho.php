<?php
// Iniciar ou retomar a sessão
session_start();

// Verificar se a sessão do carrinho está presente
if (isset($_SESSION['carrinho'])) {
    // Calcular o total de itens no carrinho
    $totalItens = count($_SESSION['carrinho']);

    // Retornar a contagem em JSON
    echo json_encode(['totalItens' => $totalItens]);
} else {
    // Se não houver itens no carrinho, retornar zero
    echo json_encode(['totalItens' => 0]);
}
?>

