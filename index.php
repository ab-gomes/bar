<!DOCTYPE html> 
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title> OnlineBar </title>
</head>
<body>
   <header class="header">
        <a href="index.php"><h1 class="logo">OnlineBar</h1></a>
        <div class="header-icons">
            <a href="carrinho.php" class="cart">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z"/></svg>
            </a>
            <a href="login.php" class="user">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z"/></svg>
            </a>
        </div>
    </header>
    
    <section id="home" class="banner">
        <div class="banner-content">
            <h2>Bem-vindo ao seu Bar Online</h2>
            <p>Uma experiência unica na sua compra </p>
            <form method="GET" action="localizacao.php" class="barra-localizacao">
                <input type="text" name="local" placeholder="Digite seu bairro ou CEP" required>
                <button type="submit" aria-label="Localizar"> Pesquisar</button>
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
                    <p>conheça nossas cervejas</p>
                </a>
            </div>

            <div class="bebidas-card">
                <a href="vinho.php">
                    <img src="img/vinho.jpg" alt="vinhos">
                    <h3>Vinhos</h3>
                    <p>conheça nossos vinhos</p>
                </a>
            </div>

            <div class="bebidas-card">
                <a href="refri.php">
                    <img src="img/refr.jpg" alt="refr">
                    <h3>Não Alcoolicos</h3>
                    <p>conheça nossas bebidas ñ alcoolicas</p>
                </a>
            </div>

            <div class="bebidas-card">
                <a href="destilados.php">
                <img src="img/detilado.jpg" alt="destilados">
                <h3>Destilados</h3>
                <p>conheça nossos destilados</p>
                </a>
            </div>
        </div>
    </section>


    <section id="servicos" class="servicos">
        <h2>Nossos Serviços</h2>
        <div class="servicos-grid">
            <div class="servicos-item">
                <a href="catalogo.php">
                    <h3>Catalogo</h3>
                    <p>Confira nossos produtos</p>
                    <img src="img/catalogo_home.jpg" alt="Catalogo">
                </a>
            </div>

            <div class="servicos-item">
                <a href="prmocoes.php">
                    <h3>Promoções</h3>
                    <p>Confira nossas Promoções</p>
                    <img src="img/promo.jpg" alt="Promocoes">
                </a>
            </div>

            <div class="servicos-item">
                <a href="vip.php">
                    <h3>Area Vip</h3>
                    <p>Venha ser um cliente vip e descubra descontos e novos produtos antecipadamente</p>
                     <img src="img/vip.jpg" alt="Vip">
                </a>
            </div>

            <div class="servicos-item">
                <a href="entregador.php">
                    <h3>Venha ser um entregador</h3>
                    <p>Venha trabalhar conosco</p>
                     <img src="img/entregador.jpg" alt="Vip">
                </a>
            </div>
        </div>
    </section>


    <footer class="footer">
        <p>&copy; 2025 OnlineBar. Todos os diretos reservados</p>
        <ul>
            <li>
                <a href="#">Sobre Nós</a>
                <a href="#">Perguntas Frequentes (FAQ)</a>
                <a href="#">Contato</a>
                <a href="#">politica de privacidade</a>
                <a href="#">Termos e condições de uso</a>
            </li>
        </ul>
    </footer>

    <script src="script.js"></script>

</body>
</html>