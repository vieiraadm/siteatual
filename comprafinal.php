<?php
session_start();

// Verificar se os dados da compra estão na sessão
if (isset($_SESSION['compraDados']) && !empty($_SESSION['compraDados'])) {
    $compraDados = $_SESSION['compraDados'];
    $totalCompra = isset($compraDados['total']) ? $compraDados['total'] : 0;
    $telefoneCliente = isset($_SESSION['telefoneUsuario']) ? $_SESSION['telefoneUsuario'] : '';
    $nomeCliente = isset($_SESSION['nomeUsuario']) ? $_SESSION['nomeUsuario'] : '';
    $emailCliente = isset($_SESSION['emailUsuario']) ? $_SESSION['emailUsuario'] : '';
    $sobrenomeCliente = isset($_SESSION['sobrenomeCliente']) ? $_SESSION['sobrenomeCliente'] : '';

    // Calcular a chave única da venda com no máximo 10 dígitos
    $ultimosDigitosTelefone = substr($telefoneCliente, -4); // Obter os últimos 4 dígitos do telefone
    $tamanhoChave = strlen((string) $totalCompra) + strlen($ultimosDigitosTelefone);
    $maxDigitos = 10;
    $numerosAleatorios = $maxDigitos - $tamanhoChave;

    // Gerar números aleatórios entre 1 e 10 para preencher a chave
    $chavevenda = (string) $totalCompra . $ultimosDigitosTelefone;
    for ($i = 0; $i < $numerosAleatorios; $i++) {
        $chavevenda .= mt_rand(1, 10); // Adiciona um número aleatório entre 1 e 10
    }

    // Limitar a chave ao tamanho máximo
    $chavevenda = substr($chavevenda, 0, $maxDigitos);

    // Remover pontos (.) da chave
    $chavevenda = str_replace('.', '', $chavevenda);

    // Verificar se a chave está completa
    if (strlen($chavevenda) < $maxDigitos) {
        // Preencher com números aleatórios para completar
        $numFaltantes = $maxDigitos - strlen($chavevenda);
        for ($i = 0; $i < $numFaltantes; $i++) {
            $chavevenda .= mt_rand(1, 10); // Adiciona um número aleatório entre 1 e 10
        }
    }
?>
 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Finalizada</title>
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
    </style>
</head>
<body>
<div class="container">
    <div class="buy-button-container">
         <button onclick="window.location.href='carrinho.php'">Home</button>
         </button>
        </form>
    </div>
   <?php if (!empty($compraDados['itens'])) : ?>
        <p>Itens Comprados:</p>
        <ul>
            <?php foreach ($compraDados['itens'] as $item) : ?>
                <li><?php echo "{$item['descricao']} - Quant: {$item['quantidade']} - Valor: R$ {$item['valor']}"; ?></li>
            <?php endforeach; ?>

            <p><strong>Tipo de compra:</strong> Compra de Planilha Personalizada</p> <!-- Novo título adicionado -->

        </ul>
        <p>Total da Compra: R$ <?php echo number_format($totalCompra, 2, ',', '.'); ?></p>
        <p>Nome: <?php echo $nomeCliente; ?> <?php echo $sobrenomeCliente; ?></p>
        <p>Email: <?php echo $emailCliente; ?></p>
        <p>Telefone: <?php echo $telefoneCliente; ?></p>
        <p>Chave Id: <?php echo $chavevenda; ?></p>
        <br>
           
             <!-- Formulário para enviar dados para processa_pix.php -->
            <form action="processa_pix.php" method="post">
                <input type="hidden" name="totalCompra" value="<?php echo $totalCompra; ?>">
                <input type="hidden" name="tipoCompra" value="Compra de Planilha Personalizada">
                <!-- Dados do cliente -->
                <input type="hidden" name="emailCliente" value="<?php echo $emailCliente; ?>">
                <input type="hidden" name="nomeCliente" value="<?php echo $nomeCliente; ?>">
                <input type="hidden" name="sobrenomeCliente" value="<?php echo $sobrenomeCliente; ?>">
                <input type="hidden" name="telefoneCliente" value="<?php echo $telefoneCliente; ?>">
                <!-- Chave Id -->
                <input type="hidden" name="chavevenda" value="<?php echo $chavevenda; ?>">

                <div class="container">
                <div class="buy-button-container">
                <!-- Botão "Pagar com PIX" -->
                <button type="submit">Pagar com PIX</button>
                </button>
        </form>
    </div>
            <br>
            <br>
            <br>
    <?php endif; ?>
</div>
</body>
</html>
<?php
    // Limpar os itens do carrinho após a finalização da compra
    unset($_SESSION['carrinho']);
    unset($_SESSION['totalCompra']);
    unset($_SESSION['nomeUsuario']);
    unset($_SESSION['emailUsuario']);
    unset($_SESSION['telefoneUsuario']);
    unset($_SESSION['sobrenomeUsuario']);
} else {
    echo "<p>Erro: Dados da compra não encontrados.</p>";

}

 ?>