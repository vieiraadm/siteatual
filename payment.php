<?php
session_start();

// Incluir o autoload do Composer corretamente
require_once 'composer/vendor/autoload.php';

use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPago;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;

// Definir o access token corretamente
MercadoPagoConfig::setAccessToken("<TEST-8058492724364836-042512-2b0b289b6413d5d1da9e85559140a58a-161918682>");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pix'])) {
    try {
        // Verificar se os dados da compra estão na sessão
        if (isset($_SESSION['compraDados']) && !empty($_SESSION['compraDados'])) {
            $compraDados = $_SESSION['compraDados'];
            $totalCompra = isset($compraDados['total']) ? $compraDados['total'] : 0;
            $nomeCliente = isset($_SESSION['nomeUsuario']) ? $_SESSION['nomeUsuario'] : '';
            $telefoneCliente = isset($_SESSION['telefoneUsuario']) ? $_SESSION['telefoneUsuario'] : '';

            // Inicializar o cliente de API
            $client = new PaymentClient();

            // Criar a matriz de solicitação
            $request = [
                
                
                "payment_method_id" => "pix",
                "payer" => [
                    "first_name" => $nomeCliente,
                    "phone" => [
                        "transaction_amount" => (float) $totalCompra,
                        "description" => "Planilhas excel",
                        "id" => "1010aa1010",
                        
                    ],
                ],
            ];

            // Realizar a solicitação de pagamento
            $payment = $client->create($request);

            // Exibir o resultado da criação do pagamento para depuração
            echo json_encode(array(
                'status'  => 'success',
                'message' => 'Payment processed successfully'
            ));
        } else {
            echo json_encode(array(
                'status'  => 'error',
                'message' => 'pix required'
            ));
            exit;
        }
    } catch (Exception $e) {
        echo json_encode(array(
            'status'  => 'error',
            'message' => 'Error processing payment: ' . $e->getMessage()
        ));
        exit;
    }

} else {
    echo json_encode(array(
        'status'  => 'error',
        'message' => 'pix required'
    ));
    exit;
}
?>
