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

// Verifique se o token e a nova senha foram enviados pelo formulário de redefinição
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["token"]) && isset($_POST["nova_senha"])) {
    $token = $_POST["token"];
    $nova_senha = $_POST["nova_senha"];

    // Use prepared statement para evitar SQL Injection
    $sql_update = "UPDATE bdsite SET senha = ? WHERE token = ?";
    $stmt = $conn->prepare($sql_update);

    if ($stmt) {
        // Bind dos parâmetros e execução do statement
        $stmt->bind_param("ss", $nova_senha, $token);

        if ($stmt->execute()) {
            // Senha atualizada com sucesso

            // Invalide o token após o uso
            $sql_invalidate_token = "UPDATE bdsite SET token = NULL WHERE token = ?";
            $stmt_invalidate = $conn->prepare($sql_invalidate_token);
            if ($stmt_invalidate) {
                $stmt_invalidate->bind_param("s", $token);
                if ($stmt_invalidate->execute()) {
                    // Exibe o popup após a atualização bem-sucedida da senha
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <style>
        /* Estilo CSS para o popup */
        .popup {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .popup-inner {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
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
    <div class="popup">
        <div class="popup-inner">
            <p>Senha atualizada com sucesso!</p>
            <button class="btn-ok" onclick="redirectToIndex()">OK</button>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        // Redirecionar para index.html ao clicar em OK
        function redirectToIndex() {
            window.location.href = 'index.php';
        }
    </script>
</body>

</html>
<?php
                    exit; // Encerra o script após exibir o popup
                } else {
                    echo "Erro ao invalidar o token: " . $stmt_invalidate->error;
                }
                $stmt_invalidate->close();
            } else {
                echo "Erro ao preparar a invalidação do token: " . $conn->error;
            }
        } else {
            echo "Erro ao atualizar a senha: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar a atualização da senha: " . $conn->error;
    }
} else {
    echo "Token ou nova senha não encontrados no formulário.";
}

$conn->close();
?>
