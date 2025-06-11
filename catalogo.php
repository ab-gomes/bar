<?php 
session_start();
 //include 'includes/conexao.php'; 
?>
<?php

$sql = "SELECT * FROM bebidas";
$stmt = $pdo->query($sql);
$bebidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlineBar - Catálogo</title>
    <link rel="stylesheet" href="catalogo.css">
</head>
<body>

<header class="header">
    <a href="index.html"><h1 class="logo">OnlineBar</h1></a>
    <div class="header-icons">
        <a href="carrinho.html" class="cart">
            <!-- Ícone do carrinho -->
            🛒
        </a>
        <a href="login.html">👤</a>
    </div>
</header>

<section class="banner">
    <div class="banner-content">
        <h2>Catálogo</h2>
    </div>
</section>

<section class="catalogo">
    <h2>Todas as bebidas</h2>
    <div class="catalogo-grid">
        <?php foreach ($bebidas as $bebida): ?>
        <div class="catalogo-item">
            <a href="produto.php?id=<?= $bebida['id'] ?>">
                <h3><?= htmlspecialchars($bebida['nome']) ?></h3>
                <h5><?= htmlspecialchars($bebida['tipo']) ?> - <?= htmlspecialchars($bebida['embalagem']) ?></h5>
                <p><?= htmlspecialchars($bebida['descricao']) ?></p>
                <img src="img/<?= htmlspecialchars($bebida['imagem']) ?>" alt="<?= htmlspecialchars($bebida['nome']) ?>">
                <p><strong>R$ <?= number_format($bebida['preco'], 2, ',', '.') ?></strong></p>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<footer class="footer">
    <p>&copy; 2025 OnlineBar. Todos os direitos reservados.</p>
    <ul>
        <li><a href="#">Sobre Nós</a></li>
        <li><a href="#">FAQ</a></li>
        <li><a href="#">Contato</a></li>
        <li><a href="#">Política de Privacidade</a></li>
        <li><a href="#">Termos de Uso</a></li>
    </ul>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    console.log("Catálogo carregado com sucesso!");
    // Aqui você pode adicionar filtros, carrinho dinâmico, etc.
});
</script>
</body>
</html>