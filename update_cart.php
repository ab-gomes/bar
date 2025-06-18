<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $new_quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

    if (!$product_id || $product_id <= 0 || !$new_quantity || $new_quantity < 0) {
        $_SESSION['mensagem_carrinho'] = "Dados inválidos para atualização.";
        header("Location: cart.php");
        exit();
    }

    if (isset($_SESSION['carrinho'][$product_id])) {
        if ($new_quantity == 0) {
            // Se a quantidade for 0, remove o item do carrinho
            unset($_SESSION['carrinho'][$product_id]);
            $_SESSION['mensagem_carrinho'] = "Produto removido do carrinho.";
        } else {
            // Verifica o estoque antes de atualizar
            try {
                $stmt = $pdo->prepare("SELECT estoque FROM Produtos WHERE id_produto = :id_produto");
                $stmt->execute([':id_produto' => $product_id]);
                $produto_estoque = $stmt->fetchColumn();

                if ($produto_estoque === false) { // Produto não existe mais no DB
                     $_SESSION['mensagem_carrinho'] = "Erro: Produto não encontrado no estoque.";
                } elseif ($new_quantity > $produto_estoque) {
                    $_SESSION['carrinho'][$product_id]['quantidade'] = $produto_estoque; // Define a quantidade máxima disponível
                    $_SESSION['mensagem_carrinho'] = "Quantidade atualizada para o máximo disponível (" . $produto_estoque . ") devido a limite de estoque.";
                } else {
                    $_SESSION['carrinho'][$product_id]['quantidade'] = $new_quantity;
                    $_SESSION['mensagem_carrinho'] = "Quantidade do produto atualizada.";
                }
            } catch (PDOException $e) {
                 $_SESSION['mensagem_carrinho'] = "Erro ao verificar estoque: " . $e->getMessage();
            }
        }
    } else {
        $_SESSION['mensagem_carrinho'] = "Produto não encontrado no carrinho para atualização.";
    }

    header("Location: cart.php");
    exit();
} else {
    header("Location: cart.php");
    exit();
}
?>