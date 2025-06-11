<?php 
session_start();
include 'includes/conexao.php'; 
?>
<?php

// Inicializa carrinho se ainda não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adiciona produto ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto_id'])) {
    $produto_id = intval($_POST['produto_id']); // Sanitiza entrada

    if (isset($_SESSION['carrinho'][$produto_id])) {
        $_SESSION['carrinho'][$produto_id]++;
    } else {
        $_SESSION['carrinho'][$produto_id] = 1;
    }

    header('Location: carrinho.php');
    exit;
}

// Remover item
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['remover'])) {
    $remover_id = intval($_GET['remover']);
    unset($_SESSION['carrinho'][$remover_id]);
    header('Location: carrinho.php');
    exit;
}

// Obter produtos do carrinho de forma segura
$produtos = [];
$total = 0;

if (!empty($_SESSION['carrinho'])) {
    $ids = implode(',', array_map('intval', array_keys($_SESSION['carrinho'])));
    $stmt = $conexao->prepare("SELECT * FROM produtos WHERE id IN ($ids)");
    $stmt->execute();
    $produtosDB = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($produtosDB as $produto) {
        $quantidade = $_SESSION['carrinho'][$produto['id']] ?? 0;
        $subtotal = $produto['preco'] * $quantidade;
        $total += $subtotal;

        $produtos[] = [
            'id' => $produto['id'],
            'nome' => htmlspecialchars($produto['nome']),
            'preco' => number_format($produto['preco'], 2, ',', '.'),
            'quantidade' => $quantidade,
            'subtotal' => number_format($subtotal, 2, ',', '.')
        ];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Meu Carrinho - Online Bar</title>
    <style>
        body { background-color: #1C1C1C; color: #F5F5DC; font-family: Arial; }
        .carrinho { max-width: 800px; margin: 40px auto; background: #2F2F2F; padding: 20px; border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; }
        th { background: #5D001E; }
        td { background: #3D3D3D; }
        .btn-remove { background: #FFA15E; color: #000; border: none; padding: 5px 10px; cursor: pointer; }
        .btn-finalizar {
            background: #D4AF37;
            color: #000;
            padding: 10px;
            border: none;
            font-weight: bold;
            width: 100%;
            margin-top: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="carrinho">
    <h2>🛒 Meu Carrinho</h2>

    <?php if (empty($produtos)): ?>
        <p>Seu carrinho está vazio. <a href="catalogo.php" style="color:#D4AF37;">Voltar ao catálogo</a></p>
    <?php else: ?>
        <table>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Qtd</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
            <?php foreach ($produtos as $item): ?>
                <tr>
                    <td><?= $item['nome'] ?></td>
                    <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    <td><?= $item['quantidade'] ?></td>
                    <td>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
                    <td><a href="carrinho.php?remover=<?= $item['id'] ?>" class="btn-remove">Remover</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3 style="text-align:right;">Total: R$ <?= number_format($total, 2, ',', '.') ?></h3>
        <button class="btn-finalizar" onclick="alert('Finalização de compra ainda não implementada')">Finalizar Compra</button>
    <?php endif; ?>
</div>

</body>
</html>

