<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['localizacao'])) {
    $_SESSION['localizacao'] = htmlspecialchars($_POST['localizacao']);
    header("Location: index.php"); // redireciona de volta para a página principal
    exit();
} else {
    echo "Erro ao capturar a localização.";
}
?>