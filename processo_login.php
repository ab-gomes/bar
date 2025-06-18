<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

$_SESSION['mensagem_login'] = "<span style='color: red;'>Erro no login.</span>"; // Mensagem padrão de erro

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        $_SESSION['mensagem_login'] = "<span style='color: red;'>Por favor, preencha todos os campos.</span>";
        header("Location: login.php");
        exit();
    }

    try {
        // Busca o usuário pelo e-mail
        $stmt = $pdo->prepare("SELECT id_usuario, nome, email, senha_hash, tipo_usuario FROM Usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se o usuário foi encontrado e a senha corresponde
        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            // Login bem-sucedido: Armazena informações na sessão
            $_SESSION['user_id'] = $usuario['id_usuario'];
            $_SESSION['user_name'] = $usuario['nome'];
            $_SESSION['user_email'] = $usuario['email'];
            $_SESSION['user_type'] = $usuario['tipo_usuario']; // 'cliente' ou 'entregador'

            $_SESSION['mensagem_login'] = "<span style='color: green;'>Login realizado com sucesso!</span>";

            // Redireciona para a página do usuário (user.php)
            header("Location: user.php");
            exit();

        } else {
            $_SESSION['mensagem_login'] = "<span style='color: red;'>E-mail ou senha incorretos.</span>";
            header("Location: login.php");
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['mensagem_login'] = "<span style='color: red;'>Erro ao tentar login: " . $e->getMessage() . "</span>";
        header("Location: login.php");
        exit();
    }
} else {
    // Se a requisição não for POST, redireciona para a página de login
    header("Location: login.php");
    exit();
}
?>