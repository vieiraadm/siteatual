<?php
session_start();

// Incluir o autoload do Composer corretamente
require_once 'composer/vendor/autoload.php';

use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Item;

// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obter os dados do formulário
        $totalCompra = isset($_POST['totalCompra']) ? $_POST['totalCompra'] : 0;
        $tipoCompra = isset($_POST['tipoCompra']) ? $_POST['tipoCompra'] : '';
        $emailCliente = isset($_POST['emailCliente']) ? $_POST['emailCliente'] : '';
        $nomeCliente = isset($_POST['nomeCliente']) ? $_POST['nomeCliente'] : '';
        $sobrenomeCliente = isset($_POST['sobrenomeCliente']) ? $_POST['sobrenomeCliente'] : '';
        $telefoneCliente = isset($_POST['telefoneCliente']) ? $_POST['telefoneCliente'] : '';
        $chavevenda = isset($_POST['chavevenda']) ? $_POST['chavevenda'] : '';
        
// Definir o access token corretamente
MercadoPagoConfig::setAccessToken("TEST-8058492724364836-042512-2b0b289b6413d5d1da9e85559140a58a-161918682");

MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

// Inicializar o cliente de API
$client = new PaymentClient();
$request = [
        // Definir os dados do pagamento
        "transaction_amount" => 100,
        "payment_method_id " => "pix",
        "description" => "description",
        "installments" => 1,
        "payment_method_id" => "visa",
        "payer" => [
            "email" => "user@test.com",
                ]
            ];

              // Criar um novo pagamento
        $payment = $client->create($request);
      // Salvar o pagamento
     
        // Salvar o pagamento
        if ($payment) {
            $dados = [
            'qr_code_base64' => $payment->point_of_interaction->transaction_data->qr_code_base64 ?? '',
            'qr_code' => $payment->point_of_interaction->transaction_data->qr_code ?? '',
            'payment_id' => $payment->id,
            'valor' => $totalCompra,
            'produto' => 'Compra de Produto'
        ];
        // Redirecionar para a página de QRCODE com os dados
        header('Location: qrcode.php?' . http_build_query($dados));
        exit;
    } else {
        echo "Erro ao processar o pagamento.";
    }
} catch (Exception $e) {
    echo "Erro ao processar o pagamento: " . $e->getMessage();
}
} else {
echo "Método inválido para acessar esta página.";
}
?>
