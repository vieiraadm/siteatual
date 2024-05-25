<?php
session_start();

// Defina constantes para valores fixos
define('ACCESS_TOKEN', 'APP_USR-8058492724364836-042512-d77de1b02689453247763d8c86dac56d-161918682');

require_once 'mercadopago/lib/mercadopago/vendor/autoload.php';

use MercadoPago\SDK;

// Variáveis para armazenar os valores do formulário
$totalCompra = $tipoCompra = $emailCliente = $nomeCliente = $sobrenomeCliente = $telefoneCliente = $chavevenda = '';

// Verifique se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize e validar os dados recebidos do formulário
    $totalCompra = isset($_POST['totalCompra']) ? floatval($_POST['totalCompra']) : 0;
    $tipoCompra = isset($_POST['tipoCompra']) ? $_POST['tipoCompra'] : '';
    $emailCliente = isset($_POST['emailCliente']) ? filter_var($_POST['emailCliente'], FILTER_SANITIZE_EMAIL) : '';
    $nomeCliente = isset($_POST['nomeCliente']) ? htmlspecialchars($_POST['nomeCliente']) : '';
    $sobrenomeCliente = isset($_POST['sobrenomeCliente']) ? htmlspecialchars($_POST['sobrenomeCliente']) : '';
    $telefoneCliente = isset($_POST['telefoneCliente']) ? preg_replace('/[^0-9]/', '', $_POST['telefoneCliente']) : '';
    $chavevenda = isset($_POST['chavevenda']) ? $_POST['chavevenda'] : '';

    SDK::setAccessToken(ACCESS_TOKEN);

    // Crie um array com os dados do pagamento
    $payment = [
        "transaction_amount" => $totalCompra,
        "description" => $tipoCompra,
        "payment_method_id" => "pix",
        "payer" => [
            "email" => $emailCliente,
            "first_name" => $nomeCliente,
            "last_name" => $sobrenomeCliente,
            "phone" => [
                "area_code" => "55",
                "number" => '+55' . $telefoneCliente
            ]
        ]
    ];

    // Use cURL para fazer a requisição com o cabeçalho X-Idempotency-Key
    $ch = curl_init('https://api.mercadopago.com/v1/payments');
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . ACCESS_TOKEN,
        'X-Idempotency-Key: ' . $chavevenda
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Verificar se a requisição foi bem-sucedida
    if ($httpCode == 201) {
        // Decodificar a resposta JSON
        $responseArray = json_decode($response, true);

        // Verificar se os dados do pagamento estão disponíveis na resposta
        if (!empty($responseArray['point_of_interaction']['transaction_data'])) {
            // Extrair os dados relevantes para exibir o QR Code e o link de pagamento
            $transactionData = $responseArray['point_of_interaction']['transaction_data'];
            $qr_code_base64 = $transactionData['qr_code_base64'] ?? '';
            $ticket_url = $transactionData['ticket_url'] ?? '';
            $code_pix = $transactionData['qr_code'] ?? '';
        } else {
            // Redirecionar para a página de erro
            header('Location: erro.php?erro=Erro ao obter dados de transação. Tente novamente.');
            exit();
        }
    } else {
        // Redirecionar para a página de erro
        header('Location: erro.php?erro=Erro ao processar pagamento. HTTP Code: ' . $httpCode);
        exit();
    }
} else {
    // Redirecionar para a página de erro
    header('Location: erro.php?erro=Método inválido para acessar esta página.');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento PIX</title>
    <style>
        /* Estilos de cores */
        :root {
            --cor-primaria: #663399; /* Roxo */
            --cor-secundaria: #663399; /* Roxo */
            --cor-texto: #333; /* Preto */
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 700px;
            margin: 20px auto;
            justify-content: center; /* Centralizar conteúdo na horizontal */
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        button:hover {
            background-color: #7c1da8;
            color: white;
        }
        .buy-button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            justify-content: center; /* Centralizar conteúdo na horizontal */
            gap: 30px; /* Adicionando espaçamento entre os botões */
        }
        .buy-button-container img {
            width: 80px;
            vertical-align: middle;
            margin-right: 25px;
        }
        .buy-button img {
            width: 40px;
            margin-right: 4px;
        }
        .cart-counter-number {
            background-color: green;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 14px;
            margin-left: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: var(--cor-texto);
        }
        input[type="text"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .checkout-button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: var(--cor-primaria);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .checkout-button:hover {
            background-color: green;
        }
        .texto-sobreposto {
            padding: 1px; /* Espaçamento interno */
            text-align: center; /* Alinhamento do texto ao centro */
            margin-top: 8px;
            font-size: 12px; /* Tamanho da fonte */
        }
        #base64image {
            display: block;
            margin: 0 auto; /* Centralizar horizontalmente */
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Exibir os dados na mesma página -->
    <div class="texto-sobreposto">
        <h2>Pagamento via PIX</h2>
        <div class="buy-button-container"></div>
        <h1>Para concluir o pagamento, basta realizar a leitura do QRcode pelo leitor do aplicativo de Pagamento</h1>
        <img style='display:block; width: 180px;' id='base64image' src='data:image/jpeg;base64, <?php echo $qr_code_base64; ?>' />
        <div class="texto-sobreposto">
            <h1>Ou use a opção abaixo “copiar” e “colar” no seu aplicativo de Pagamento</h1>
        </div>
        <button onclick="copyCodePix()">Copiar Código</button><p id='code_pix'><?php echo $code_pix; ?></p>
    </div>
    <div class="buy-button-container">
        <button onclick="window.location.href='index.php'">Home</button>
    </div>
</div>

<script>
    function copyCodePix() {
        var codePix = document.getElementById("code_pix");
        var range = document.createRange();
        range.selectNode(codePix);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();
    }
</script>

</body>
</html>
