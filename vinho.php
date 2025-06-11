<?php 
session_start();
include 'includes/conexao.php'; 

?>
<?php
$vinhosNacionais = [
    [
        'nome' => 'Miolo',
        'descricao' => 'Vinho Miolo Reserva',
        'imagem' => 'img/miolo2.jpg',
        'preco' => 50.00,
        'id' => 1
    ],
        [
        'nome' => 'Miolo',
        'descricao' => 'Vinho Miolo Reserva',
        'imagem' => 'img/miolo2.jpg',
        'preco' => 50.00,
        'id' => 1
    ],
        [
        'nome' => 'Miolo',
        'descricao' => 'Vinho Miolo Reserva',
        'imagem' => 'img/miolo2.jpg',
        'preco' => 50.00,
        'id' => 1
    ],
        [
        'nome' => 'Miolo',
        'descricao' => 'Vinho Miolo Reserva',
        'imagem' => 'img/miolo2.jpg',
        'preco' => 50.00,
        'id' => 1
    ],
        [
        'nome' => 'Miolo',
        'descricao' => 'Vinho Miolo Reserva',
        'imagem' => 'img/miolo2.jpg',
        'preco' => 50.00,
        'id' => 1
    ],
];

$vinhosInternacionais = [
    [
        'nome' => 'Catena Zapata',
        'descricao' => 'Vinho Catena Zapata Malbec',
        'imagem' => 'img/catena.jpg',
        'preco' => 120.00,
        'id' => 101
    ],
    [
        'nome' => 'Catena Zapata',
        'descricao' => 'Vinho Catena Zapata Malbec',
        'imagem' => 'img/catena.jpg',
        'preco' => 120.00,
        'id' => 101
    ],
    [
        'nome' => 'Catena Zapata',
        'descricao' => 'Vinho Catena Zapata Malbec',
        'imagem' => 'img/catena.jpg',
        'preco' => 120.00,
        'id' => 101
    ],
    [
        'nome' => 'Catena Zapata',
        'descricao' => 'Vinho Catena Zapata Malbec',
        'imagem' => 'img/catena.jpg',
        'preco' => 120.00,
        'id' => 101
    ],
    [
        'nome' => 'Catena Zapata',
        'descricao' => 'Vinho Catena Zapata Malbec',
        'imagem' => 'img/catena.jpg',
        'preco' => 120.00,
        'id' => 101
    ],
    [
        'nome' => 'Catena Zapata',
        'descricao' => 'Vinho Catena Zapata Malbec',
        'imagem' => 'img/catena.jpg',
        'preco' => 120.00,
        'id' => 101
    ],
];

// Adicionar item ao carrinho via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $id = intval($_POST['wine_id']);
    $nome = $_POST['wine_name'];
    $preco = floatval($_POST['wine_price']);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Se já tiver no carrinho, soma 1, senão adiciona
    if (isset($_SESSION['carrinho.php'][$id])) {
        $_SESSION['cart'][$id]['quantidade']++;
    } else {
        $_SESSION['cart'][$id] = [
            'nome' => $nome,
            'preco' => $preco,
            'quantidade' => 1
        ];
    }

    // Para dar feedback depois do POST, redireciona
    header('Location: vinhos.php?added=1');
    exit;
}
?>
<a href="vinho.css?id=<?= $vinho['id'] ?>">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<section id="vinhoN" class="vinhoN">
    <h2>Vinhos Nacionais</h2>
    <div class="vinhoN-grid">
        <?php foreach ($vinhosNacionais as $vinho): ?>
        <div class="vinhoN-item">
            <a href="#">
                <h3><?= htmlspecialchars($vinho['nome']) ?></h3>
                <h5>Clique aqui para</h5>
                <p><?= htmlspecialchars($vinho['descricao']) ?></p>
                <img src="<?= htmlspecialchars($vinho['imagem']) ?>" alt="<?= htmlspecialchars($vinho['nome']) ?>">
            </a>
            <form method="POST" class="add-to-cart-form">
                <input type="hidden" name="wine_id" value="<?= $vinho['id'] ?>">
                <input type="hidden" name="wine_name" value="<?= htmlspecialchars($vinho['nome']) ?>">
                <input type="hidden" name="wine_price" value="<?= $vinho['preco'] ?>">
                <button type="submit" name="add_to_cart">Adicionar ao Carrinho - R$ <?= number_format($vinho['preco'], 2, ',', '.') ?></button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php if (isset($_GET['added'])): ?>
<div id="notification" class="notification">Item adicionado ao carrinho!</div>
<?php endif; ?>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const notification = document.getElementById('notification');
        if (notification) {
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }
    });
</script>