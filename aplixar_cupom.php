<?php
require_once 'config.php'; // Inclui a conexão com o banco de dados e inicia a sessão

// Inicializa variáveis de sessão para cupom
$_SESSION['cupom_aplicado'] = null;
$_SESSION['desconto_aplicado'] = 0;
$_SESSION['coupon_message'] = ""; // Limpa qualquer mensagem anterior

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $coupon_code = trim(strtoupper($_POST['coupon_code'] ?? '')); // Garante maiúsculas e remove espaços

    if (empty($coupon_code)) {
        $_SESSION['coupon_message'] = "<span style='color: red;'>Por favor, digite um código de cupom.</span>";
        header("Location: cart.php");
        exit();
    }

    try {
        // Busca o cupom no banco de dados
        $stmt = $pdo->prepare("SELECT * FROM Cupons WHERE codigo = :codigo AND ativo = 1");
        $stmt->execute([':codigo' => $coupon_code]);
        $cupom = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cupom) {
            $_SESSION['coupon_message'] = "<span style='color: red;'>Cupom inválido ou inativo.</span>";
            header("Location: cart.php");
            exit();
        }

        // --- Validações do Cupom ---

        // 1. Validade (data)
        if ($cupom['data_validade'] && date('Y-m-d') > $cupom['data_validade']) {
            $_SESSION['coupon_message'] = "<span style='color: red;'>Cupom expirado.</span>";
            header("Location: cart.php");
            exit();
        }

        // 2. Limite de usos (se houver)
        if ($cupom['quantidade_usos'] != -1 && $cupom['usos_atuais'] >= $cupom['quantidade_usos']) {
            $_SESSION['coupon_message'] = "<span style='color: red;'>Este cupom já atingiu o limite de usos.</span>";
            header("Location: cart.php");
            exit();
        }

        // 3. Valor mínimo de compra
        $total_carrinho = 0;
        if (isset($_SESSION['carrinho'])) {
            foreach ($_SESSION['carrinho'] as $item) {
                $total_carrinho += $item['preco'] * $item['quantidade'];
            }
        }

        if ($total_carrinho < $cupom['min_valor_compra']) {
            $_SESSION['coupon_message'] = "<span style='color: red;'>Valor mínimo de compra de R$ " . number_format($cupom['min_valor_compra'], 2, ',', '.') . " não atingido para este cupom.</span>";
            header("Location: cart.php");
            exit();
        }

        // --- Aplicar Desconto ---
        $desconto_aplicado = 0;
        if ($cupom['tipo_desconto'] == 'percentual') {
            $desconto_aplicado = $total_carrinho * ($cupom['valor_desconto'] / 100);
            // Opcional: limitar o desconto percentual a um valor máximo fixo
            // if ($desconto_aplicado > $cupom['max_desconto']) $desconto_aplicado = $cupom['max_desconto'];
        } elseif ($cupom['tipo_desconto'] == 'fixo') {
            $desconto_aplicado = $cupom['valor_desconto'];
        }

        // Garante que o desconto não exceda o total do carrinho
        if ($desconto_aplicado > $total_carrinho) {
            $desconto_aplicado = $total_carrinho;
        }

        // Armazena o cupom e o desconto na sessão
        $_SESSION['cupom_aplicado'] = $cupom;
        $_SESSION['desconto_aplicado'] = $desconto_aplicado;
        $_SESSION['coupon_message'] = "<span style='color: green;'>Cupom '" . htmlspecialchars($cupom['codigo']) . "' aplicado com sucesso!</span>";

        header("Location: cart.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['coupon_message'] = "<span style='color: red;'>Erro ao aplicar cupom: " . $e->getMessage() . "</span>";
        header("Location: cart.php");
        exit();
    }
} else {
    header("Location: cart.php"); // Se não for POST, redireciona de volta
    exit();
}
?>