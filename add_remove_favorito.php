<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

// Inicializa a lista de favoritos na sessão se ela não existir
if (!isset($_SESSION['favoritos'])) {
    $_SESSION['favoritos'] = [];
}

// Pega o ID do produto da URL (GET)
$product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($product_id && $product_id > 0) {
    // Verifica se o produto já está nos favoritos
    $key = array_search($product_id, $_SESSION['favoritos']);

    if ($key !== false) {
        // Se estiver, remove dos favoritos
        unset($_SESSION['favoritos'][$key]);
        $_SESSION['mensagem_favoritos'] = "Produto removido dos favoritos.";
    } else {
        // Se não estiver, adiciona aos favoritos
        $_SESSION['favoritos'][] = $product_id;
        $_SESSION['mensagem_favoritos'] = "Produto adicionado aos favoritos!";
    }

    // Reorganiza os índices do array (opcional, mas boa prática)
    $_SESSION['favoritos'] = array_values($_SESSION['favoritos']);

} else {
    $_SESSION['mensagem_favoritos'] = "ID do produto inválido.";
}

// Redireciona de volta para a página de onde veio (ou para o catálogo)
$referring_url = $_SERVER['HTTP_REFERER'] ?? 'catalogo.php';
header("Location: " . $referring_url);
exit();
?>