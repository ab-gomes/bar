<?php
// processa_cadastro.php

// Conexão com banco SQLite (arquivo no mesmo diretório)
$db = new PDO('ssqlite:' .__DIR__. '/../db/banco.sqlite');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber dados do formulário
    $nome = trim($_POST['nome']);
    $cpf = trim($_POST['cpf']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $veiculo = trim($_POST['veiculo']);
    $placa = trim($_POST['placa']);
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];

    // Validação básica no servidor
    if ($senha !== $confirmarSenha) {
        echo "As senhas não coincidem.";
        exit;
    }

    // Hash da senha para segurança
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);


    $stmt = $db->prepare("INSERT INTO entregadores (nome, cpf, email, telefone, veiculo, placa, senha) VALUES (?, ?, ?, ?, ?, ?, ?)");

    try {
        $stmt->execute([$nome, $cpf, $email, $telefone, $veiculo, $placa, $senhaHash]);
        echo "Cadastro realizado com sucesso!";
        // Você pode redirecionar para login, por exemplo
        // header("Location: login.html");
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Violação de UNIQUE
            echo "CPF já cadastrado.";
        } else {
            echo "Erro ao cadastrar: " . $e->getMessage();
        }
    }
} else {
    echo "Método inválido.";
}
?>