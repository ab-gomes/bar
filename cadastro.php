<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

$mensagem = ''; // Para exibir mensagens de sucesso ou erro

// Se houver uma mensagem na sessão (ex: do processa_cadastro.php), exibe e limpa
if (isset($_SESSION['mensagem_cadastro'])) {
    $mensagem = $_SESSION['mensagem_cadastro'];
    unset($_SESSION['mensagem_cadastro']); // Limpa a mensagem após exibir
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - OnlineBar</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos específicos para as páginas de cadastro/login */
body {
    background-color: var(--bege-claro); /* Fundo da página */
    display: flex;
    flex-direction: column; /* Organiza os elementos verticalmente */
    min-height: 100vh; /* Garante que o body ocupe a altura total da tela */
    justify-content: flex-start; /* Alinha o conteúdo ao topo */
    align-items: center; /* Centraliza o conteúdo horizontalmente */
    font-family: 'Cormorant Garamond', serif; /* Mantém a fonte do projeto */
    color: var(--cinza-escuro); /* Cor de texto padrão */
}

/* Container principal do formulário */
.container {
    background-color: #fff; /* Fundo branco para o formulário */
    padding: 30px;
    border-radius: 10px; /* Cantos arredondados */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); /* Sombra mais pronunciada */
    width: 100%;
    max-width: 450px; /* Largura máxima para o formulário */
    text-align: center;
    margin-top: 100px; /* Espaço para o cabeçalho fixo */
    margin-bottom: 50px; /* Espaço antes do rodapé */
    border: 1px solid rgba(0, 0, 0, 0.05); /* Borda sutil */
}

/* Título do formulário (Criar Conta / Fazer Login) */
.container h2 {
    color: var(--bordo); /* Cor do título */
    margin-bottom: 30px;
    font-size: 2.8rem; /* Tamanho maior para o título */
    font-family: 'Agu Display', sans-serif; /* Fonte do logo */
    letter-spacing: 1px; /* Espaçamento entre letras para o título */
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Sombra suave no texto */
}

/* Grupos de formulário (label + input) */
.form-group {
    margin-bottom: 20px; /* Mais espaço entre os campos */
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 8px; /* Mais espaço entre label e input */
    color: var(--bordo); /* Cor do label */
    font-weight: 600; /* Texto mais encorpado */
    font-size: 1.05rem;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="password"],
.form-group input[type="date"],
.form-group input[type="tel"],
.form-group select {
    width: 100%; /* Largura total dentro do container */
    padding: 12px 15px; /* Mais padding */
    border: 1px solid #ddd; /* Borda mais suave */
    border-radius: 8px; /* Cantos mais arredondados */
    font-size: 1.1rem; /* Tamanho da fonte maior nos inputs */
    color: var(--preto); /* Cor do texto digitado */
    background-color: var(--bege-claro); /* Fundo sutil nos inputs */
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
    border-color: var(--dourado); /* Borda dourada no foco */
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2); /* Sombra suave no foco */
    outline: none; /* Remove a borda de foco padrão do navegador */
}

/* Botão de Envio */
.btn-submit {
    background-color: var(--bordo); /* Cor de fundo bordô */
    color: white; /* Cor do texto branco */
    padding: 15px 30px; /* Mais padding para o botão */
    border: none;
    border-radius: 8px; /* Cantos arredondados */
    cursor: pointer;
    font-size: 1.2rem; /* Texto maior no botão */
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
    width: 100%;
    margin-top: 25px; /* Mais espaço antes do botão */
    letter-spacing: 0.5px;
}

.btn-submit:hover {
    background-color: #8C0030; /* Bordô mais escuro no hover */
    transform: translateY(-2px); /* Efeito de leve elevação */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* Links alternativos (Já tem uma conta? / Não tem uma conta?) */
.link-alternativo {
    margin-top: 30px; /* Mais espaço acima do link */
    font-size: 1rem;
    color: var(--cinza-escuro);
}

.link-alternativo a {
    color: var(--dourado); /* Cor dourada para o link */
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

.link-alternativo a:hover {
    color: var(--bordo); /* Bordô no hover do link */
    text-decoration: underline;
}

/* Mensagens de sucesso/erro */
.mensagem {
    margin-bottom: 20px; /* Espaço abaixo da mensagem */
    padding: 12px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 0.95rem;
    text-align: center;
}

.mensagem.sucesso {
    background-color: #d4edda; /* Fundo verde claro */
    color: #155724; /* Texto verde escuro */
    border: 1px solid #c3e6cb;
}

.mensagem.erro {
    background-color: #f8d7da; /* Fundo vermelho claro */
    color: #721c24; /* Texto vermelho escuro */
    border: 1px solid #f5c6cb;
}

/* Rodapé (garante que ele fique sempre na parte inferior) */
footer.footer {
    margin-top: auto; /* Empurra o rodapé para baixo */
    width: 100%;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); /* Sombra no topo do rodapé */
}

/* Media Queries para Responsividade */
@media (max-width: 600px) {
    .container {
        margin-top: 80px; /* Ajuste para telas menores */
        padding: 25px;
        width: 90%; /* Ocupa mais largura em telas menores */
    }
    .container h2 {
        font-size: 2.2rem;
    }
    .form-group input, .form-group select, .btn-submit {
        font-size: 1rem;
        padding: 10px 12px;
    }
    .form-group label {
        font-size: 0.95rem;
    }
}
    </style>
</head>
<body>
    <header class="header">
        <h1 class="logo"><a href="index.php">🍺</a></h1>
        <nav class="nav">
            <a href="index.php"> Home </a>
            <a href="favoritos.php"> 🤍 </a>
            <a href="cart.php"> 🛒 </a>
            <a href="user.php"> 👤 </a>
        </nav>
    </header>

    <div class="container">
        <h2>Criar Conta</h2>

        <?php if (!empty($mensagem)): ?>
            <div class="mensagem <?= strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro' ?>">
                <?= $mensagem ?>
            </div>
        <?php endif; ?>

        <form action="processa_cadastro.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar_senha">Confirmar Senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Ex: 123.456.789-00" required>
            </div>
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>
             <div class="form-group">
                <label for="telefone">Telefone (Opcional):</label>
                <input type="tel" id="telefone" name="telefone" placeholder="Ex: (XX) XXXX-XXXX">
            </div>
            <div class="form-group">
                <label for="tipo_usuario">Eu sou:</label>
                <select id="tipo_usuario" name="tipo_usuario" required>
                    <option value="cliente">Cliente</option>
                    <option value="entregador">Entregador</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Cadastrar</button>
        </form>
        <div class="link-alternativo">
            Já tem uma conta? <a href="login.php">Faça Login aqui!</a>
        </div>
    </div>

    <footer class="footer" style="position: relative; width: 100%; margin-top: auto;">
        <p>&copy; 2025 OnlineBar. Todos os direitos reservados</p>
    </footer>
</body>
</html>