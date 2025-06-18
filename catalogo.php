<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="catalogo.css">
    <title>~OnlineBar~</title>
</head>
<body>
    <header class="header">
        <h1 class="logo">🍺</h1>
        <nav class="nav">
            <a href="index.php"> Home </a>
            <a href="favoritos.php"> 🤍 </a>
            <a href="cart.php"> 🛒 (<?= array_sum(array_column($_SESSION['carrinho'] ?? [], 'quantidade')) ?>) </a>
            <a href="user.php"> 👤 </a>
        </nav>
    </header>

    <section id="banner-catalogo" class="banner">
        <div class="banner-content">
            <h2>Catálogo OnlineBar</h2>
            <p>Encontre a bebida perfeita para cada momento!</p>
            <div class="search-bar-container">
                <input type="text" id="search-input" placeholder="Pesquisar por nome ou marca...">
                <button id="search-button">Buscar</button>
            </div>
        </div>
    </section>

    <div class="category-filters-container">
        <?php
        require_once 'config.php';
        $pdo = null; // Initialize to null
        // Pega os favoritos da sessão, se existirem
        $favoritos = $_SESSION['favoritos'] ?? [];

        try {
            $pdo = new PDO("sqlite:$databaseFile");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch categories for filter sections
            $stmt_categorias = $pdo->query("SELECT id_categoria, nome_categoria FROM Categorias ORDER BY nome_categoria");
            $categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

            // Add 'Promoções' as a special filter option
            echo '<div class="filter-category-item" data-filter-type="promocao" data-filter-value="sim"><h3>Promoções ✨</h3></div>';
            
            foreach ($categorias as $categoria) {
                // Remove accents and spaces from category name for data-filter-value
                $filter_value = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '', str_replace(' ', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $categoria['nome_categoria']))));
                echo '<div class="filter-category-item" data-filter-type="tipo" data-filter-value="' . htmlspecialchars($filter_value) . '">';
                echo '<h3>' . htmlspecialchars($categoria['nome_categoria']) . '</h3>';
                echo '</div>';
            }

        } catch (PDOException $e) {
            echo "<p style='color: red; text-align: center;'>Erro ao carregar categorias: " . $e->getMessage() . "</p>";
            $categorias = []; // Ensure it's an empty array if error
        }
        ?>
    </div>

    <section id="catalogo-completo" class="bebidas main-catalog">
        <h2>Todas as Bebidas</h2>

        <div class="filters-panel">
            <div class="filter-group">
                <label for="filter-tipo">Tipo:</label>
                <select id="filter-tipo">
                    <option value="todos">Todos</option>
                    <?php
                    // Populate type filter options dynamically from Categories table
                    if (isset($categorias) && is_array($categorias)) {
                        foreach ($categorias as $categoria) {
                            $filter_value = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '', str_replace(' ', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $categoria['nome_categoria']))));
                            echo '<option value="' . htmlspecialchars($filter_value) . '">' . htmlspecialchars($categoria['nome_categoria']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="filter-teor">Teor Alcoólico:</label>
                <select id="filter-teor">
                    <option value="todos">Todos</option>
                    <option value="alto">Alto (> 15%)</option>
                    <option value="medio">Médio (5% - 15%)</option>
                    <option value="baixo">Baixo (< 5%)</option>
                    <option value="zero">Zero Álcool</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="filter-promocao">Promoção:</label>
                <select id="filter-promocao">
                    <option value="todos">Todos</option>
                    <option value="sim">Em Promoção</option>
                    <option value="nao">Não em Promoção</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="filter-origem">País de Origem:</label>
                <select id="filter-origem">
                    <option value="todos">Todos</option>
                    <option value="brasil">Brasil</option>
                    <option value="argentina">Argentina</option>
                    <option value="franca">França</option>
                    <option value="alemanha">Alemanha</option>
                    <option value="eua">EUA</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="filter-preco">Preço Máx:</label>
                <input type="range" id="filter-preco" min="0" max="150" value="150" step="5">
                <span id="preco-max-value">R$ 150</span>
            </div>
            
            <div class="filter-group">
                <label for="filter-marca">Marca:</label>
                <input type="text" id="filter-marca" placeholder="Buscar por marca...">
            </div>
        </div>

        <div class="bebidas-grid" id="bebidas-lista">
            <?php
            // Fetch products from the database, joining with Categories to get category name
            $bebidas = [];
            try {
                $stmt = $pdo->query("SELECT 
                                        p.*, 
                                        c.nome_categoria 
                                     FROM Produtos p
                                     JOIN Categorias c ON p.id_categoria_fk = c.id_categoria");
                $bebidas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo "<p style='color: red; text-align: center;'>Erro ao carregar produtos: " . $e->getMessage() . "</p>";
                $bebidas = [];
            }

            foreach ($bebidas as $bebida) {
                $promocao_status = $bebida['em_promocao'] ? 'sim' : 'nao';
                // Clean category name for data-type attribute
                $item_tipo_data = strtolower(preg_replace('/[^a-zA-Z0-9-]/', '', str_replace(' ', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $bebida['nome_categoria']))));
                
                // Determine teor_categoria based on teor_alcoolico for filtering
                $teor_categoria = 'zero';
                if ($bebida['teor_alcoolico'] > 15) {
                    $teor_categoria = 'alto';
                } elseif ($bebida['teor_alcoolico'] >= 5 && $bebida['teor_alcoolico'] <= 15) {
                    $teor_categoria = 'medio';
                } elseif ($bebida['teor_alcoolico'] > 0 && $bebida['teor_alcoolico'] < 5) {
                    $teor_categoria = 'baixo';
                }
            ?>
                <div class="bebidas-item"
                     data-tipo="<?= htmlspecialchars($item_tipo_data) ?>"
                     data-teor-categoria="<?= htmlspecialchars($teor_categoria) ?>"
                     data-promocao="<?= htmlspecialchars($promocao_status) ?>"
                     data-origem="<?= htmlspecialchars(strtolower($bebida['pais_origem'])) ?>"
                     data-preco="<?= htmlspecialchars($bebida['preco']) ?>"
                     data-marca="<?= htmlspecialchars(strtolower($bebida['marca'])) ?>"
                     data-nome="<?= htmlspecialchars(strtolower($bebida['nome'])) ?>">
                    <a href="#">
                        <h3><?= htmlspecialchars($bebida['nome']) ?></h3>
                        <h5><?= htmlspecialchars($bebida['marca']) ?></h5>
                        <p>Teor: <?= htmlspecialchars($bebida['teor_alcoolico']) ?>%</p>
                        <p class="preco">R$ <?= number_format($bebida['preco'], 2, ',', '.') ?></p>
                        <?php if ($bebida['em_promocao']): ?>
                            <span class="promocao-tag">Em Promoção!</span>
                        <?php endif; ?>
                        <img src="<?= htmlspecialchars($bebida['imagem_url']) ?>" alt="<?= htmlspecialchars($bebida['nome']) ?>">
                    </a>
                    <div class="product-item" data-tipo="<?= htmlspecialchars($produto['tipo']) ?>" ...>
                        <p class="product-price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                        <form action="add_to_cart.php" method="post" class="add-to-cart-form">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($produto['id_produto']) ?>">
                            <input type="number" name="quantity" value="1" min="1" class="product-quantity">
                            <button type="submit" class="add-to-cart-btn">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                    <div class="product-item" data-tipo="<?= htmlspecialchars($produto['tipo']) ?>" ...>
    <p class="product-price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>

    <form action="add_to_cart.php" method="post" class="add-to-cart-form">
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($produto['id_produto']) ?>">
        <input type="number" name="quantity" value="1" min="1" class="product-quantity">
        <button type="submit" class="add-to-cart-btn">Adicionar ao Carrinho</button>
    </form>

    <?php
    $is_favorito = in_array($produto['id_produto'], $favoritos);
    $favorito_class = $is_favorito ? 'favorito-ativo' : '';
    ?>
                        <a href="add_remove_favorito.php?id=<?= htmlspecialchars($produto['id_produto']) ?>" class="favorito-btn <?= $favorito_class ?>" title="<?= $is_favorito ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos' ?>">🤍</a>
                        </div>

                </div>
            <?php
            }
            if (empty($bebidas)) {
                echo "<p style='text-align: center; grid-column: 1 / -1;'>Nenhuma bebida encontrada. Verifique se o 'setup_database.php' foi executado e se há dados.</p>";
            }
            ?>
            
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2025 OnlineBar. Todos os direitos reservados</p>
    </footer>

    <script src="catalogo.js"></script>
</body>
</html>