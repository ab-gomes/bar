
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title> OnlineBar </title>
</head>
<body>
   <header class="header">
        <a href="index.php"><h1 class="logo">OnlineBar</h1></a>
        <div class="header-icons">
            <a href="carrinho.html" class="cart">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z"/></svg>
            </a>
            <a href="login.php" class="user">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z"/></svg>
            </a>
        </div>
    </header>
    
    <section id="home" class="banner">
        <div class="banner-content">
            <h2>Login/Cadastro</h2>
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
        <form action="processa_cadastro.php" method="POST">
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
