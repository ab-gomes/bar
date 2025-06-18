<?php
// Inicia a sessão PHP em todas as páginas que incluírem este arquivo.
// É essencial para gerenciar o estado do usuário (logado/deslogado).
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define o nome do arquivo do banco de dados SQLite
$databaseFile = 'database.db';

// Variável para armazenar o objeto PDO da conexão
$pdo = null;

try {
    // Tenta criar uma nova conexão PDO com o arquivo SQLite.
    // O caminho do arquivo é relativo ao script que está *incluindo* o config.php.
    $pdo = new PDO("sqlite:$databaseFile");
    
    // Define o modo de erro do PDO para EXCEÇÕES. Crucial para depuração!
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Define o modo de busca padrão para objetos, que pode ser útil.
    // PDO::FETCH_ASSOC é mais comum e retorna array associativo.
    // $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

} catch (PDOException $e) {
    // Se a conexão falhar, exibe uma mensagem de erro e interrompe o script.
    // Em um ambiente de produção, você logaria o erro e mostraria uma mensagem genérica ao usuário.
    die("<p style='color: red; text-align: center;'>Erro ao conectar ao banco de dados: " . $e->getMessage() . "</p>");
}

// O objeto $pdo agora está disponível para qualquer script que inclua este arquivo.
?>