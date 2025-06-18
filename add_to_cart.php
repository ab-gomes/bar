<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

    // Validação básica
    if (!$product_id || $product_id <= 0 || !$quantity || $quantity <= 0) {
        $_SESSION['mensagem_carrinho'] = "ID do produto ou quantidade inválida.";
        header("Location: cart.php"); // Redireciona para o carrinho
        exit();
    }

    try {
        // Busca os detalhes completos do produto no banco de dados
        $stmt = $pdo->prepare("SELECT id_produto, nome, preco, imagem_url, estoque FROM Produtos WHERE id_produto = :id_produto");
        $stmt->execute([':id_produto' => $product_id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            $_SESSION['mensagem_carrinho'] = "Produto não encontrado.";
            header("Location: cart.php");
            exit();
        }

        // Verifica se há estoque suficiente
        if ($produto['estoque'] < $quantity) {
             $_SESSION['mensagem_carrinho'] = "Não há estoque suficiente para adicionar essa quantidade de " . htmlspecialchars($produto['nome']) . ". Estoque disponível: " . $produto['estoque'] . ".";
             header("Location: catalogo.php"); // Melhor redirecionar para o catálogo neste caso
             exit();
        }


        // Inicializa o carrinho na sessão se ele não existir
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Verifica se o produto já está no carrinho
        if (isset($_SESSION['carrinho'][$product_id])) {
            // Se já está, apenas atualiza a quantidade
            $_SESSION['carrinho'][$product_id]['quantidade'] += $quantity;
        } else {
            // Se não está, adiciona o produto ao carrinho
            $_SESSION['carrinho'][$product_id] = [
                'id_produto' => $produto['id_produto'],
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'imagem_url' => $produto['imagem_url'],
                'quantidade' => $quantity
            ];
        }

        $_SESSION['mensagem_carrinho'] = "Produto '" . htmlspecialchars($produto['nome']) . "' adicionado ao carrinho!";
        
        // Redireciona de volta para o catálogo ou para o carrinho
        header("Location: catalogo.php"); // Ou header("Location: cart.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['mensagem_carrinho'] = "Erro ao adicionar produto: " . $e->getMessage();
        header("Location: catalogo.php"); // Volta para o catálogo com erro
        exit();
    }
} else {
    // Se não for uma requisição POST, redireciona para o catálogo
    header("Location: catalogo.php");
    exit();
}
?>