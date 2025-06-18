<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

$carrinho = $_SESSION['carrinho'] ?? []; // Pega o carrinho da sessão ou um array vazio
$total_carrinho = 0; // Inicializa o total

$mensagem = '';
if (isset($_SESSION['mensagem_carrinho'])) {
    $mensagem = $_SESSION['mensagem_carrinho'];
    unset($_SESSION['mensagem_carrinho']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Carrinho - OnlineBar</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos específicos para a página do carrinho */
        body {
            background-color: var(--bege-claro);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: flex-start;
            align-items: center;
        }
        .cart-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
            margin-top: 100px; /* Espaço para o cabeçalho fixo */
            margin-bottom: 50px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .cart-container h2 {
            color: var(--bordo);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.8rem;
            font-family: 'Agu Display', sans-serif;
        }
        .cart-item {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            gap: 20px;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .cart-item-details {
            flex-grow: 1;
        }
        .cart-item-details h3 {
            margin: 0 0 5px 0;
            font-size: 1.2rem;
            color: var(--preto);
        }
        .cart-item-details p {
            margin: 0;
            font-size: 1rem;
            color: var(--cinza-escuro);
        }
        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .cart-item-quantity input {
            width: 50px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .cart-item-quantity button {
            background-color: var(--bordo);
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .cart-item-quantity button:hover {
            background-color: #8C0030;
        }
        .cart-item-price {
            font-weight: bold;
            font-size: 1.1rem;
            color: var(--dourado);
            width: 120px; /* Largura fixa para alinhar preços */
            text-align: right;
        }
        .cart-summary {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid var(--bordo);
            text-align: right;
        }
        .cart-summary p {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: var(--preto);
        }
        .cart-summary span {
            color: var(--dourado);
            font-size: 1.5rem;
        }
        /* Estilos para a seção de cupom */
.coupon-section {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #eee;
    margin-top: 30px;
    margin-bottom: 30px;
    text-align: center;
}

.coupon-section h3 {
    color: var(--bordo);
    margin-bottom: 15px;
    font-size: 1.5rem;
}

.coupon-form {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 15px;
}

.coupon-input {
    flex-grow: 1;
    max-width: 250px;
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
}

.apply-coupon-btn {
    background-color: var(--dourado);
    color: var(--preto);
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.apply-coupon-btn:hover {
    background-color: #FFD700;
}

.coupon-applied-info {
    font-size: 1.1rem;
    color: var(--bordo);
    margin-top: 10px;
    font-weight: bold;
}

/* Ajuste nos totais para o total final */
.cart-summary p span {
    font-size: 1.5rem;
    color: var(--dourado); /* Cor dos valores finais */
}
/* Seção para mensagens de sucesso/erro */
.mensagem {
    margin-top: 15px;
    padding: 10px;
    border-radius: 5px;
    font-weight: bold;
    font-size: 0.95rem;
    text-align: center;
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

        .checkout-btn {
            background-color: var(--dourado);
            color: var(--preto);
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 20px;
            display: inline-block; /* Para centralizar se necessário */
        }
        .checkout-btn:hover {
            background-color: #FFD700;
            transform: translateY(-2px);
        }
        .empty-cart-message {
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
        @media (max-width: 768px) {
            .cart-item {
                flex-wrap: wrap; /* Quebra linha em telas pequenas */
                justify-content: space-between;
                text-align: center;
            }
            .cart-item-image {
                width: 60px;
                height: 60px;
                margin: 0 auto;
            }
            .cart-item-details {
                flex-basis: 100%; /* Ocupa toda a largura */
                margin-top: 10px;
            }
            .cart-item-quantity {
                justify-content: center;
                flex-basis: 50%;
            }
            .cart-item-price {
                text-align: center;
                flex-basis: 50%;
                margin-top: 10px;
            }
            .cart-container {
                padding: 20px;
                margin-top: 80px;
            }
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
            <a href="cart.php"> 🛒 (<?= array_sum(array_column($carrinho, 'quantidade')) ?>) </a> <?php if (isset($_SESSION['user_id'])): ?>
                <a href="user.php" style="color: var(--dourado);">Olá, <?= htmlspecialchars($_SESSION['user_name']) ?>!</a>
                <a href="logout.php">Sair</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="cadastro.php">Cadastro</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="cart-container">
        <h2>Meu Carrinho</h2>

        <?php if (!empty($mensagem)): ?>
            <div class="mensagem <?= strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro' ?>">
                <?= $mensagem ?>
            </div>
        <?php endif; ?>

        <?php if (empty($carrinho)): ?>
            <p class="empty-cart-message">Seu carrinho está vazio. <a href="catalogo.php">Comece a adicionar produtos!</a></p>
        <?php else: ?>
            <div class="cart-items-list">
                <?php foreach ($carrinho as $id_produto => $item): ?>
                    <div class="cart-item">
                        <img src="<?= htmlspecialchars($item['imagem_url']) ?>" alt="<?= htmlspecialchars($item['nome']) ?>" class="cart-item-image">
                        <div class="cart-item-details">
                            <h3><?= htmlspecialchars($item['nome']) ?></h3>
                            <p>Preço unitário: R$ <?= number_format($item['preco'], 2, ',', '.') ?></p>
                        </div>
                        <div class="cart-item-quantity">
                            <form action="update_cart.php" method="post" style="display: flex; gap: 5px;">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['id_produto']) ?>">
                                <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantidade']) ?>" min="1">
                                <button type="submit">Atualizar</button>
                            </form>
                            <form action="remove_from_cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['id_produto']) ?>">
                                <button type="submit" style="background-color: #dc3545;">Remover</button>
                            </form>
                        </div>
                        <div class="cart-item-price">
                            R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?>
                        </div>
                    </div>
                    <?php $total_carrinho += $item['preco'] * $item['quantidade']; ?>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <p>Total do Carrinho: <span>R$ <?= number_format($total_carrinho, 2, ',', '.') ?></span></p>
                <button class="checkout-btn">Finalizar Compra</button>
            </div>
        <?php endif; ?>
        <div class="coupon-section">
    <h3>Aplicar Cupom</h3>
    <form action="aplicar_cupom.php" method="post" class="coupon-form">
        <input type="text" name="coupon_code" placeholder="Digite o código do cupom" class="coupon-input">
        <button type="submit" class="apply-coupon-btn">Aplicar</button>
    </form>
    <?php
    // Exibe a mensagem de cupom (se houver)
    if (isset($_SESSION['coupon_message'])) {
        $msg_class = strpos($_SESSION['coupon_message'], 'sucesso') !== false ? 'sucesso' : 'erro';
        echo "<div class='mensagem " . $msg_class . "' style='margin-top: 10px;'>" . $_SESSION['coupon_message'] . "</div>";
        unset($_SESSION['coupon_message']);
    }

    // Exibe o cupom aplicado e o desconto, se houver
    if (isset($_SESSION['cupom_aplicado']) && $_SESSION['cupom_aplicado'] !== null) {
        $cupom_aplicado = $_SESSION['cupom_aplicado'];
        $desconto_aplicado = $_SESSION['desconto_aplicado'] ?? 0;
        echo "<p class='coupon-applied-info'>Cupom aplicado: <strong>" . htmlspecialchars($cupom_aplicado['codigo']) . "</strong> ";
        echo "(Desconto: R$ " . number_format($desconto_aplicado, 2, ',', '.') . ")</p>";
    }
    ?>
</div>

<div class="cart-summary">
    <p>Subtotal: <span>R$ <?= number_format($total_carrinho, 2, ',', '.') ?></span></p>
    <?php
    $total_final = $total_carrinho;
    if (isset($_SESSION['desconto_aplicado'])) {
        $total_final -= $_SESSION['desconto_aplicado'];
        if ($total_final < 0) $total_final = 0; // Garante que o total não seja negativo
        echo "<p style='color: var(--bordo);'>Desconto Cupom: <span>- R$ " . number_format($_SESSION['desconto_aplicado'], 2, ',', '.') . "</span></p>";
    }
    ?>
    <p>Total a Pagar: <span>R$ <?= number_format($total_final, 2, ',', '.') ?></span></p>
    <button class="checkout-btn">Finalizar Compra</button>
</div>

<?php
require_once 'config.php';

$carrinho = $_SESSION['carrinho'] ?? [];
$total_carrinho = 0;

// Calcular o subtotal antes de qualquer desconto
foreach ($carrinho as $item) {
    $total_carrinho += $item['preco'] * $item['quantidade'];
}

// ... o restante do seu código para exibir o carrinho ...

// Remova a inicialização de $mensagem que estava antes e use a que está no código abaixo
$mensagem = '';
if (isset($_SESSION['mensagem_carrinho'])) {
    $mensagem = $_SESSION['mensagem_carrinho'];
    unset($_SESSION['mensagem_carrinho']);
}
?>
    </div>

    <footer class="footer" style="position: relative; width: 100%; margin-top: auto;">
        <p>&copy; 2025 OnlineBar. Todos os direitos reservados</p>
    </footer>
</body>
</html>