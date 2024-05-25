<?php

session_start();

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
        $totalItems += $item['quantidade'];
    }
    return $totalItems;
}    

$nomeUsuario = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Vendas de Planilhas - Baixe Gratuitamente alguns modelos- Futurainfobook Personaliza Planilhas Excel - Jogo Fácil Ouro - Home Office2024</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: white;
            overflow-x: hidden; /* Adiciona barra de rolagem horizontal */
            overflow-y: auto; /* Oculta a barra de rolagem na parte inferior */
        }
               /* Estilos para o texto sobreposto */
        .texto-sobreposto {
            background-color: RGB(107, 91, 149, 0.7); /* Cor de fundo escura */
            color: rgb(225, 235, 234); /* Cor do texto branco */
            padding: 1px; /* Espaçamento interno */
            text-align: center; /* Alinhamento do texto ao centro */
            margin-top: 8px;
            font-size: 10px;
            width: 100vw; /* 100% da largura da tela */
     
        }
            /* Estilos para o texto sobreposto */
        .texto-sobreposto1 {
            color: rgb(17, 16, 16); /* Cor do texto branco */
            padding: 15px; /* Espaçamento interno */
            text-align: center; /* Alinhamento do texto ao centro */
            font-size: 25px;
        }
                        /* Estilos para o texto sobreposto */
        .texto-sobreposto2 {
            color: rgb(17, 16, 16); /* Cor do texto branco */
            padding: 1px; /* Espaçamento interno */
            text-align: center; /* Alinhamento do texto ao centro */
            font-size: 22px;
        }
        .container {
            width: calc(100% - 100px);
            margin: 10px auto 0;
            padding: 50px;
            background: rgba(102, 51, 153, 0.3);
            opacity: 0.9;
            background-color: rgba(102, 51, 153, 0.9);
            background-size: cover;
            background-position: center;
            height: 300px;
            color: #fff;
            text-align: center;
            margin-top: 10px;
            font-size: 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end; /* Alinha os itens na extremidade inferior */
        }   
        .containerfooter {
            width: calc(100% - 100px);
            margin: 13px auto 0;
            padding: 60px;
            background: rgba(172, 178, 207, 0.774);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            opacity: 0.9;
            background-color: rgba(107, 91, 149, 0.9);
            background-size: cover;
            background-position: center;
            height: 300px;
            color: #fff;
            text-align: center;
            margin-top: 20px;
            font-size: 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end; /* Alinha os itens na extremidade inferior */
        }
        .banner1-wrapper {
            width: calc(100% - 0px);
            margin: 8px auto 0;
            padding: 8px;
            background-color: rgba(107, 91, 149, 0.7); /* Cor de fundo roxo com 80% de opacidade */
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            color: #fff;
        }  
        .banner1-text {
            flex-grow: 1; /* Para ocupar o espaço restante */
            font-size: 16px;
            color: #7c1da8;
            margin: 0;
            text-align: center; /* Centraliza o texto horizontalmente */
            padding-right: 6px;
            
        }
       .banner1-wrapper img {
            width: 40px;
            vertical-align: middle;
            margin-right: 25px;
            margin-right: 1px; /* Adiciona espaço à direita de cada botão */
        }
        .third-section {
            width: 90%;
            margin: 40px auto; /* Centraliza horizontalmente e adiciona espaço */
            display: flex;
            justify-content: space-between;
        }
        .model-box {
            width: calc(15% - 15px); /* Largura de cada módulo */
            height: 150px; /* Defina a altura desejada */
            position: relative;
            flex-grow: 1;
            padding: 5px;
            text-align: left;
            color: #fff;
            margin: 0 5px;
            transition: transform 0.2s ease;
            background: #333;
            border-radius: 5px;
        }
        /* Estilos para quando o mouse passa por cima */
        .model-box:hover {
            transform: translateY(-10px); /* Eleva a caixa ao passar o mouse */
        }
        .model-text {
            font-size: 14px; /* Altere o tamanho do texto conforme necessário */
        }
        .basic {
            background: linear-gradient(135deg, #ff3366, #663399);
        }
        .intermediate {
            background: linear-gradient(135deg, #3399ff, #33ccff);
        }
        .premium {
            background: linear-gradient(135deg, #66cc99, #339933);
        }
        .free {
            background: linear-gradient(135deg, #ff9933, #ffcc00);
        }
        .model-box2 {
            width: calc(15% - 15px);
            height: 150px;
            position: relative;
            flex-grow: 1;
            padding: 5px;
            text-align: left;
            margin: 0 5px;
            transition: transform 0.2s ease;
            background: #333;
            border-radius: 5px;
        }
        .model-box2:hover {
            transform: translateY(-10px);
        }
        .model-text2 {
            font-size: 14px;
            color: black; /* Define a cor do texto como preto */
        }
        /* Aplica o mesmo gradiente branco-verde claro para todos os módulos */
        .basic2, .intermediate2, .premium2, .free2 {
            background: linear-gradient(135deg, #ffffff, #b2d8d0);
        }
        /* Estilos para quando o mouse passa por cima */
        .model-box2:hover {
            transform: translateY(-10px); /* Eleva a caixa ao passar o mouse */
        }
        .model-text2 {
            font-size: 14px; /* Altere o tamanho do texto conforme necessário */
        }
        .basic2 {
            background: linear-gradient(135deg, #ffffff, #b2d8d0); /* Branco para um tom de verde claro */
        }
        .intermediate2 {
            background: linear-gradient(135deg, #ffffff, #b2d8d0); /* Branco para um tom de verde claro */
        }
        .premium2 {
            background: linear-gradient(135deg, #ffffff, #b2d8d0); /* Branco para um tom de verde claro */
        }
        .free2 {
            background: linear-gradient(135deg, #ffffff, #b2d8d0); /* Branco para um tom de verde claro */
        }
        .buy-button {
            background-color: #cccccc; /* Cinza claro */
            color: black; /* Cor da fonte preta */
            font-weight: bold; /* Negrito */
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin-top: 10px;
            border-radius: 5px;
            transition: background-color 0.3s; /* Adiciona transição suave */
        }
        .buy-button:hover {
            background-color: #7c1da8; /* verde ao passar o mouse */
            color: white; /* Cor da fonte branca ao passar o mouse */
        }
        .buy-button1 {
            background-color: #cccccc; /* Cinza claro */
            color: black; /* Cor da fonte preta */
            font-weight: bold; /* Negrito */
            padding: 4px 8px; /* TAMANHO DOS INONES HOME */
            text-align: right;
            text-decoration: none;
            display: inline-block;
            font-size: 13px;
            margin-top: 0;
            border-radius: 5px;
            transition: background-color 0.3s; /* Adiciona transição suave */
            margin-right: 60px; /* Adiciona DISTANCIA ENTRE ICONES DO HOME */
            position: relative; /* Define o contêiner do ícone do carrinho como relativo */
        }
        .buy-button1:hover {
            background-color: #7c1da8; /* roxo ao passar o mouse */
            color: white; /* Cor da fonte branca ao passar o mouse */
        }
        .add-to-cart {
            background-color: whitesmoke; /* Cinza claro */
            color: blue; /* Cor da fonte preta */
            font-weight: bold; /* Negrito */
            padding: 3px 6px; /* Tamanho do padding do botão */
            text-align: center;
            display: inline-block;
            font-size: 13px;
            margin-top: 0;
            transition: background-color 0.3s; /* Adiciona transição suave */
            margin-right: 60px; /* Adiciona distância entre os elementos */
            border: none; /* Remove a borda do botão */
            outline: none; /* Remove o contorno ao focar */
        }
            .add-to-cart:hover {
            background-color: green; /* Cor de fundo ao passar o mouse */
            color: white; /* Cor da fonte ao passar o mouse */
        }     
              /* Estilos para o contador do carrinho */
              #cart-count {
            position: absolute; /* Posiciona o contador de forma absoluta */
            top: -8px; /* Ajusta a posição vertical para alinhar com o ícone */
            right: -8px; /* Ajusta a posição horizontal para alinhar com o ícone */
            background-color: green; /* Adicione o estilo desejado para o contador */
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 28px;
            font-size: 12px; /* Tamanho da fonte */
            display: flex; /* Permite o uso de flexbox */
            justify-content: center; /* Centraliza horizontalmente o texto */
            align-items: center; /* Centraliza verticalmente o texto */
        }
        .footer {
            background-color: rgba(73, 7, 99, 0.747);
            color: white; /* Cor do texto branco */
            padding: 20px; /* Espaçamento interno */
            text-align: center; /* Alinhamento do texto ao centro */
            border-radius: 5px;
            margin-top: 100px;
            width: calc(100% - 100px);
            margin: 13px auto 0;
            padding: 60px;
        }
        .footer p {
            margin: 0; /* Remove margens */
        }
        .product-icon {
            position: absolute; /* Posição absoluta */
            right: 10px; /* Distância da borda direita */
            top: 50%; /* Alinhamento vertical no meio */
            transform: translateY(-50%); /* Ajuste para centralizar verticalmente */
        }
        .footer img {
            width: 40px;
            vertical-align: middle;
            margin-right: 25px;
        }
        .footer p {
            margin: 0;

        }
        .hide-content {
            display: none;
        }
            /* Exemplo de media query para dispositivos com largura máxima de 768px (tablets) */
            @media only screen and (max-width: 768px) {
            /* Seus estilos para tablets aqui */
        }
            /* Exemplo de media query para dispositivos com largura máxima de 480px (celulares) */
            @media only screen and (max-width: 480px) {
            /* Seus estilos para celulares aqui */
        }
            @keyframes blink {
            0% { color: red; }
            50% { color: blue; }
            100% { color: green; }
        }
            input[type="text"],
            input[type="email"],
            input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #f0f0f0; /* Cor de fundo cinza claro */
        }
            input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #663399; /* Roxo */
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s; /* Transição suave de cor ao passar o mouse */
        }
            input[type="submit"]:hover {
            background-color: #5a2d82; /* Roxo escuro ao passar o mouse */
        }
        .login-form {
            display: none; /* Inicialmente oculto */
            position: absolute;
            top: 58%; /* Ajuste na posição vertical */
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .close-btn {
            float: right; /* botao dos FORMULARIOS */
            cursor: pointer;
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }    
        .popup h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .popup p {
            margin-bottom: 20px;
        }
        .popup button {
            padding: 10px 20px;
            background-color: #7a00b3;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .popup button:hover {
            background-color: #7a00b3;
        }
   
  </style>
 </head>
 <body>
</div>
</div>
<div class="texto-sobreposto">
  <h1>A Futurainfobook é uma empresa comprometida na elaboração de Planilhas Excel - Modelos Personalizados Jogo Fácil Ouro - Home Office</h1>
 </div>
 <div class="container">
</div>
<div class="banner1-wrapper">
        <div class="banner1-text">
        <a href="indexcliente.php" class="buy-button1"><img src="imagens/casa3d2.png" alt="Ícone home" class="cart-icon"></a>
        <a href="paginaprodutos.php" class="buy-button1"><img src="imagens/lotosouro.png" alt="Ícone loto" class="cart-icon"></a>
              <a href="carrinho.php" class="buy-button1">
                <img src="imagens/carinho.png" alt="Ícone de Carrinho" class="cart-count">
                <div id="cart-count" class="cart-counter"><?php echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0; ?></div>
        </a>
        <a href="#" id="logoutButton" class="buy-button">Sair</a> <!-- Botão de logout -->
    </div>
</div>
</div>
<div class="banner1-text">
<br>
<div>Olá, <span id="email"class="cart-counter" style="font-size: 17px; color: green; margin: -25px 10px;"><?php echo $nomeUsuario; ?></span></h1></div>
<div class="texto-sobreposto1">
Adquira um modelo - Home-Office.
</div>
<div class="banner1-text">
<div class="third-section">
    <div class="model-box free">
        <h2 class="model-text">Modelos Grátis</h2>
        <p class="model-text">Planilhas básicas para iniciantes.</p>
        <a href="carrinho.php" class="buy-button">Baixar</a>
        <button class="add-to-cart" data-produto-id="loto1">=> Carrinho</button>
        
        <!-- Ícone do produto grátis -->
        <img src="imagens/01.png" alt="Ícone do Produto Grátis" class="product-icon">
    </div>
    <div class="model-box basic">
        <h2 class="model-text">Modelo Básico</h2>
        <p class="model-text">Conferência de Jogos e resultados.</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="loto2">=> Carrinho</button>
        <!-- Ícone do produto básico -->
        <img src="imagens/bas.png" alt="Ícone do Produto Básico" class="product-icon">
    </div>

<div class="model-box intermediate">
        <h2 class="model-text">Modelo Intermediário</h2>
        <p class="model-text">Análises dos últimos sorteios e planos de Jogos.</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="loto3">=> Carrinho</button>
        <!-- Ícone do produto intermediário -->
        <img src="imagens/inter01.png" alt="Ícone do Produto Intermediário" class="product-icon">
    </div>

    <div class="model-box premium" style="animation: blink 1s infinite;">
    <h2 class="model-text">Modelo Premium</h2>
    <p class="model-text">Análises aprofundadas e previsões.</p>
    <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="loto4">=> Carrinho</button>
    <!-- Ícone do produto avançado -->
       <img src="imagens/prem01.png" alt="Ícone do Produto Avançado" class="product-icon">
    </div>
</div>
<div class="banner1-text">
<div class="third-section">
    <div class="model-box2 free2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelos Grátis</h2>
        <p class="model-text2">Planilhas básicas para escritórios</p>
        <a href="carrinho.php" class="buy-button">Baixar</a>
        <button class="add-to-cart" data-produto-id="home1">=> Carrinho</button>
        <!-- Ícone do produto básico -->
        <img src="imagens/one.png" alt="Ícone do Produto Grátis" class="product-icon">
    </div>

    <div class="model-box2 basic2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelo Básico</h2>
        <p class="model-text2">RH - Recursos Humanos</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home2">=> Carrinho</button>
        <!-- Ícone do produto básico -->
        <img src="imagens/four.png" alt="Ícone do Produto Básico" class="product-icon">
    </div>

    <div class="model-box2 intermediate2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelo Intermediário</h2>
        <p class="model-text2">Análises dos últimos e dashboard</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home3">=> Carrinho</button>
        <!-- Ícone do produto intermediário -->
        <img src="imagens/two.png" alt="Ícone do Produto Intermediário" class="product-icon">
    </div>

    <div class="model-box2 premium2" style="background-color: #f5f5f5;">
        <h2 class="model-text2" style="animation: blink 1s infinite;">Modelo Premium</h2>
        <p class="model-text2" style="animation: blink 1s infinite;">Análises aprofundadas com dashboard e gráficos</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home4">=> Carrinho</button>
        <!-- Ícone do produto avançado -->
        <img src="imagens/five.png" alt="Ícone do Produto Avançado" class="product-icon">
    </div>
</div>
<div class="banner1-text">
<div class="third-section">
    <div class="model-box2 free2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelos Grátis</h2>
        <p class="model-text2">Planilhas básicas para escritórios</p>
        <a href="carrinho.php" class="buy-button">Baixar</a>
        <button class="add-to-cart" data-produto-id="home5">=> Carrinho</button>
        <!-- Ícone do produto básico -->
        <img src="imagens/one.png" alt="Ícone do Produto Grátis" class="product-icon">
    </div>

    <div class="model-box2 basic2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelo Básico</h2>
        <p class="model-text2">RH - Recursos Humanos</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home6">=> Carrinho</button>
        <!-- Ícone do produto básico -->
        <img src="imagens/four.png" alt="Ícone do Produto Básico" class="product-icon">
    </div>

    <div class="model-box2 intermediate2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelo Intermediário</h2>
        <p class="model-text2">Análises dos últimos e dashboard</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home7">=> Carrinho</button>
        <!-- Ícone do produto intermediário -->
        <img src="imagens/two.png" alt="Ícone do Produto Intermediário" class="product-icon">
    </div>

    <div class="model-box2 premium2" style="background-color: #f5f5f5;">
        <h2 class="model-text2" style="animation: blink 1s infinite;">Modelo Premium</h2>
        <p class="model-text2" style="animation: blink 1s infinite;">Análises aprofundadas com dashboard e gráficos</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home8">=> Carrinho</button>
        <!-- Ícone do produto avançado -->
        <img src="imagens/five.png" alt="Ícone do Produto Avançado" class="product-icon">
    </div>
</div>

<!-- Importação do jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Função para buscar o nome de usuário via AJAX
        $.ajax({
            url: 'get_result.php', // Corrigido para 'get_result.php' ou o nome correto do arquivo
            method: 'GET',
            success: function(data) {
                $('#email').text(data); // Atualiza o nome de usuário na página
            }
        });

        // Evento de clique no botão de logout
        $('#logoutButton').click(function(e) {
            e.preventDefault(); // Previne o comportamento padrão do link
            $.ajax({
                url: 'logout.php', // Página PHP para realizar logout
                method: 'GET',
                success: function() {
                    // Redireciona para a página de login após o logout
                    window.location.href = 'index.php';
                }
            });
        });
    });

    // AJAX para manter a sessão ativa a cada 5 minutos
    setInterval(function() {
        $.ajax({
            url: 'keep_session_alive.php',
            method: 'GET',
        });
    }, 300000); // 5 minutos em milissegundos

    window.addEventListener('beforeunload', function(e) {
        $.ajax({
            url: 'logout.php',
            method: 'GET',
            async: false, // Síncrono para garantir logout antes de fechar a página
        });
    });

</script>    

 <!-- COLOCAR NO FINAL CARRINHO   -->
<script>
    $(document).ready(function(){
        $(".add-to-cart").click(function(){
            var produtoId = $(this).data("produto-id");
            var descricaoProduto = $(this).data("descricao");

            $.ajax({
                url: 'adicionar_item.php',
                method: 'POST',
                data: { produto_id: produtoId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        mostrarPopup(response.message, descricaoProduto);
                        updateCartCounter();
                    } else {
                        alert('Erro ao adicionar o produto ao carrinho.');
                    }
                },
                error: function() {
                    alert('Erro ao adicionar o produto ao carrinho. Tente novamente mais tarde.');
                }
            });
        });

        function mostrarPopup(mensagem, descricao) {
            $('#popupMessage').text(mensagem);
            $('#popupDescricao').text(descricao);
            $('#popup').addClass('active').show();
        }
        function updateCartCounter() {
            $.ajax({
                url: 'cart_data.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.total_items) {
                        $('#cart-count').text(response.total_items);
                    }
                },
                error: function() {
                    alert('Erro ao obter os dados do carrinho. Tente novamente mais tarde.');
                }
            });
        }

        updateCartCounter();
        
    
    });
</script>

<!-- Pop-up para exibir o item adicionado ao carrinho -->
<div id="popup" class="popup" style="display: none;">
    <div class="popup-content">
        <!-- Botão para fechar o pop-up -->
        <button onclick="closePopup()" class="close-btn">&times;</button>
        <p id="popupMessage"></p>
        <p id="popupDescricao"></p> <!-- Adiciona a descrição do produto aqui -->
    </div>
</div>

<script>
    // Função para fechar o pop-up
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }
</script>
<!--       TELAS  -->
<script>
    const imageList = ['imagens/teste3.jpg', 'imagens/teste4.jpg', 'imagens/teste5.jpg'];
    let currentIndex = 0;

    function changeImage() {
        const container = document.querySelector('.container');
        container.style.backgroundImage = `url('${imageList[currentIndex]}')`;

        currentIndex = (currentIndex + 1) % imageList.length;
    }

    setInterval(changeImage, 9000);
    changeImage(); // Chama a função para exibir a primeira imagem imediatamente
</script>

<div class="containerfooter">
    <h2 style="font-size: 20px; color: white; margin: 25px 0;">Informações de Contato:</h2>
    <div class="contact-box">
        <p style="font-size: 16px; margin-bottom: 4px; color: white;">Fale com nossa equipe de atendimento ao cliente. Use este formulário ou entre em contato direto por e-mail.</p>
        <br>
        <br>
        <br>
        <form>
            <div>
                <div style="display: flex; flex-wrap: wrap; align-items: flex-start; height: 100px;">
                    <div style="flex: 0 0 calc(12% - 12px); margin-right: 2px; margin-bottom: 1px; text-align: left;">
                        <label for="Inome" style="color: white;">Nome:</label>
                        <input type="text" id="Inome" name="firstname" placeholder="Seu nome..." style="width: 86%; background-color: #D3D3D3; color: black;">
                    </div>
                    <div style="flex: 0 0 calc(12% - 12px); margin-right: 2px; margin-bottom: 1px; text-align: left;">
                        <label for="Isobrenome" style="color: white;">Sobrenome:</label>
                        <input type="text" id="Isobrenome" name="lastname" placeholder="Seu sobrenome..." style="width: 86%; background-color: #D3D3D3; color: black;">
                    </div>
                    <div style="flex: 0 0 calc(16% - 16px); margin-right: 2px; margin-bottom: 1px; text-align: left;">
                        <label for="Iemail" style="color: white;">Email:</label>
                        <input type="text" id="Iemail" name="Iemail" placeholder="Seu email..." style="width: 90%; background-color: #D3D3D3; color: black;">
                    </div>
                    <div style="flex: 0 0 calc(20% - 18px); margin-right: 2px; margin-bottom: 1px; text-align: left;">
                        <label for="Imenssagem" style="color: white;">Mensagem:</label>
                        <textarea id="text" name="Imenssagem" placeholder="Sua mensagem..." style="width: 90%; background-color: #D3D3D3; color: black;"></textarea>
                    </div>
                    <a href="" class="buy-button" style="width: 80px; margin-top: 25px;">Enviar</a>
                    </div>
            </div>
        </form>
</div>
</div>
</div>
    <div class="footer">
    <h2 style="font-size: 18px; color: white; margin: -44px 0 10px;">Informações do Site</h2>
    <p style="font-size: 16px; color: white; margin: 0;">suporte@futurainfobook.com.br</p>
    <p style="font-size: 14px; color: white; margin: 0;">(86) 98164-9015</p>
    <h2 style="font-size: 14px; color: white; margin: 0;">Teresina - PI</h2>
    <br>
    <div>&copy; 2024 Futura Infobook - Todos os direitos reservados</p>
    <br>
    <img src="imagens/bas.png" alt="Ícone de Carrinho" class="cart-icon"></a>
</div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/react.production.min.js"></script>
    <script src="js/react-dom.production.min.js"></script>
    
</body>
</html>

