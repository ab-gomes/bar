<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

// Verifica se o usuário está logado. Se não estiver, redireciona para o login.
if (!isset($_SESSION['user_id'])) {
    $_SESSION['mensagem_login'] = "<span style='color: red;'>Você precisa estar logado para acessar esta página.</span>";
    header("Location: login.php");
    exit();
}

$userName = htmlspecialchars($_SESSION['user_name']);
$userEmail = htmlspecialchars($_SESSION['user_email']);
$userType = htmlspecialchars($_SESSION['user_type']);

// Mensagem específica para o tipo de usuário
$mensagemBoasVindas = "Olá, " . $userName . "!";
if ($userType === 'entregador') {
    $mensagemBoasVindas .= " Você está logado como Entregador.";
    // Aqui você pode adicionar lógica ou links específicos para entregadores
} else {
    $mensagemBoasVindas .= " Você está logado como Cliente.";
    // Aqui você pode adicionar lógica ou links específicos para clientes
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta - OnlineBar</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos básicos para a página do usuário */
        body {
            background-color: var(--bege-claro);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: flex-start; /* Alinha ao topo */
            align-items: center;
        }
        .container-user {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            margin-top: 100px; /* Espaço para o cabeçalho fixo */
            margin-bottom: 30px;
        }
        .container-user h2 {
            color: var(--bordo);
            margin-bottom: 20px;
            font-size: 2.5rem;
            font-family: 'Agu Display', sans-serif;
        }
        .container-user p {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: var(--cinza-escuro);
        }
        .logout-btn {
            background-color: var(--dourado);
            color: var(--preto);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            text-decoration: none; /* Para ser um link estilizado */
            display: inline-block;
        }
        .logout-btn:hover {
            background-color: #FFD700; /* Dourado mais claro */
        }
        .user-info {
            background-color: var(--bege-claro);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid #eee;
        }
        .user-info strong {
            color: var(--bordo);
        }
    </style>
</head>
<body>
    <header class="header">
        <h1 class="logo"><a href="index.php">🍺</a></h1>
        <nav class="nav">
            <a href="index.php"> Home </a>
            <a href="favoritos.php"> 🤍 </a>
            <a href="cart.php"> 🛒 (<?= array_sum(array_column($_SESSION['carrinho'] ?? [], 'quantidade')) ?>) </a>
            <a href="user.php"> 👤 </a>
        </nav>
    </header>

    <div class="container-user">
        <h2>Minha Conta</h2>
        <p><?= $mensagemBoasVindas ?></p>
        <div class="user-info">
            <p><strong>E-mail:</strong> <?= $userEmail ?></p>
            <p><strong>Tipo de Usuário:</strong> <?= $userType === 'cliente' ? 'Cliente' : 'Entregador' ?></p>
            </div>
        <a href="logout.php" class="logout-btn">Sair (Logout)</a>
    </div>

    <footer class="footer" style="position: relative; width: 100%; margin-top: auto;">
        <p>&copy; 2025 OnlineBar. Todos os direitos reservados</p>
    </footer>
</body>
</html>