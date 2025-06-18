<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>~OnlineBar~</title>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    // --- INÍCIO DA CONEXÃO COM O BANCO DE DADOS ---
    require_once 'config.php';

    try {
        $pdo = new PDO("sqlite:$databaseFile");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // --- FUNÇÕES PARA BUSCAR DADOS DO BANCO ---

        // Produtos em destaque (ex: em promoção)
        function getProdutosDestaque($pdo) {
            $stmt = $pdo->query("SELECT * FROM Produtos WHERE em_promocao = 1 LIMIT 3"); // Pega até 3 produtos em promoção
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Últimas novidades 
        function getUltimasNovidades($pdo) {
             $stmt = $pdo->query("SELECT * FROM Produtos ORDER BY data_cadastro DESC LIMIT 3");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Bebidas mais vendidas (isso requer uma tabela 'Itens_Pedido' com contagem)
        // Adaptado para simular, pegando produtos com maior estoque (substitua pela lógica correta)
        function getBebidasMaisVendidas($pdo) {
            $stmt = $pdo->query("SELECT * FROM Produtos ORDER BY estoque DESC LIMIT 3"); // Simulação
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // --- BUSCA OS DADOS ---
        $produtosDestaque = getProdutosDestaque($pdo);
        $ultimasNovidades = getUltimasNovidades($pdo);
        $bebidasMaisVendidas = getBebidasMaisVendidas($pdo);

        $pdo = null; // Fecha a conexão

    } catch (PDOException $e) {
        echo "<p style='color: red; text-align: center;'>Erro ao carregar dados: " . $e->getMessage() . "</p>";
        $produtosDestaque = [];
        $ultimasNovidades = [];
        $bebidasMaisVendidas = [];
    }
    ?>

    <header class="header">
        <h1 class="logo"><a href="index.php">🍺</a></h1>
        <nav class="nav">
            <?php if (isset($_SESSION['localizacao'])): ?>
                <p style="text-align: center; background-color: #F5F5DC; padding: 5px; font-size: 14px;">📍 Entregando em: <strong><?php echo $_SESSION['localizacao']; ?></strong></p>
            <?php endif; ?>
            <a href="index.php"> Home </a>
            <a href="favoritos.php"> 🤍 </a>
            <a href="cart.php"> 🛒 (<?= array_sum(array_column($_SESSION['carrinho'] ?? [], 'quantidade')) ?>) </a>
            <a href="user.php"> 👤 </a>
        </nav>
    </header>

    <section id="home" class="banner">
        <div class="banner-content">
            <h2>OnlineBar</h2>
            <p>Sua experiência única nas compras de Bebidas de Forma Online</p>
            <div class="localizacao-box">
                <form id="formLocalizacao" action="salvar_localizacao.php" method="POST">
                    <input type="text" name="localizacao" id="campoLocalizacao" placeholder="Digite sua localização..." required>
                    <button type="button" onclick="obterLocalizacao()">📍</button>
                </form>
            </div>
        </div>
    </section>

    <section id="destaque" class="promocoes">
        <h2>Produtos em Destaque</h2>
        <div class="my-carousel promocoes-carousel">
            <?php foreach ($produtosDestaque as $produto): ?>
                <div>
                    <img src="<?= htmlspecialchars($produto['imagem_url']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                    <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                    <p><?= htmlspecialchars($produto['descricao']) ?></p>
                    <p>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="novidades" class="promocoes">
        <h2>Últimas Novidades</h2>
        <div class="my-carousel promocoes-carousel">
            <?php foreach ($ultimasNovidades as $produto): ?>
                <div>
                    <img src="<?= htmlspecialchars($produto['imagem_url']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                     <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                    <p><?= htmlspecialchars($produto['descricao']) ?></p>
                    <p>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="mais-vendidas" class="promocoes">
        <h2>Bebidas Mais Vendidas</h2>
        <div class="my-carousel promocoes-carousel">
            <?php foreach ($bebidasMaisVendidas as $produto): ?>
                <div>
                    <img src="<?= htmlspecialchars($produto['imagem_url']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                     <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                    <p><?= htmlspecialchars($produto['descricao']) ?></p>
                    <p>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php
    // **IMPORTANTE:** Este código é um exemplo e depende de você implementar um sistema de login.
    // Ele assume que você está usando sessões PHP (`session_start()`) e que o nome do usuário
    // está armazenado em `$_SESSION['nome_usuario']`.
    if (isset($_SESSION['nome_usuario'])) {
        echo "<section class='usuario-logado'>";
        echo "<p>Bem-vindo(a), " . htmlspecialchars($_SESSION['nome_usuario']) . "!</p>";
        echo "</section>";
    }
    ?>

    <section id="servicos" class="servicos">
        <h2>Nossos Serviços</h2>
        <div class="servicos-grid">
            <div class="servicos-item">
                <a href="catalogo.php">
                    <h3>Catálogo</h3>
                    <p>Conheça nosso catálogo</p>
                    <img src="img/catalogo_home.jpg" alt="catalogo">
                </a>
            </div>

            <div class="servicos-item">
                <a href="cupons.html">
                    <h3>Cupons</h3>
                    <p>Conhaça nossos cupons</p>
                    <img src="img/cupon.png" alt="cupons">
                </a>
            </div>

            <div class="servicos-item">
                <a href="area_vip.html">
                    <h3>Degustadores Pro</h3>
                    <p>Descubra nossos decontos e promoções imperdiveis</p>
                     <img src="img/vip.jpg" alt="vip">
                </a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2025 OnlineBar. Todos os direitos reservados</p>
    </footer>

    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="script.js"></script>
</body>
</html>