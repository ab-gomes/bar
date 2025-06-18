<?php

// Define o nome do arquivo do banco de dados SQLite
$databaseFile = 'database.db';

// --- INÍCIO DA CONEXÃO COM O BANCO DE DADOS ---
$pdo = null; // Inicializa a variável PDO

try {
    // Tenta criar uma nova conexão PDO com o arquivo SQLite.
    // Se o arquivo 'database.db' não existir, ele será criado automaticamente.
    $pdo = new PDO("sqlite:$databaseFile");
    
    // Define o modo de erro do PDO para EXCEÇÕES. Isso é crucial!
    // Significa que qualquer erro no SQL ou na conexão lançará uma exceção PHP,
    // que pode ser capturada no bloco 'catch' para depuração.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conexão com o banco de dados SQLite estabelecida com sucesso.<br>";

    // --- CRIAÇÃO DA TABELA USUARIOS ---
    $sql_usuarios = "
        CREATE TABLE IF NOT EXISTS Usuarios (
            id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL, -- Email deve ser único
            senha_hash VARCHAR(255) NOT NULL, -- Armazena o hash da senha (NUNCA a senha em texto puro!)
            cpf VARCHAR(14) UNIQUE NOT NULL, -- CPF único para identificação e verificação de idade
            data_nascimento DATE NOT NULL, -- Para verificar a maioridade
            telefone VARCHAR(20),
            data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
            tipo_usuario VARCHAR(20) NOT NULL DEFAULT 'cliente' -- Ex: 'cliente', 'admin', 'entregador'
        );
    ";
    // Criação da tabela Cupons
$pdo->exec("CREATE TABLE IF NOT EXISTS Cupons (
    id_cupom INTEGER PRIMARY KEY AUTOINCREMENT,
    codigo TEXT NOT NULL UNIQUE,
    tipo_desconto TEXT NOT NULL CHECK(tipo_desconto IN ('percentual', 'fixo')),
    valor_desconto REAL NOT NULL,
    data_validade DATE,
    quantidade_usos INTEGER DEFAULT -1, -- -1 para ilimitado, > 0 para limitado
    usos_atuais INTEGER DEFAULT 0,
    min_valor_compra REAL DEFAULT 0.0,
    ativo INTEGER DEFAULT 1 -- 1 para ativo, 0 para inativo
)");

echo "<p>Tabela 'Cupons' verificada/criada com sucesso.</p>";

// Inserção de Cupons de exemplo (apenas se a tabela estiver vazia)
$stmt = $pdo->query("SELECT COUNT(*) FROM Cupons");
if ($stmt->fetchColumn() == 0) {
    $cupons = [
        [
            'codigo' => 'DESC10',
            'tipo_desconto' => 'percentual',
            'valor_desconto' => 10.0, // 10%
            'data_validade' => '2025-12-31',
            'quantidade_usos' => -1,
            'min_valor_compra' => 0.0
        ],
        [
            'codigo' => 'FRETEGRATIS',
            'tipo_desconto' => 'fixo',
            'valor_desconto' => 15.0, // Exemplo: valor fixo para cobrir frete ou desconto alto
            'data_validade' => '2025-11-30',
            'quantidade_usos' => 10, // Limitado a 10 usos
            'min_valor_compra' => 50.0
        ],
        [
            'codigo' => 'VERAO20',
            'tipo_desconto' => 'percentual',
            'valor_desconto' => 20.0, // 20%
            'data_validade' => '2025-09-15',
            'quantidade_usos' => -1,
            'min_valor_compra' => 100.0
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO Cupons (codigo, tipo_desconto, valor_desconto, data_validade, quantidade_usos, min_valor_compra) VALUES (:codigo, :tipo_desconto, :valor_desconto, :data_validade, :quantidade_usos, :min_valor_compra)");
    foreach ($cupons as $cupom) {
        $stmt->execute($cupom);
    }
    echo "<p>Cupons de exemplo inseridos com sucesso.</p>";
} else {
    echo "<p>Cupons de exemplo já existem na tabela.</p>";
}
    $pdo->exec($sql_usuarios); // Executa a query para criar a tabela
    echo "Tabela 'Usuarios' verificada/criada.<br>";

    // --- CRIAÇÃO DA TABELA ENDERECOS ---
    $sql_enderecos = "
        CREATE TABLE IF NOT EXISTS Enderecos (
            id_endereco INTEGER PRIMARY KEY AUTOINCREMENT,
            id_usuario_fk INTEGER NOT NULL, -- Chave estrangeira para a tabela Usuarios
            rua VARCHAR(100) NOT NULL,
            numero VARCHAR(10),
            complemento VARCHAR(50),
            bairro VARCHAR(50) NOT NULL,
            cidade VARCHAR(50) NOT NULL,
            estado VARCHAR(2),
            cep VARCHAR(10) NOT NULL,
            referencia VARCHAR(100),
            tipo_endereco VARCHAR(20) DEFAULT 'entrega', -- Ex: 'entrega', 'cobranca'
            CONSTRAINT fk_usuario_endereco FOREIGN KEY (id_usuario_fk) REFERENCES Usuarios(id_usuario)
        );
    ";
    $pdo->exec($sql_enderecos);
    echo "Tabela 'Enderecos' verificada/criada.<br>";

    // --- CRIAÇÃO DA TABELA CATEGORIAS ---
    $sql_categorias = "
        CREATE TABLE IF NOT EXISTS Categorias (
            id_categoria INTEGER PRIMARY KEY AUTOINCREMENT,
            nome_categoria VARCHAR(50) UNIQUE NOT NULL -- Ex: 'Cerveja', 'Vinho', 'Destilado'
        );
    ";
    $pdo->exec($sql_categorias);
    echo "Tabela 'Categorias' verificada/criada.<br>";

    // --- INSERÇÃO DE DADOS DE EXEMPLO NA TABELA CATEGORIAS ---
    // Verifica se já existem categorias para não inserir duplicadas
    $stmt = $pdo->query("SELECT COUNT(*) FROM Categorias");
    if ($stmt->fetchColumn() == 0) { // Se não houver categorias, insere as padrão
        $categorias_exemplo = [
            'Cerveja', 'Vinho', 'Destilado', 'Não Alcoólico', 'Cachaça', 'Licores'
        ];
        foreach ($categorias_exemplo as $cat_nome) {
            $stmt = $pdo->prepare("INSERT INTO Categorias (nome_categoria) VALUES (:nome_categoria)");
            $stmt->execute([':nome_categoria' => $cat_nome]);
        }
        echo "Categorias de exemplo inseridas.<br>";
    } else {
        echo "Categorias já existem no banco de dados. Pulando inserção de exemplos.<br>";
    }

    // --- CRIAÇÃO DA TABELA PRODUTOS ---
    $sql_produtos = "
        CREATE TABLE IF NOT EXISTS Produtos (
            id_produto INTEGER PRIMARY KEY AUTOINCREMENT,
            nome VARCHAR(100) NOT NULL,
            marca VARCHAR(50) NOT NULL,
            id_categoria_fk INTEGER NOT NULL, -- Chave estrangeira para a tabela Categorias
            teor_alcoolico REAL,
            volume_ml INTEGER,
            preco REAL NOT NULL,
            estoque INTEGER NOT NULL DEFAULT 0,
            descricao TEXT,
            imagem_url VARCHAR(255),
            pais_origem VARCHAR(50),
            em_promocao INTEGER NOT NULL DEFAULT 0, -- 0=false, 1=true
            data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_categoria_produto FOREIGN KEY (id_categoria_fk) REFERENCES Categorias(id_categoria)
        );
    ";
    $pdo->exec($sql_produtos);
    echo "Tabela 'Produtos' verificada/criada.<br>";

    // --- INSERÇÃO DE DADOS DE EXEMPLO NA TABELA PRODUTOS ---
    // Primeiro, recupere os IDs das categorias para associá-los aos produtos
    $stmt = $pdo->query("SELECT id_categoria, nome_categoria FROM Categorias");
    $categorias_map = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categorias_map[$row['nome_categoria']] = $row['id_categoria'];
    }

    $stmt = $pdo->query("SELECT COUNT(*) FROM Produtos");
    if ($stmt->fetchColumn() == 0 && !empty($categorias_map)) { // Só insere se não houver produtos e se tiver categorias
        $produtos = [
            [
                'nome' => 'Stella Artois', 'marca' => 'Ambev', 'tipo_categoria' => 'Cerveja',
                'teor_alcoolico' => 5.0, 'volume_ml' => 330, 'preco' => 4.99, 'estoque' => 100,
                'descricao' => 'Cerveja puro malte, clássica e refrescante.',
                'imagem_url' => 'img/stella1.jpg', 'pais_origem' => 'Bélgica', 'em_promocao' => 0
            ],
            [
                'nome' => 'Vinho Tinto Suave', 'marca' => 'Góes', 'tipo_categoria' => 'Vinho',
                'teor_alcoolico' => 10.5, 'volume_ml' => 750, 'preco' => 25.00, 'estoque' => 50,
                'descricao' => 'Vinho tinto suave de mesa, ideal para o dia a dia.',
                'imagem_url' => 'img/vinho_goes.jpg', 'pais_origem' => 'Brasil', 'em_promocao' => 1
            ],
            [
                'nome' => 'Whisky Jack Daniels', 'marca' => 'Jack Daniel\'s', 'tipo_categoria' => 'Destilado',
                'teor_alcoolico' => 40.0, 'volume_ml' => 1000, 'preco' => 120.00, 'estoque' => 30,
                'descricao' => 'Autêntico Tennessee Whiskey, suave e marcante.',
                'imagem_url' => 'img/jackdaniels.jpg', 'pais_origem' => 'EUA', 'em_promocao' => 0
            ],
            [
                'nome' => 'Coca-Cola', 'marca' => 'Coca-Cola', 'tipo_categoria' => 'Não Alcoólico',
                'teor_alcoolico' => 0.0, 'volume_ml' => 350, 'preco' => 3.50, 'estoque' => 200,
                'descricao' => 'Refrigerante sabor cola.',
                'imagem_url' => 'img/cocalata.jpg', 'pais_origem' => 'EUA', 'em_promocao' => 0
            ],
            [
                'nome' => 'Cerveja IPA', 'marca' => 'Colorado', 'tipo_categoria' => 'Cerveja',
                'teor_alcoolico' => 6.5, 'volume_ml' => 600, 'preco' => 18.90, 'estoque' => 70,
                'descricao' => 'Cerveja artesanal estilo IPA com notas cítricas.',
                'imagem_url' => 'img/colorado1.jpg', 'pais_origem' => 'Brasil', 'em_promocao' => 1
            ],
            [
                'nome' => 'Cachaça Artesanal', 'marca' => 'Velho Barreiro', 'tipo_categoria' => 'Cachaça',
                'teor_alcoolico' => 39.0, 'volume_ml' => 960, 'preco' => 35.00, 'estoque' => 40,
                'descricao' => 'Cachaça tradicional brasileira.',
                'imagem_url' => 'img/velho_barreiro.jpg', 'pais_origem' => 'Brasil', 'em_promocao' => 0
            ],
             [
                'nome' => 'Licor de Cereja', 'marca' => 'Stock', 'tipo_categoria' => 'Licores',
                'teor_alcoolico' => 25.0, 'volume_ml' => 720, 'preco' => 45.00, 'estoque' => 25,
                'descricao' => 'Licor doce e aromático de cereja.',
                'imagem_url' => 'img/licor_cereja.jpg', 'pais_origem' => 'Itália', 'em_promocao' => 0
            ]
        ];

        $stmt = $pdo->prepare("
            INSERT INTO Produtos (
                nome, marca, id_categoria_fk, teor_alcoolico, volume_ml, preco, estoque,
                descricao, imagem_url, pais_origem, em_promocao
            ) VALUES (
                :nome, :marca, :id_categoria_fk, :teor_alcoolico, :volume_ml, :preco, :estoque,
                :descricao, :imagem_url, :pais_origem, :em_promocao
            )
        ");

        foreach ($produtos_exemplo as $data) {
            if (isset($categorias_map[$data['tipo_categoria']])) {
                $stmt->execute([
                    ':nome' => $data['nome'],
                    ':marca' => $data['marca'],
                    ':id_categoria_fk' => $categorias_map[$data['tipo_categoria']], // Usa o ID da categoria
                    ':teor_alcoolico' => $data['teor_alcoolico'],
                    ':volume_ml' => $data['volume_ml'],
                    ':preco' => $data['preco'],
                    ':estoque' => $data['estoque'],
                    ':descricao' => $data['descricao'],
                    ':imagem_url' => $data['imagem_url'],
                    ':pais_origem' => $data['pais_origem'],
                    ':em_promocao' => $data['em_promocao']
                ]);
            } else {
                echo "Aviso: Categoria '{$data['tipo_categoria']}' para o produto '{$data['nome']}' não encontrada. Produto não inserido.<br>";
            }
        }
        echo "Dados de exemplo de Produtos inseridos com sucesso.<br>";
    } else {
        echo "Produtos já existem ou categorias não foram carregadas. Pulando inserção de exemplos.<br>";
    }

    // --- CRIAÇÃO DA TABELA PEDIDOS ---
    $sql_pedidos = "
        CREATE TABLE IF NOT EXISTS Pedidos (
            id_pedido INTEGER PRIMARY KEY AUTOINCREMENT,
            id_usuario_fk INTEGER NOT NULL,
            id_endereco_entrega_fk INTEGER NOT NULL,
            data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
            status_pedido VARCHAR(50) NOT NULL DEFAULT 'pendente',
            valor_total REAL NOT NULL,
            valor_frete REAL NOT NULL,
            metodo_pagamento VARCHAR(50) NOT NULL,
            codigo_rastreamento VARCHAR(100),
            observacoes TEXT,
            CONSTRAINT fk_usuario_pedido FOREIGN KEY (id_usuario_fk) REFERENCES Usuarios(id_usuario),
            CONSTRAINT fk_endereco_pedido FOREIGN KEY (id_endereco_entrega_fk) REFERENCES Enderecos(id_endereco)
        );
    ";
    $pdo->exec($sql_pedidos);
    echo "Tabela 'Pedidos' verificada/criada.<br>";

    // --- CRIAÇÃO DA TABELA ITENS_PEDIDO ---
    $sql_itens_pedido = "
        CREATE TABLE IF NOT EXISTS Itens_Pedido (
            id_item_pedido INTEGER PRIMARY KEY AUTOINCREMENT,
            id_pedido_fk INTEGER NOT NULL,
            id_produto_fk INTEGER NOT NULL,
            quantidade INTEGER NOT NULL,
            preco_unitario REAL NOT NULL,
            CONSTRAINT fk_pedido_item FOREIGN KEY (id_pedido_fk) REFERENCES Pedidos(id_pedido),
            CONSTRAINT fk_produto_item FOREIGN KEY (id_produto_fk) REFERENCES Produtos(id_produto)
        );
    ";
    $pdo->exec($sql_itens_pedido);
    echo "Tabela 'Itens_Pedido' verificada/criada.<br>";

    // --- CRIAÇÃO DA TABELA PROMOCOES ---
    $sql_promocoes = "
        CREATE TABLE IF NOT EXISTS Promocoes (
            id_promocao INTEGER PRIMARY KEY AUTOINCREMENT,
            codigo VARCHAR(50) UNIQUE,
            descricao TEXT,
            tipo_desconto VARCHAR(20) NOT NULL,
            valor_desconto REAL NOT NULL,
            data_inicio DATETIME NOT NULL,
            data_fim DATETIME NOT NULL,
            ativo INTEGER NOT NULL DEFAULT 1,
            uso_maximo INTEGER,
            min_valor_pedido REAL
        );
    ";
    $pdo->exec($sql_promocoes);
    echo "Tabela 'Promocoes' verificada/criada.<br>";

    // --- FECHAMENTO DA CONEXÃO ---
    $pdo = null; // É uma boa prática fechar a conexão definindo o objeto PDO como null
    echo "Configuração do banco de dados concluída e conexão fechada.";

} catch (PDOException $e) {
    // --- TRATAMENTO DE ERROS NA CONEXÃO OU QUERY SQL ---
    // Se ocorrer um erro durante a conexão ou a execução de qualquer query SQL,
    // a exceção será capturada aqui e a mensagem de erro será exibida.
    echo "<p style='color: red;'>Erro durante a configuração do banco de dados: " . $e->getMessage() . "</p>";
}

?>