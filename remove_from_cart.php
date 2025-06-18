<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

    if (!$product_id || $product_id <= 0) {
        $_SESSION['mensagem_carrinho'] = "ID do produto inválido para remoção.";
        header("Location: cart.php");
        exit();
    }

    if (isset($_SESSION['carrinho'][$product_id])) {
        unset($_SESSION['carrinho'][$product_id]);
        $_SESSION['mensagem_carrinho'] = "Produto removido do carrinho com sucesso.";
    } else {
        $_SESSION['mensagem_carrinho'] = "Produto não encontrado no carrinho para remoção.";
    }

    header("Location: cart.php");
    exit();
} else {
    header("Location: cart.php");
    exit();
}
?>