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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Vendas de Planilhas - Baixe Gratuitamente alguns modelos- Futurainfobook Personaliza Planilhas Excel - Jogo Fácil Ouro - Home Office2024</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/react.production.min.js"></script>
    <script src="js/react-dom.production.min.js"></script>
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
            margin: 13px auto 0;
            padding: 60px;
            background: rgba(102, 51, 153, 0.3);
            opacity: 0.9;
            background-color: rgba(102, 51, 153, 0.9);
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
            margin: 10px auto 0;
            padding: 10px;
            background-color: rgba(107, 91, 149, 0.7); /* Cor de fundo roxo com 80% de opacidade */
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            color: #fff;
        }  
        .banner1-text {
            flex-grow: 1; /* Para ocupar o espaço restante */
            font-size: 26px;
            margin: 0;
            text-align: center; /* Centraliza o texto horizontalmente */
            padding-right: 10px; 
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
            font-size: 15px;
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
 <div class="texto-sobreposto2" style="animation: blink 1s infinite;">
      <P>A Futurainfobook elabora Planilhas Excel - Modelos Personalizados - Adquira um modelo Já! Temos modelos grátis..</p>
 <div class="container">

        </div>
    </div>
</div>
</div>
<div class="banner1-wrapper">
    <div class="banner1-text">
        <a href="#" onclick="showLoginForm()" class="buy-button1"><img src="imagens2/userlogin.png" alt="Ícone de login" class="cart-icon"></a>
        <a href="carrinho.php" class="buy-button1">
                <img src="imagens2/carinho.png" alt="Ícone de Carrinho" class="cart-count">
                <div id="cart-count" class="cart-counter"><?php echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0; ?></div>
                 
        </a>
        <a href="#" onclick="showCadastroForm()" class="buy-button">Cadastre-se</a>
    </div>
</div>
</div>
<div class="texto-sobreposto1">
Adquira um modelo - Loterias Ouro.
</div>
<div class="third-section">
    <div class="model-box free">
        <h2 class="model-text">Modelos Grátis</h2>
        <p class="model-text">Planilhas básicas para iniciantes.</p>
        <a href="carrinho.php" class="buy-button">Baixar</a>
        <button class="add-to-cart" data-produto-id="loto1">=> Carrinho</button>
        <!-- Ícone do produto grátis -->
        <img src="imagens2/01.png" alt="Ícone do Produto Grátis" class="product-icon">
    </div>
    <div class="model-box basic">
        <h2 class="model-text">Modelo Básico</h2>
        <p class="model-text">Conferência de Jogos e resultados.</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="loto2">=> Carrinho</button>
        <!-- Ícone do produto básico -->
        <img src="imagens2/bas.png" alt="Ícone do Produto Básico" class="product-icon">
    </div>

<div class="model-box intermediate">
        <h2 class="model-text">Modelo Intermediário</h2>
        <p class="model-text">Análises dos últimos sorteios e planos de Jogos.</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="loto3">=> Carrinho</button>
        <!-- Ícone do produto intermediário -->
        <img src="imagens2/inter01.png" alt="Ícone do Produto Intermediário" class="product-icon">
    </div>

    <div class="model-box premium" style="animation: blink 1s infinite;">
    <h2 class="model-text">Modelo Premium</h2>
    <p class="model-text">Análises aprofundadas e previsões.</p>
    <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="loto4">=> Carrinho</button>
    <!-- Ícone do produto avançado -->
    <img src="imagens2/prem01.png" alt="Ícone do Produto Avançado" class="product-icon">
    </div>
  </div>
    <div class="texto-sobreposto1">
        Adquira um modelo - Home Office.
        </div>
    </div>
<div class="third-section">
    <div class="model-box2 free2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelos Grátis</h2>
        <p class="model-text2">Planilhas básicas para escritórios</p>
        <a href="carrinho.php" class="buy-button">Baixar</a>
        <button class="add-to-cart" data-produto-id="home1">=> Carrinho</button>
        <!-- Ícone do produto básico -->
        <img src="imagens1/one.png" alt="Ícone do Produto Grátis" class="product-icon">
    </div>

    <div class="model-box2 basic2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelo Básico</h2>
        <p class="model-text2">RH - Recursos Humanos</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home2">=> Carrinho</button>
        <!-- Ícone do produto básico -->
        <img src="imagens1/four.png" alt="Ícone do Produto Básico" class="product-icon">
    </div>

    <div class="model-box2 intermediate2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelo Intermediário</h2>
        <p class="model-text2">Análises dos últimos e dashboard</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home3">=> Carrinho</button>
        <!-- Ícone do produto intermediário -->
        <img src="imagens1/two.png" alt="Ícone do Produto Intermediário" class="product-icon">
    </div>

    <div class="model-box2 premium2" style="background-color: #f5f5f5;">
        <h2 class="model-text2" style="animation: blink 1s infinite;">Modelo Premium</h2>
        <p class="model-text2" style="animation: blink 1s infinite;">Análises aprofundadas com dashboard e gráficos</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home4">=> Carrinho</button>
        <!-- Ícone do produto avançado -->
        <img src="imagens1/five.png" alt="Ícone do Produto Avançado" class="product-icon">
    </div>
</div>
<div class="third-section">
    <div class="model-box2 free2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelos Grátis</h2>
        <p class="model-text2">Planilhas básicas para escritórios</p>
        <a href="carrinho.php" class="buy-button">Baixar</a>
        <button class="add-to-cart" data-produto-id="home5">=> Carrinho</button>
        <!-- Ícone do produto básico -->
        <img src="imagens1/one.png" alt="Ícone do Produto Grátis" class="product-icon">
    </div>

    <div class="model-box2 basic2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelo Básico</h2>
        <p class="model-text2">RH - Recursos Humanos</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home6">=> Carrinho</button>
        <!-- Ícone do produto básico -->
        <img src="imagens1/four.png" alt="Ícone do Produto Básico" class="product-icon">
    </div>

    <div class="model-box2 intermediate2" style="background-color: #f5f5f5;">
        <h2 class="model-text2">Modelo Intermediário</h2>
        <p class="model-text2">Análises dos últimos e dashboard</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home7">=> Carrinho</button>
        <!-- Ícone do produto intermediário -->
        <img src="imagens1/two.png" alt="Ícone do Produto Intermediário" class="product-icon">
    </div>

    <div class="model-box2 premium2" style="background-color: #f5f5f5;">
        <h2 class="model-text2" style="animation: blink 1s infinite;">Modelo Premium</h2>
        <p class="model-text2" style="animation: blink 1s infinite;">Análises aprofundadas com dashboard e gráficos</p>
        <a href="carrinho.php" class="buy-button">Comprar</a>
        <button class="add-to-cart" data-produto-id="home8">=> Carrinho</button>
        <!-- Ícone do produto avançado -->
        <img src="imagens1/five.png" alt="Ícone do Produto Avançado" class="product-icon">
    </div>
</div>

<!-- Formulário de cadastro -->
<div id="cadastroForm" style="display: none;" class="login-form">
    <button onclick="closeCadastroForm()" class="close-btn" style="background-color: #5a2d82; color: #fff; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer;">&times;</button>
    <h1>Cadastro</h1>
    <form id="cadastroFormulario" action="processa_cadastro.php" method="post" onsubmit="return validarCadastro()">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="sobrenome">Sobrenome:</label>
        <input type="text" id="sobrenome" name="sobrenome" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Use um Email Válido!"><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>
    <!-- Popup de cadastro realizado -->
    <div id="popupCadastro" class="popup" style="display: none;">
        <div class="popup-content">
            <a>Cadastro realizado com sucesso!</a>
        </div>
    </div>
</div>
<script>
    function validarCadastro() {
        var nome = document.getElementById("nome").value;
        var sobrenome = document.getElementById("sobrenome").value;
        var email = document.getElementById("email").value;
        var senha = document.getElementById("senha").value;

        if (nome === "" || sobrenome === "" || email === "" || senha === "") {
            alert("Por favor, preencha todos os campos obrigatórios.");
            return false;
        }

        return true;
    }

    document.getElementById("cadastroFormulario").addEventListener("submit", function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        var formulario = this;
        if (validarCadastro()) {
            var xhr = new XMLHttpRequest();
            xhr.open(formulario.method, formulario.action, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        // Exibir mensagem de sucesso
                        document.getElementById("popupCadastro").style.display = "block";
                        formulario.reset(); // Limpar o formulário
                        setTimeout(function() {
                            document.getElementById("popupCadastro").style.display = "none"; // Ocultar o popup após 3 segundos
                            // Fechar o formulário de cadastro
                            document.getElementById("cadastroForm").style.display = "none";
                        }, 1500); // Aguarda 3 segundos antes de fechar o formulário
                    } else {
                        // Exibir mensagem de erro
                        document.getElementById("mensagemErro").innerText = response.message;
                        document.getElementById("popupErro").style.display = "block";
                    }
                } else {
                    console.error("Erro ao enviar formulário:", xhr.statusText);
                }
            };
            xhr.onerror = function() {
                console.error("Erro ao enviar formulário.");
            };
            xhr.send(new FormData(formulario)); // Enviar dados do formulário
        }
    });

    function closeCadastroForm() {
        document.getElementById("cadastroForm").style.display = "none";
    }

    function fecharPopupErro() {
    document.getElementById("popupErro").style.display = "none";
    }

</script>
<!-- Formulário recupera -->
<div id="recuperaForm" class="login-form" style="display: none;">
    <button onclick="closeRecuperaForm()" class="close-btn" style="background-color: #5a2d82; color: #fff; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer;">&times;</button>
    <a>Recuperar Senha..</a>
    <form action="recover_password.php" method="post" onsubmit="return valiRecuperaForm()">
        <label for="emailrecu">Digite seu Email:</label>
        <input type="email" id="emailrecu" name="emailrecu"><br>
        <input type="submit" value="Enviar"><br>
    </form>
</div>

<script>
    function showRecuperaForm() {
        document.getElementById('recuperaForm').style.display = 'block';
        document.getElementById('loginForm').style.display = 'none'; // Oculta o formulário de login
    }

    function closeRecuperaForm() {
        document.getElementById('recuperaForm').style.display = 'none';
        document.getElementById('loginForm').style.display = 'block'; // Exibe o formulário de login novamente
    }

    function valiRecuperaForm() {
    var emailRecu = document.getElementById("emailrecu").value.trim();
    if (emailRecu === "") {
        // Exibir a mensagem em um pop-up na tela
        document.getElementById('popupMessage').innerText = "Por favor, preencha o campo de email para recuperar a senha.";
        document.getElementById('popup').style.display = 'block';
        return false; // Impede o envio do formulário se o campo estiver vazio
    }

    // Enviar o formulário usando AJAX para recuperar_password.php
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            if (response.success) {
                // Exibir a mensagem de sucesso em um pop-up na tela
                document.getElementById('popupMessage').innerText = response.message;
                document.getElementById('popup').style.display = 'block';
            } else {
                // Exibir a mensagem de erro em um pop-up na tela
                document.getElementById('popupMessage').innerText = response.message;
                document.getElementById('popup').style.display = 'block';
            }
        }
    };
    xhr.open("POST", "recover_password.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("emailrecu=" + emailRecu);

    return false; // Impede o envio normal do formulário
    }

    function closeLoginForm() {
        document.getElementById('loginForm').style.display = 'none';
    }

    function showCadastroForm() {
        // Adicione sua lógica aqui para exibir o formulário de cadastro, se necessário
        alert("Exibir formulário de cadastro");
    }

    function closePopup(popupId) {
        document.getElementById(popupId).style.display = 'none';
    }
</script>


<!-- Formulário de login -->
<div id="loginForm" class="login-form">
    <button onclick="closeLoginForm()" class="close-btn" style="background-color: #5a2d82; color: #fff; border: none; border-radius: 5px; padding: 5px 10px; cursor: pointer;">&times;</button>
    <h1>Login</h1>
    <form action="processa_login.php" method="post" onsubmit="return validateForm()">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email"><br>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Login"><br>
        <p>Cadastro de Usuários.</p>
        <a href="#" onclick="showCadastroForm()" class="buy-button">Cadastro</a>
        <a href="#" onclick="showRecuperaForm()" class="buy-button">Esqueceu a senha!</a>
    </form>
</div>

<!-- Pop-up para erro de login inválido -->
<div id="invalidPopup" class="popup" style="display:none;">
    <span onclick="closePopup('invalidPopup')" class="close-btn">&times;</span>
    <h2>Erro de Login</h2>
    <p id="invalidError" style="display:none;">Email ou senha inválidos.</p>
    <button onclick="closePopup('invalidPopup')">Tente Novamente</button>
</div>

<script>
    function validateForm() {
        var email = document.getElementById("email").value.trim();
        var password = document.getElementById("password").value.trim();

        if (email === "" || password === "") {
            document.getElementById("emptyError").style.display = "block";
            document.getElementById("emptyPopup").style.display = "block";
            return false;
        } else {
            document.getElementById("emptyError").style.display = "none";
            document.getElementById("emptyPopup").style.display = "none";
        }

        // Aqui você deve implementar a chamada AJAX para o PHP para validar o login
        // Simulando uma resposta do servidor com sucesso (0) ou falha (1)
        var loginError = getUrlParameter('error');
        if (loginError === "1") {
            document.getElementById("invalidError").style.display = "block";
            document.getElementById("invalidPopup").style.display = "block";
            return false;
        } else {
            document.getElementById("invalidError").style.display = "none";
            document.getElementById("invalidPopup").style.display = "none";
        }

        return true; // Permite o envio do formulário
    }

    // Função para obter parâmetros da URL
    function getUrlParameter(name) {
        name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    window.onload = function () {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error')) {
            var loginError = getUrlParameter('error');
            if (loginError === "1") {
                document.getElementById("invalidPopup").style.display = "block";
            }
        }
    };

    function showCadastroForm() {
        document.getElementById('cadastroForm').style.display = 'block';
        document.getElementById('loginForm').style.display = 'none'; // Fecha o formulário de login
    }

    function closeCadastroForm() {
        document.getElementById('cadastroForm').style.display = 'none';
        document.getElementById('loginForm').style.display = 'block'; // Exibe o formulário de login
    }

    function closeLoginForm() {
        document.getElementById('loginForm').style.display = 'none';
    }

    function showLoginForm() {
        document.getElementById('loginForm').style.display = 'block';
    }
    
    function closePopup(popupId) {
        // Oculta o pop-up pelo ID
        document.getElementById(popupId).style.display = "none";
    }

</script>
<div id="popupErro" class="popup" style="display: none;">
        <div class="popup-content">
        <span id="mensagemErro"></span>
        <button onclick="fecharPopupErro()">ok</button>
    </div>
</div>
<script>
    const imageList = ['imagens2/teste3.jpg', 'imagens2/teste4.jpg', 'imagens2/teste5.jpg'];
    let currentIndex = 0;

    function changeImage() {
        const container = document.querySelector('.container');
        container.style.backgroundImage = `url('${imageList[currentIndex]}')`;

        currentIndex = (currentIndex + 1) % imageList.length;
    }

    setInterval(changeImage, 9000);
    changeImage(); // Chama a função para exibir a primeira imagem imediatamente
</script>

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
        <button onclick="closePopup('popup')" class="close-btn">&times;</button>
         <p id="popupMessage"></p>
        <p id="popupDescricao"></p> <!-- Adiciona a descrição do produto aqui -->
    </div>
</div>
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
    <img src="imagens2/bas.png" alt="Ícone de Carrinho" class="cart-icon"></a>
</div>
</div>

</body>
</html>

