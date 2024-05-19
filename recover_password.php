<?php
// Inclua o autoload do PHPMailer
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Informações de conexão ao banco de dados
$host = "192.168.0.110"; // Endereço IPv6 do servidor MySQL
$usuario_bd = "fcovieira";
$senha_bd = "Master3631@#Fvo";
$banco = "bdsite";

// Conexão com o banco de dados
$conn = new mysqli($host, $usuario_bd, $senha_bd, $banco);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Erro na conexão: " . $conn->connect_error]));
}

// Verificação do e-mail enviado pelo formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se o email foi enviado pelo formulário
    if (isset($_POST["emailrecu"])) {
        $email = $_POST["emailrecu"];

        // Verifique se o email não está vazio
        if (!empty($email)) {
            // Verifique se o e-mail existe na base de dados
            $sql = "SELECT * FROM bdsite WHERE email = '$email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // O e-mail existe, armazene a senha antiga e crie um token
                $row = $result->fetch_assoc();
                $senha_antiga = $row["senha"];
                $sql_update_senhaold = "UPDATE bdsite SET senhaold = '$senha_antiga' WHERE email = '$email'";
                if ($conn->query($sql_update_senhaold) === TRUE) {
                    $token = substr(bin2hex(random_bytes(16)), 0, 20); // Gera um token seguro de 40 caracteres
                    $sql_update_token = "UPDATE bdsite SET token = '$token' WHERE email = '$email'";
                    if ($conn->query($sql_update_token) === TRUE) {
                        // Envie o e-mail usando PHPMailer com conexão segura SSL/TLS
                        $mail = new PHPMailer\PHPMailer\PHPMailer();
                        $mail->isSMTP();
                        $mail->Host = 'smtp.zoho.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'suporte@futurainfobook.com.br';
                        $mail->Password = 'Master3631@#';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        $mail->setFrom('suporte@futurainfobook.com.br', 'Suporte-Futurainfo');
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->Subject = 'Recuperacao de Senha';
                        $mail->Body = "Para redefinir sua senha, acesse o link: http://www.futurainfobook.com.br/redefinir_senha.php?token=$token";

                        if ($mail->send()) {
                            // Retorne uma resposta JSON indicando sucesso
                            die(json_encode(["success" => true, "message" => "Um e-mail de recuperação foi enviado para o seu endereço."]));
                        } else {
                            // Retorne uma resposta JSON indicando erro no envio do e-mail
                            die(json_encode(["success" => false, "message" => "Erro ao enviar o email de recuperação: " . $mail->ErrorInfo]));
                        }
                    } else {
                        // Retorne uma resposta JSON indicando erro ao atualizar o token
                        die(json_encode(["success" => false, "message" => "Erro ao atualizar o token: " . $conn->error]));
                    }
                } else {
                    // Retorne uma resposta JSON indicando erro ao armazenar a senha antiga
                    die(json_encode(["success" => false, "message" => "Erro ao armazenar a senha antiga: " . $conn->error]));
                }
            } else {
                // Retorne uma resposta JSON indicando que o e-mail não foi encontrado
                die(json_encode(["success" => false, "message" => "E-mail não encontrado."]));
            }
        } else {
            // Retorne uma resposta JSON indicando que o campo de e-mail está vazio
            die(json_encode(["success" => false, "message" => "Por favor, preencha o campo de email."]));
        }
    } else {
        // Retorne uma resposta JSON indicando que o e-mail não foi enviado pelo formulário
        die(json_encode(["success" => false, "message" => "Email não enviado pelo formulário."]));
    }
}

$conn->close();
?>
