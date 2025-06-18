<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

// Define a mensagem padrão de erro
$_SESSION['mensagem_cadastro'] = "<span style='color: red;'>Erro no cadastro. Tente novamente.</span>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    $cpf = trim($_POST['cpf']);
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = trim($_POST['telefone']);
    $tipo_usuario = $_POST['tipo_usuario'];

    // --- Validações de Entrada ---
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha) || empty($cpf) || empty($data_nascimento) || empty($tipo_usuario)) {
        $_SESSION['mensagem_cadastro'] = "<span style='color: red;'>Todos os campos obrigatórios devem ser preenchidos.</span>";
        header("Location: cadastro.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem_cadastro'] = "<span style='color: red;'>Formato de e-mail inválido.</span>";
        header("Location: cadastro.php");
        exit();
    }

    if ($senha !== $confirmar_senha) {
        $_SESSION['mensagem_cadastro'] = "<span style='color: red;'>As senhas não coincidem.</span>";
        header("Location: cadastro.php");
        exit();
    }

    if (strlen($senha) < 6) {
        $_SESSION['mensagem_cadastro'] = "<span style='color: red;'>A senha deve ter no mínimo 6 caracteres.</span>";
        header("Location: cadastro.php");
        exit();
    }

    // Validação de maioridade (18 anos)
    $dataNascimentoObj = new DateTime($data_nascimento);
    $hoje = new DateTime();
    $idade = $hoje->diff($dataNascimentoObj)->y;
    if ($idade < 18) {
        $_SESSION['mensagem_cadastro'] = "<span style='color: red;'>Você deve ter 18 anos ou mais para se cadastrar.</span>";
        header("Location: cadastro.php");
        exit();
    }

    // Validação de CPF (básica, pode ser melhorada com regex)
    if (strlen($cpf) < 11 || !is_numeric(str_replace(['.', '-'], '', $cpf))) {
        $_SESSION['mensagem_cadastro'] = "<span style='color: red;'>CPF inválido. Use apenas números ou formato padrão.</span>";
        header("Location: cadastro.php");
        exit();
    }

    // --- Inserção no Banco de Dados ---
    try {
        // Verificar se o e-mail ou CPF já existem
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM Usuarios WHERE email = :email OR cpf = :cpf");
        $stmt->execute([':email' => $email, ':cpf' => $cpf]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['mensagem_cadastro'] = "<span style='color: red;'>E-mail ou CPF já cadastrados.</span>";
            header("Location: cadastro.php");
            exit();
        }

        // Hash da senha (MUITO IMPORTANTE para segurança!)
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO Usuarios (nome, email, senha_hash, cpf, data_nascimento, telefone, tipo_usuario) VALUES (:nome, :email, :senha_hash, :cpf, :data_nascimento, :telefone, :tipo_usuario)");
        
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha_hash' => $senha_hash,
            ':cpf' => $cpf,
            ':data_nascimento' => $data_nascimento,
            ':telefone' => empty($telefone) ? null : $telefone, // Armazena null se o telefone estiver vazio
            ':tipo_usuario' => $tipo_usuario
        ]);

        $_SESSION['mensagem_cadastro'] = "<span style='color: green;'>Cadastro realizado com sucesso! Faça login para continuar.</span>";
        header("Location: login.php"); // Redireciona para a página de login
        exit();

    } catch (PDOException $e) {
        // Captura qualquer erro do banco de dados (ex: problema de conexão, query inválida)
        $_SESSION['mensagem_cadastro'] = "<span style='color: red;'>Erro ao cadastrar: " . $e->getMessage() . "</span>";
        header("Location: cadastro.php");
        exit();
    }
} else {
    // Se a requisição não for POST, redireciona para a página de cadastro
    header("Location: cadastro.php");
    exit();
}
?>