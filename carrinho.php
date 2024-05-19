<?php
// Iniciar ou retomar a sessão
session_start();
// Inicializar o carrinho se ainda não existir na sessão
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}
// Verificar se o usuário está logado
if (isset($_SESSION['email'])) {
    // Se estiver logado, redirecionar para indexcliente.php se o botão de volta for clicado
    if (isset($_POST['voltarIndex'])) {
        header("Location: indexcliente.php");
        exit();
    }
} else {
    // Se não estiver logado, redirecionar para index.php se o botão de volta for clicado
    if (isset($_POST['voltarIndex'])) {
        header("Location: index.php");
        exit();
    }
}

// Verificar se há itens no carrinho
if (!empty($_SESSION['carrinho'])) {
    $cartItems = $_SESSION['carrinho'];
} else {
    $cartItems = []; // Carrinho vazio por padrão
}

// Função para atualizar a contagem de itens no carrinho
function updateCartCounter($cartItems) {
    $totalItems = 0;
    foreach ($cartItems as $item) {
        // Verificar se $item['quantidade'] é um número antes de somar
        if (is_numeric($item['quantidade'])) {
            $totalItems += $item['quantidade'];
        }
    }
    return $totalItems;
}

// Processamento do formulário de retorno ao index
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se o botão de voltar foi clicado
    if (isset($_POST['voltarIndex'])) {
        // Redirecionar para o index correspondente (indexcliente.php ou index.php)
        if (isset($_SESSION['email'])) {
            header("Location: indexcliente.php");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    }

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

    // Preparar e executar a inserção dos dados na tabela compras
    $inserir_dados = "INSERT INTO compras (nome, sobrenome, email, telefone, valor) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($inserir_dados);
    $stmt->bind_param("ssssd", $nome, $sobrenome, $email, $telefone, $valor);
    $resultado = $stmt->execute();

    // Verificar se a inserção foi bem-sucedida
    if ($resultado && $stmt->affected_rows > 0) {
        // Definir as variáveis de sessão para os dados da compra e do usuário
        $_SESSION['compraRegistrada'] = true;
        $_SESSION['totalCompra'] = $totalCompra;
        $_SESSION['nomeUsuario'] = $nome;
        $_SESSION['emailUsuario'] = $email;

        // Redirecionar para a página comprafinal.php
        header("Location: comprafinal.php");
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao registrar a compra no banco de dados.']);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
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
            padding: 1px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: var(--cor-primaria);
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .buy-button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            justify-content: center; /* Centralizar conteúdo na horizontal */
            gap: 30px; /* Adicionando espaçamento entre os botões */
        }
        .buy-button {
            display: flex;
            align-items: center;
            justify-content: center; /* Centralizar conteúdo na horizontal */
            padding: 3px;
            background-color: var(--cor-secundaria);
            color: white;
            border-radius: 8px;
            cursor: pointer;
            
        }
        .buy-button:hover {
            background-color: #7c1da8;

        }
        .buy-button1:hover {
            background-color: #7c1da8;
            display: flex;
            align-items: center;
            justify-content: center; /* Centralizar conteúdo na horizontal */
            padding: 3px;
            background-color: var(--cor-secundaria);
            color: white;
            border-radius: 8px;
            cursor: pointer;
                
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
            font-size: 25px;
       
   }
</style>
</head>
<body>
<script>
// Obter o valor de carrinho do PHP para JavaScript
var cartItemCount = <?php echo count($_SESSION['carrinho'] ?? []); ?>;

// Função para verificar se há itens no carrinho
function checkCartItems() {
    return cartItemCount > 0;
}
</script>
<div class="container">
    <h2>Carrinho de Compras</h2>
    <div class="buy-button-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <button type="submit" name="voltarIndex" class="buy-button1">
                <img src="imagens2/casa3d2.png" alt="Ícone home">
            </button>
        </form>
        <form method="post" action="carrinho.php">
            <div id="cart-count" class="cart-counter-number"><?php echo updateCartCounter($cartItems); ?></div>
            <img src="imagens2/carinho.png" alt="Ícone de Carrinho">
            </button>
        </form>
    </div>
    
    <div class="container">
    <div class="buy-button">
    <div id="cart-items" style="font-size: 14px;"> <!-- Adicionei o estilo diretamente aqui -->
           <?php
            // Inicializar variáveis para o total e subtotal
            $totalCompra = 0;

            // Exibindo os itens do carrinho
            foreach ($cartItems as $produto_id => $item) {
                // Verificar se os campos necessários estão presentes no item
                if (isset($item['quantidade'], $item['descricao'], $item['valor'])) {
                    // Certifique-se de que $item['valor'] seja numérico
                    if (!is_numeric($item['valor'])) {
                        // Trate aqui valores não numéricos, como converter para float
                        // Exemplo: $item['valor'] = floatval($item['valor']);
                        echo '<div>Erro: Valor do item não é numérico</div>';
                        continue; // Pula para a próxima iteração do loop
                    }
                    // Calcular subtotal para cada item
                    $subtotal = $item['quantidade'] * $item['valor'];
                    $totalCompra += $subtotal;
                    // Exibir o item simplificado com quantidade, descrição, estilo e valor
                   echo '<div>' . $item['produto_id'] . ' - X ' . $item['quantidade'] . ' - ' . $item['descricao'] . ' - ' . 
                   $item['estilo'] . ' - Valor: R$ ' . number_format($item['valor'], 2, ',', '.') . ' <button onclick="removeItem(\'' 
                   . htmlspecialchars($produto_id, ENT_QUOTES) . '\')">X</button></div>';
  
                } else {
                    // Exibir mensagem de erro para itens com dados ausentes
                    echo '<div>Erro: Valores inválidos para o item</div>';
                }
            }
            ?>
        </div>
    </div>
</div>
   <div class="texto-sobreposto">
   <div class="total">Total: R$ <?php echo number_format($totalCompra, 2, ',', '.'); ?></div>
</div>
 <!-- RMOVER ITENS DO CARRINHO -->
<script>
function removeItem(produtoId) {
    if (confirm('Deseja remover este item do carrinho?')) {
        // Enviar o ID do produto para remover_item.php via AJAX
        fetch('remover_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'produto_id=' + produtoId, // Enviar o ID do produto como parâmetro
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); // Depuração - Exibir resposta da requisição
            if (data.success) {
                alert(data.message); // Exibir mensagem de sucesso
                location.reload(); // Recarregar a página após a remoção
            } else {
                alert(data.message); // Exibir mensagem de erro
            }
        })
        .catch(error => {
            console.error('Erro ao remover o produto do carrinho:', error);
            alert('Erro ao remover o produto do carrinho.');
        });
    }
}
</script>
<div class="container">
<form id="checkoutForm" action="processa_compra.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="sobrenome">Sobrenome:</label>
        <input type="text" id="sobrenome" name="sobrenome" required><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required><br>

        <input type="hidden" id="valor" name="valor" value="<?php echo number_format($totalCompra, 2, '.', ''); ?>">
       
        <button id="validateCheckoutForm" class="checkout-button">FINALIZAR COMPRA</button>
        
     
    </form>
</div>
<!-- Scripts JavaScript -->
<script>

document.addEventListener('DOMContentLoaded', function() {
    var validateCheckoutBtn = document.getElementById('validateCheckoutForm');

    validateCheckoutBtn.addEventListener('click', function(event) {
        event.preventDefault();

        var nome = document.getElementById("nome").value;
        var sobrenome = document.getElementById("sobrenome").value;
        var email = document.getElementById("email").value;
        var telefone = document.getElementById("telefone").value;

        if (nome.trim() === "" || sobrenome.trim() === "" || email.trim() === "" || telefone.trim() === "") {
            // Exibir mensagem de erro se algum campo estiver vazio
            alert('Todos os campos do formulário devem ser preenchidos.');
        } else {
            // Adicione os dados do formulário ao action do formulário
            var checkoutForm = document.getElementById('checkoutForm');
            checkoutForm.action = 'processa_compra.php';
            checkoutForm.submit();
        }
    });
});

function processarCompra(formData) {
    fetch('processa_compra.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Criar um formulário dinamicamente
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'comprafinal.php';
            document.body.appendChild(form); // Adicionar o formulário ao corpo do documento

             // Submeter o formulário
            form.submit();
        } else {
            alert(data.message); // Exibir mensagem de erro do servidor
        }
    })
    .catch(error => {
        console.error('Erro ao enviar o formulário:', error);
        alert('Erro ao enviar o formulário. Verifique sua conexão.');
    });
}

  // Atualizar contagem de itens no carrinho
function updateCartCounter() {
    const cartCounter = document.querySelector('.cart-counter-number');
    const cartItems = <?php echo json_encode(array_values($cartItems)); ?>; // Garantir que seja um array
    let totalItems = 0;
    
    // Verificar se cartItems é um array antes de iterar sobre ele
    if (Array.isArray(cartItems)) {
        cartItems.forEach(item => {
            if (item && item.quantidade && typeof item.quantidade === 'number') {
                totalItems += item.quantidade;
            }
        });
    }
    cartCounter.textContent = totalItems;
}

// Chamar a função para atualizar contador quando necessário
updateCartCounter();

</script>

</body>
</html>