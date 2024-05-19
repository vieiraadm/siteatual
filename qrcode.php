<?php
session_start();

// Recuperar os dados da URL
$qr_code_base64 = isset($_GET['qr_code_base64']) ? $_GET['qr_code_base64'] : '';
$qr_code = isset($_GET['qr_code']) ? $_GET['qr_code'] : '';
$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';
$valor = isset($_GET['valor']) ? $_GET['valor'] : '';
$produto = isset($_GET['produto']) ? $_GET['produto'] : '';
$emailCliente = isset($_GET['emailCliente']) ? $_GET['emailCliente'] : '';
$nomeCliente = isset($_GET['nomeCliente']) ? $_GET['nomeCliente'] : '';

// Exibir os dados na página
echo "Detalhes da Compra:<br>";
echo "Produto: $produto<br>";
echo "Valor: $valor<br>";
echo "Email do Cliente: $emailCliente<br>";
echo "Nome do Cliente: $nomeCliente<br>";

// Exibir o QR Code
echo "<img src='$qr_code_base64' alt='QR Code'>";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Pagamento com PIX</title>
</head>

<body>
    <div class="container pt-3">
        <div class="card mb-3">
            <div class="card-header">
                Pagamentos com PIX
            </div>
            <div class="card-body">
                <?php
                // Verificar se há mensagem de erro na URL
                if (isset($_GET['erro'])) {
                    $erroMsg = urldecode($_GET['erro']);
                    echo "<p class='text-danger'>$erroMsg</p>";
                } else {
                    // Verificar se há dados de venda na URL
                    if (isset($_GET['qr_code_base64']) && isset($_GET['qr_code']) && isset($_GET['produto']) && isset($_GET['valor'])) {
                        $qr_code_base64 = $_GET['qr_code_base64'];
                        $qr_code = $_GET['qr_code'];
                        $produto = $_GET['produto'];
                        $valor = $_GET['valor'];

                        // Exibir os dados da venda
                        echo "<p>Escaneie o código abaixo para efetuar o pagamento:</p>";
                        echo "<p><strong>Produto:</strong> $produto</p>";
                        echo "<p><strong>Valor:</strong> R$ $valor</p>";
                        echo "<div class='row d-flex justify-content-center'>";
                        echo "<img src='data:image/jpeg;base64,$qr_code_base64' alt='QRCode' style='width: 300px;'>";
                        echo "</div>";
                    } else {
                        echo "<p class='text-danger'>Erro: Dados da venda não encontrados.</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
