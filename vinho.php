<?php
session_start();
//include 'includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $id = intval($_POST['wine_id']);
    $nome = $_POST['wine_name'];
    $preco = floatval($_POST['wine_price']);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Se já tiver no carrinho, soma 1, senão adiciona
    if (isset($_SESSION['cart'][$id])) {
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
<?php if (isset($_GET['added'])): ?>
<div id="notification" class="notification">Item adicionado ao carrinho!</div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vinho.css">
    <title>OnlineBar</title>
</head>
<body>
        <header class="header">
            <a href="index.php"><h1 class="logo">OnlineBar</h1></a>        
    </header><header class="header">
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
    <?php if (isset($_GET['added'])): ?>
<div id="notification" class="notification">Item adicionado ao carrinho!</div>
<?php endif; ?>
    <section id="home" class="banner">
        <div class="banner-content">
            <h2>Vinhos</h2>
        </div>
    </section>

        <section id="vinhoN" class="vinhoN">
        <h2>Vinhos Nacionais</h2>
        <div class="vinhoN-grid">
            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/miolo2.jpg" alt="Miolo">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Aurora">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Salton">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Casa Valduga">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Pizzato">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Pirini">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Marco Luigi">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Dom Lurido">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Peterlongo">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Lidio Carraro">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Vallontano">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Garibaldi">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Vinhas Don Giovanni">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Campos de Cima">
                </a>
            </div>

            <div class="vinhoN-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Boscato">
                </a>
            </div>
    </section>


    <section id="vinhoI" class="vinhoI">
        <h2>Vinhos Internacionais</h2>
        <div class="vinhoI-grid">
                <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Catena Zapata">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Luigi Bosca">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Trapiche">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Norton">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Rutini Wines">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Alamos">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Terrazas de los Andes">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Zuccardi">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Concha y Toro">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Santa Carolina">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Casillero del Diablo">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Undurraga">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Santa Rita">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Tarapacá">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Emiliana">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Montes Alpha">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Antinori">
                </a>
            </div>

             <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Masi">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Ruffino">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Bolla">
                </a>
            </div>

             <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Zonin">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Frescobaldi">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Château Margaux">
                </a>
            </div>
            

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Château Lafite Rothschild">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Moët & Chandon">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Louis Jadot">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Château Latour">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Dom Pérignon">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Marqués de Riscal">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Torres">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="CVNE ">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Freixenet">
                </a>
            </div>

            <div class="vinhoI-item">
                <a href="#">
                    <h3></h3>
                    <h5>Clique aqui para</h5>
                    <p>mais descrição</p>
                    <img src="img/" alt="Protos">
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
    
</body>
</html>