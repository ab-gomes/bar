<?php 
session_start();
//include 'includes/conexao.php'; 
?>
<?php
$usuario_logado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
?>
<!DOCTYPE html> 
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlineBar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script>
        // AVISO DE MAIORIDADE (mostrado uma vez)
        if (!localStorage.getItem('maioridadeConfirmada')) {
            alert("Este site é destinado a maiores de 18 anos.");
            localStorage.setItem('maioridadeConfirmada', 'true');
        }
    </script>

    <header class="header">
        <a href="index.php"><h1 class="logo">OnlineBar</h1></a>
        <div class="header-icons">
            <a href="carrinho.php" class="cart">🛒</a>
            <?php if ($usuario_logado): ?>
                <span class="user-logado">Olá, <?= htmlspecialchars($usuario_logado) ?></span>
                <a href="logout.php" title="Sair">Sair</a>
            <?php else: ?>
                <a href="login.php" title="Login">👤</a>
            <?php endif; ?>
        </div>
    </header>

    <section id="home" class="banner">
        <div class="banner-content">
            <h2>Bem-vindo ao seu Bar Online</h2>
            <p>Uma experiência única na sua compra</p>
            <form method="GET" action="localizacao.php" class="barra-localizacao" onsubmit="return validarLocalizacao();">
                <input type="text" name="local" id="campoLocal" placeholder="Digite seu bairro ou CEP" required>
                <button type="submit">Pesquisar</button>
            </form>
            <p class="localizacao-info">Entregamos em todo o Brasil</p>
        </div>
    </section>

    <section id="bebidas" class="bebidas">
        <h2>Tipos de Bebidas</h2>
        <div class="bebidas-grid">
            <div class="bebidas-card">
                <a href="cervejas.php">
                    <img src="img/cerva.jpg" alt="cervejas">
                    <h3>Cervejas</h3>
                    <p>Conheça nossas cervejas</p>
                </a>
            </div>
            <div class="bebidas-card">
                <a href="vinho.php">
                    <img src="img/vinho.jpg" alt="vinhos">
                    <h3>Vinhos</h3>
                    <p>Conheça nossos vinhos</p>
                </a>
            </div>
            <div class="bebidas-card">
                <a href="refri.php">
                    <img src="img/refr.jpg" alt="refrigerantes">
                    <h3>Não Alcoólicos</h3>
                    <p>Conheça nossas bebidas não alcoólicas</p>
                </a>
            </div>
            <div class="bebidas-card">
                <a href="destilados.php">
                    <img src="img/detilado.jpg" alt="destilados">
                    <h3>Destilados</h3>
                    <p>Conheça nossos destilados</p>
                </a>
            </div>
        </div>
    </section>

    <section id="servicos" class="servicos">
        <h2>Nossos Serviços</h2>
        <div class="servicos-grid">
            <div class="servicos-item">
                <a href="catalogo.php">
                    <h3>Catálogo</h3>
                    <p>Confira nossos produtos</p>
                    <img src="img/catalogo_home.jpg" alt="Catálogo">
                </a>
            </div>
            <div class="servicos-item">
                <a href="promocoes.php">
                    <h3>Promoções</h3>
                    <p>Confira nossas promoções</p>
                    <img src="img/promo.jpg" alt="Promoções">
                </a>
            </div>
            <div class="servicos-item">
                <a href="vip.php">
                    <h3>Área VIP</h3>
                    <p>Descontos e novidades exclusivas</p>
                    <img src="img/vip.jpg" alt="VIP">
                </a>
            </div>
            <div class="servicos-item">
                <a href="entregador.php">
                    <h3>Seja um entregador</h3>
                    <p>Trabalhe conosco</p>
                    <img src="img/entregador.jpg" alt="Entregador">
                </a>
            </div>
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
        function validarLocalizacao() {
            const campo = document.getElementById('campoLocal').value;
            if (campo.trim().length < 3) {
                alert("Digite um bairro ou CEP válido.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>