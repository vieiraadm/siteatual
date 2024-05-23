<?php
session_start();

// Incluir o autoload do Composer corretamente
require_once 'composer/vendor/autoload.php';

use MercadoPago\Client\MercadoPagoClient;
use MercadoPago\Client\User\UserClient;
use MercadoPago\SDK;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Payment;

use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MercadoPagoException;

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
  // Inicializar o cliente de pagamento
  $paymentClient = new PaymentClient();
  // Criar um novo pagamento
  $payment = new Payment(); // Corrigi para usar a classe Payment do MercadoPago SDK
  $payment->transaction_amount = (float)$totalCompra;
  $payment->description = $tipoCompra;
  $payment->payment_method_id = "pix";
  $payment->payer = [
      "email" => $emailCliente,
      "first_name" => $nomeCliente,
      "last_name" => $sobrenomeCliente,
      "phone" => [
          "area_code" => "", // Pode ajustar o código de área se necessário
          "number" => $telefoneCliente
      ]
  ];

   
        // Verificar se o pagamento foi criado com sucesso
        if ($payment->status == 'pending') {
            $dados = [
                'qr_code_base64' => $payment->point_of_interaction->transaction_data->qr_code_base64 ?? '',
                'qr_code' => $payment->point_of_interaction->transaction_data->qr_code ?? '',
                'payment_id' => $payment->id,
                'valor' => $totalCompra,
                'produto' => $tipoCompra,
                'emailCliente' => $emailCliente,
                'nomeCliente' => $nomeCliente
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
