<?php 
session_start();
include 'includes/conexao.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlineBar - Destilados</title>
    <link rel="stylesheet" href="destilado.css">
</head>
<body>
    <header class="header">
        <a href="index.php"><h1 class="logo">OnlineBar</h1></a>
        <div class="header-icons">
            <a href="carrinho.php" class="cart">🛒</a>
            <a href="login.php">👤</a>
        </div>
    </header> 

    <section class="banner">
        <div class="banner-content">
            <h2>Destilados</h2>
        </div>
    </section>

    <!-- DESTILADOS NACIONAIS -->
    <section class="destilado">
        <h2>Destilados Nacionais</h2>
        <div class="destilado-grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM bebidas WHERE tipo = 'nacional'");
        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='destilado-item'>
                    <a href='produto.php?id={$produto['id']}'>
                        <h3>{$produto['nome']}</h3>
                        <h5>Clique aqui para</h5>
                        <p>{$produto['descricao']}</p>
                        <img src='img/{$produto['imagem']}' alt='{$produto['nome']}'>
                        <button class='add-carrinho' data-id='{$produto['id']}'>Adicionar ao carrinho</button>
                    </a>
                  </div>";
        }
        ?>
        </div>
    </section>

    <!-- DESTILADOS INTERNACIONAIS -->
    <section class="destilado">
        <h2>Destilados Internacionais</h2>
        <div class="destilado-grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM bebidas WHERE tipo = 'internacional'");
        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='destilado-item'>
                    <a href='produto.php?id={$produto['id']}'>
                        <h3>{$produto['nome']}</h3>
                        <h5>Clique aqui para</h5>
                        <p>{$produto['descricao']}</p>
                        <img src='img/{$produto['imagem']}' alt='{$produto['nome']}'>
                        <button class='add-carrinho' data-id='{$produto['id']}'>Adicionar ao carrinho</button>
                    </a>
                  </div>";
        }
        ?>
        </div>
    </section>

    <script>
        // Adicionar ao carrinho
        document.querySelectorAll('.add-carrinho').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const produtoId = this.dataset.id;

                fetch('add_carrinho.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${produtoId}`
                })
                .then(res => res.text())
                .then(data => alert('Produto adicionado ao carrinho!'))
                .catch(err => alert('Erro ao adicionar ao carrinho'));
            });
        });
    </script>
</body>
</html>