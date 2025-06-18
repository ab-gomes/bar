<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

$favoritos_ids = $_SESSION['favoritos'] ?? []; // Pega os IDs dos favoritos da sessão

$produtos_favoritos = [];
$mensagem = '';

if (isset($_SESSION['mensagem_favoritos'])) {
    $mensagem = $_SESSION['mensagem_favoritos'];
    unset($_SESSION['mensagem_favoritos']);
}

if (!empty($favoritos_ids)) {
    try {
        // Prepara a string de placeholders para a consulta SQL
        $placeholders = implode(',', array_fill(0, count($favoritos_ids), '?'));

        // Busca os detalhes dos produtos favoritos no banco de dados
        $stmt = $pdo->prepare("SELECT id_produto, nome, preco, imagem_url, tipo, marca FROM Produtos WHERE id_produto IN ($placeholders)");
        $stmt->execute($favoritos_ids);
        $produtos_favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $mensagem = "<span style='color: red;'>Erro ao carregar favoritos: " . $e->getMessage() . "</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Favoritos - OnlineBar</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="catalogo.css"> <style>
        /* Estilos específicos para a página de favoritos */
        body {
            background-color: var(--bege-claro);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: flex-start;
            align-items: center;
        }
        .favoritos-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 960px;
            margin-top: 100px;
            margin-bottom: 50px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .favoritos-container h2 {
            color: var(--bordo);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.8rem;
            font-family: 'Agu Display', sans-serif;
        }
        .favoritos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            justify-content: center;
        }
        .empty-favorites-message {
            text-align: center;
            font-size: 1.1rem;
            color: var(--cinza-escuro);
            margin-top: 30px;
            padding: 20px;
            background-color: #f0f0e0;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .mensagem {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .mensagem.sucesso {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .mensagem.erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Reutiliza estilos do produto do catalogo.css */
        .product-item {
            /* Certifique-se de que o product-item em catalogo.css está incluído e não tem posições absolutas estranhas */
            /* Se o .favorito-btn no product-item do catálogo for interferir, remova ele daqui */
            position: relative; /* Importante para o coração do remover */
        }
        .remove-favorito-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.8rem;
            text-decoration: none;
            color: #ff0000; /* Cor vermelha para remover */
            transition: color 0.2s ease, transform 0.2s ease;
            z-index: 10;
        }
        .remove-favorito-btn:hover {
            color: #cc0000;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <header class="header">
        <h1 class="logo"><a href="index.php">🍺</a></h1>
        <nav class="nav">
            <?php if (isset($_SESSION['localizacao'])): ?>
                <p style="text-align: center; background-color: #F5F5DC; padding: 5px; font-size: 14px;">📍 Entregando em: <strong><?php echo $_SESSION['localizacao']; ?></strong></p>
            <?php endif; ?>
            <a href="index.php"> Home </a>
            <a href="catalogo.php"> Catálogo </a>
            <a href="favoritos.php"> 🤍 </a>
            <a href="cart.php"> 🛒 (<?= array_sum(array_column($_SESSION['carrinho'] ?? [], 'quantidade')) ?>) </a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="user.php" style="color: var(--dourado);">Olá, <?= htmlspecialchars($_SESSION['user_name']) ?>!</a>
                <a href="logout.php">Sair</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="cadastro.php">Cadastro</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="favoritos-container">
        <h2>Meus Favoritos</h2>

        <?php if (!empty($mensagem)): ?>
            <div class="mensagem <?= strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro' ?>">
                <?= $mensagem ?>
            </div>
        <?php endif; ?>

        <?php if (empty($produtos_favoritos)): ?>
            <p class="empty-favorites-message">Você ainda não adicionou nenhum produto aos favoritos. <a href="catalogo.php">Explore nosso catálogo!</a></p>
        <?php else: ?>
            <div class="favoritos-grid">
                <?php foreach ($produtos_favoritos as $produto): ?>
                    <div class="product-item">
                        <img src="<?= htmlspecialchars($produto['imagem_url']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="product-image">
                        <div class="product-details">
                            <h3 class="product-name"><?= htmlspecialchars($produto['nome']) ?></h3>
                            <p class="product-meta"><?= htmlspecialchars($produto['tipo']) ?> - <?= htmlspecialchars($produto['marca']) ?></p>
                            <p class="product-price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                        </div>
                        <form action="add_to_cart.php" method="post" class="add-to-cart-form">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($produto['id_produto']) ?>">
                            <input type="number" name="quantity" value="1" min="1" class="product-quantity">
                            <button type="submit" class="add-to-cart-btn">Adicionar ao Carrinho</button>
                        </form>
                        <a href="add_remove_favorito.php?id=<?= htmlspecialchars($produto['id_produto']) ?>" class="remove-favorito-btn" title="Remover dos Favoritos">
                            ❤️ </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer" style="position: relative; width: 100%; margin-top: auto;">
        <p>&copy; 2025 OnlineBar. Todos os direitos reservados</p>
    </footer>
</body>
</html>