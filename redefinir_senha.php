<?php
// Informações de conexão ao banco de dados
$host = "192.168.0.110"; // Endereço IPv6 do servidor MySQL
$usuario_bd = "fcovieira";
$senha_bd = "Master3631@#Fvo";
$banco = "bdsite";

// Conexão com o banco de dados
$conn = new mysqli($host, $usuario_bd, $senha_bd, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifique se o token está presente na URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["token"])) {
    $token = $_GET["token"];

    // Verifique se o token é válido e não está expirado (adicionar lógica de expiração se necessário)
    $sql = "SELECT * FROM bdsite WHERE token = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Token válido, exiba o formulário para redefinir a senha
            $token_hidden = htmlspecialchars($token); // Token para o campo oculto
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <style>
        /* Estilo CSS para o formulário */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 10px;
        }

        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #5a2d82;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3d1f5c;
        }

        /* Estilo CSS para o popup */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 9999;
        }

        /* Estilo CSS para o botão OK */
        .btn-ok {
            background-color: #5a2d82;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="login-form">
        <h2>Redefinir Senha</h2>
        <form action="atualizar_senha.php" method="post">
            <input type="hidden" name="token" value="<?php echo $token_hidden; ?>">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha" required><br>
            <input type="submit" value="Redefinir Senha">
        </form>
    </div>

    <!-- Popup de sucesso -->
    <div class="popup" id="popup">
        <p>Senha atualizada com sucesso!</p>
        <button class="btn-ok" onclick="redirectToIndex()">OK</button>
    </div>

    <!-- Script JavaScript -->
    <script>
        // Redirecionar para index.html ao clicar em OK
        function redirectToIndex() {
            window.location.href = 'index.php';
        }
    </script>

    <?php
        } else {
            echo "Token inválido ou expirado.";
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta SQL.";
    }
} else {
    echo "Token não encontrado na URL.";
}

$conn->close();
?>
</body>

</html>
