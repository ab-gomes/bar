<?php 
session_start();
include 'includes/conexao.php'; 
?>

<?php


// Adicionar ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produto'])) {
    $id = $_POST['id_produto'];
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    $_SESSION['carrinho'][] = $id;
    echo "<script>alert('Produto adicionado ao carrinho!');</script>";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cerveja.css">
    <title>OnlineBar - Cervejas</title>
</head>
<body>
    <header class="header">
        <a href="index.html"><h1 class="logo">OnlineBar</h1></a>
        <div class="header-icons">
            <a href="carrinho.php" class="cart">🛒</a>
            <a href="login.html">👤</a>
        </div>
    </header>

    <section id="home" class="banner">
        <div class="banner-content">
            <h2>Cervejas</h2>
        </div>
    </section>

    <!-- Seção de cervejas nacionais -->
    <section id="cervejasn" class="cervejasn">
        <h2>Cervejas Nacionais</h2>
        <div class="cervejasn-grid">
            <?php
            $sql = "SELECT * FROM cervejas WHERE nacionalidade = 'nacional'";
            $result = $conn->query($sql);
            while ($row = $result->fetchArray()) {
                echo '<div class="cervejasn-item">';
                echo '  <form method="POST">';
                echo '    <input type="hidden" name="id_produto" value="'.$row['id'].'">';
                echo '    <h3>'.$row['nome'].'</h3>';
                echo '    <p>'.$row['descricao'].'</p>';
                echo '    <img src="img/'.$row['imagem'].'" alt="'.$row['nome'].'">';
                echo '    <p><strong>R$ '.$row['preco'].'</strong></p>';
                echo '    <button type="submit">Adicionar ao Carrinho</button>';
                echo '  </form>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <!-- Seção de cervejas internacionais -->
    <section id="cervejasI" class="cervejasI">
        <h2>Cervejas Internacionais</h2>
        <div class="cervejasI-grid">
            <?php
            $sql = "SELECT * FROM cervejas WHERE nacionalidade = 'internacional'";
            $result = $conn->query($sql);
            while ($row = $result->fetchArray()) {
                echo '<div class="cervejasI-item">';
                echo '  <form method="POST">';
                echo '    <input type="hidden" name="id_produto" value="'.$row['id'].'">';
                echo '    <h3>'.$row['nome'].'</h3>';
                echo '    <p>'.$row['descricao'].'</p>';
                echo '    <img src="img/'.$row['imagem'].'" alt="'.$row['nome'].'">';
                echo '    <p><strong>R$ '.$row['preco'].'</strong></p>';
                echo '    <button type="submit">Adicionar ao Carrinho</button>';
                echo '  </form>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <script>
    // Função para confirmar adição ao carrinho (apenas ilustrativo, funcionalidade é feita em PHP)
    const buttons = document.querySelectorAll("button");
    buttons.forEach(btn => {
        btn.addEventListener("click", () => {
            console.log("Produto adicionado ao carrinho.");
        });
    });
    </script>
</body>
</html>