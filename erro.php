<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h1 {
            color: #cc0000;
        }
        .container p {
            margin: 10px 0;
        }
        .container button {
            padding: 10px 20px;
            background-color: #663399;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #7c1da8;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Erro</h1>
    <p><?php echo isset($_GET['erro']) ? htmlspecialchars($_GET['erro']) : 'Ocorreu um erro. Tente novamente mais tarde.'; ?></p>
    <button onclick="window.location.href='index.php'">Voltar para Home</button>
</div>
</body>
</html>
