<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="refri.css">
    <title>OnlineBar</title>
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
            <h2>Ñ ALCOOLICOS</h2>
        </div>
    </section>
    <?php
function renderSection($titulo, $produtos) {
    echo "<section class='refri'>";
    echo "<h2>$titulo</h2>";
    echo "<div class='refri-grid'>";
    foreach ($produtos as $produto) {
        $nome = htmlspecialchars($produto['nome']);
        $descricao = htmlspecialchars($produto['descricao']);
        $imagem = htmlspecialchars($produto['imagem']);
        echo "<div class='refri-item'>";
        echo "<a href='#' class='produto-link' data-nome='$nome' data-descricao='$descricao'>";
        echo "<h3>$nome</h3>";
        echo "<h5>Clique aqui para</h5>";
        echo "<p>mais descrição</p>";
        echo "<img src='$imagem' alt='Imagem de $nome'>";
        echo "</a>";
        echo "</div>";
    }
    echo "</div>";
    echo "</section>";
}

renderSection("Refrigerantes", $produtos['refrigerantes']);
renderSection("Sucos Prontos", $produtos['sucos']);
renderSection("PÁguas, Chás e Bebidas Funcionais", $produtos['aguas']);
renderSection("Isotônicos / Energéticos / Funcionais", $produtos['isotonicos']);
?>

    <section id="refri" class="refri">
        <h2>Refrigerantes</h2>
        <div class="refri-grid">
            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>
        </div>    
    </section>

    <section id="refri" class="refri">
        <h2>Sucos Prontos</h2>
        <div class="refri-grid">
            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>
        </div>    
    </section>

    <section id="refri" class="refri">
        <h2>PÁguas, Chás e Bebidas Funcionais</h2>
        <div class="refri-grid">
            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>
        </div>    
    </section>

    <section id="refri" class="refri">
        <h2>Isotônicos / Energéticos / Funcionais</h2>
        <div class="refri-grid">
            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>
 
            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="refri-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
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

    <script>
    // JavaScript para exibir alert com descrição do produto ao clicar
    document.querySelectorAll('.produto-link').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const nome = link.getAttribute('data-nome');
            const descricao = link.getAttribute('data-descricao');
            alert(nome + ":\n" + descricao);
        });
    });
    </script>
    
</body>
</html>