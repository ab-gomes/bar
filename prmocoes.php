<?php 
session_start();
//include 'includes/conexao.php'; 
?>
<?php
// Simulando dados das promoções em PHP
$promocoes = [
    'cervejas' => [
        [
            'nome' => 'Cerveja Skol',
            'descricao' => 'Lata 350ml - Refrescante e leve',
            'imagem' => 'img/skol1.jpg',
            'link' => 'produto.php?id=1'
        ],
        [
            'nome' => 'Cerveja Brahma',
            'descricao' => 'Lata 350ml - Tradicional',
            'imagem' => 'img/brahma1.jpg',
            'link' => 'produto.php?id=2'
        ],
        [
            'nome' => 'Cerveja Heineken',
            'descricao' => 'Garrafa 600ml - Premium',
            'imagem' => 'img/heineken1.jpg',
            'link' => 'produto.php?id=3'
        ],
        [
            'nome' => 'Cerveja Antarctica',
            'descricao' => 'Lata 350ml - Clássica',
            'imagem' => 'img/antartica1.jpg',
            'link' => 'produto.php?id=4'
        ],
    ],
    'vinhos' => [
        [
            'nome' => 'Vinho Tinto Reserva',
            'descricao' => '750ml - Sabor encorpado',
            'imagem' => 'img/vinho_tinto.jpg',
            'link' => 'produto.php?id=5'
        ],
        // mais promoções de vinho...
    ],
    'destilados' => [
        [
            'nome' => 'Whisky Johnnie Walker',
            'descricao' => '750ml - Blend premium',
            'imagem' => 'img/johnnie.jpg',
            'link' => 'produto.php?id=6'
        ],
        // mais promoções de destilados...
    ],
    'nao_alcoolicos' => [
        [
            'nome' => 'Refrigerante Coca-Cola',
            'descricao' => 'Lata 350ml - Original',
            'imagem' => 'img/coca.jpg',
            'link' => 'produto.php?id=7'
        ],
        // mais promoções não alcoólicas...
    ]
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="promocoes.css" />
    <title>OnlineBar</title>
</head>
<body>

<header class="header">
    <a href="index.html"><h1 class="logo">OnlineBar</h1></a>
    <div class="header-icons">
        <a href="carrinho.html" class="cart" title="Carrinho">
            <!-- SVG do carrinho -->
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z"/></svg>
        </a>
        <a href="login.html" title="Login">
            <!-- SVG do login -->
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z"/></svg>
        </a>
    </div>
</header>

<section id="home" class="banner">
    <div class="banner-content">
        <h2>Promoções</h2>
    </div>
</section>

<!-- Função para renderizar promoções -->
<?php
function mostrarPromocoes($categoria, $titulo, $dados) {
    echo "<section class='promo'>";
    echo "<h2>PROMO $titulo</h2>";
    echo "<div class='promo-grid'>";
    foreach($dados as $item) {
        echo "<div class='promo-item'>";
        echo "<a href='{$item['link']}' class='promo-link' data-nome='{$item['nome']}' data-descricao='{$item['descricao']}'>";
        echo "<h3>{$item['nome']}</h3>";
        echo "<h5>Clique aqui para</h5>";
        echo "<p>{$item['descricao']}</p>";
        echo "<img src='{$item['imagem']}' alt='{$item['nome']}' />";
        echo "</a>";
        echo "</div>";
    }
    echo "</div>";
    echo "</section>";
}
?>

<?php
mostrarPromocoes('cervejas', 'CERVEJAS', $promocoes['cervejas']);
mostrarPromocoes('vinhos', 'VINHOS', $promocoes['vinhos']);
mostrarPromocoes('destilados', 'DESTILADOS', $promocoes['destilados']);
mostrarPromocoes('nao_alcoolicos', 'Ñ ALCOOLICOS', $promocoes['nao_alcoolicos']);
?>

<footer class="footer">
    <p>&copy; 2025 OnlineBar. Todos os diretos reservados</p>
    <ul>
        <li>
            <a href="#">Sobre Nós</a>
            <a href="#">Perguntas Frequentes (FAQ)</a>
            <a href="#">Contato</a>
            <a href="#">Política de Privacidade</a>
            <a href="#">Termos e Condições de Uso</a>
        </li>
    </ul>
</footer>

<!-- Modal para exibir detalhes da promoção -->
<div id="promoModal" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%); background:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px #000; max-width:400px; z-index:1000;">
    <h3 id="modalNome"></h3>
    <p id="modalDescricao"></p>
    <button id="fecharModal">Fechar</button>
</div>

<script>
// JavaScript para interatividade das promoções
document.querySelectorAll('.promo-link').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // prevenir navegação
        const nome = this.getAttribute('data-nome');
        const descricao = this.getAttribute('data-descricao');
        
        document.getElementById('modalNome').textContent = nome;
        document.getElementById('modalDescricao').textContent = descricao;
        document.getElementById('promoModal').style.display = 'block';
    });
});

document.getElementById('fecharModal').addEventListener('click', function() {
    document.getElementById('promoModal').style.display = 'none';
});
</script>

</body>
</html>