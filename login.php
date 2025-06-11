<?php 
session_start();
include 'includes/conexao.php'; 
?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Exemplo de conexão com SQLite (ajuste conforme seu banco)
    $db = new PDO('sqlite:onlinebar.sqlite');

    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        header("Location: index.php"); // Página após login
        exit;
    } else {
        echo "Login inválido. <a href='login.html'>Tente novamente</a>.";
    }
} else {
    header("Location: login.html");
    exit;
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $cpf = trim($_POST['cpf']);
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];

    if ($senha !== $confirmarSenha) {
        die("Senhas não conferem. <a href='login.html'>Voltar</a>");
    }

    // Hash da senha para segurança
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Conectar ao banco SQLite
    $db = new PDO('sqlite:onlinebar.sqlite');

    // Verificar se o email já existe
    $stmt = $db->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetch()) {
        die("E-mail já cadastrado. <a href='login.html'>Voltar</a>");
    }

    // Inserir novo usuário
    $stmt = $db->prepare("INSERT INTO usuarios (nome, email, cpf, senha) VALUES (:nome, :email, :cpf, :senha)");
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':cpf', $cpf, PDO::PARAM_STR);
    $stmt->bindValue(':senha', $senhaHash, PDO::PARAM_STR);
    $stmt->execute();

    echo "Cadastro realizado com sucesso! <a href='login.html'>Fazer login</a>.";
} else {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="login.css" />
    <title>OnlineBar</title>
</head>
<body>
   <header class="header">
        <a href="index.html"><h1 class="logo">OnlineBar</h1></a>
        <div class="header-icons">
            <a href="carrinho.html" class="cart">
            <!-- SVG do carrinho omitido para brevidade -->
            </a>
            <a href="login.html">
            <!-- SVG do login omitido para brevidade -->
            </a>
        </div>
    </header>
    
    <section id="home" class="banner">
        <div class="banner-content">
            <h2></h2>
        </div>
    </section>

<div class="container">
    <input type="radio" name="tab" id="login" checked>
    <input type="radio" name="tab" id="cadastro">

    <div class="tabs">
      <label for="login">Login</label>
      <label for="cadastro">Cadastro</label>
    </div>

    <div class="tab-content">
      <!-- Formulário de Login -->
      <div class="login-form">
        <form action="processa_login.php" method="POST">
          <h2>Login</h2>
          <label for="login-email">E-mail</label>
          <input type="email" id="login-email" name="email" required>

          <label for="login-senha">Senha</label>
          <input type="password" id="login-senha" name="senha" required>

          <button type="submit">Entrar</button>
        </form>
      </div>

      <!-- Formulário de Cadastro -->
      <div class="cadastro-form">
        <form id="formCadastro" action="processa_cadastro.php" method="POST">
          <h2>Cadastro</h2>
          <label for="cad-nome">Nome</label>
          <input type="text" id="cad-nome" name="nome" required>

          <label for="cad-email">E-mail</label>
          <input type="email" id="cad-email" name="email" required>

          <label for="cad-cpf">CPF</label>
          <input type="text" id="cad-cpf" name="cpf" placeholder="000.000.000-00" required>

          <label for="cad-senha">Senha</label>
          <input type="password" id="cad-senha" name="senha" required>

          <label for="cad-confirmar">Confirmar senha</label>
          <input type="password" id="cad-confirmar" name="confirmarSenha" required>

          <button type="submit">Cadastrar</button>
        </form>
      </div>
    </div>
  </div>

<script>
  // Validação básica para o cadastro
  document.getElementById('formCadastro').addEventListener('submit', function(event) {
    const senha = document.getElementById('cad-senha').value;
    const confirmarSenha = document.getElementById('cad-confirmar').value;

    if (senha !== confirmarSenha) {
      alert('As senhas não coincidem!');
      event.preventDefault(); // impede envio do form
    }
  });
</script>

</body>
</html>