<?php

try {
    $db = new PDO('sqlite:' .__DIR__. '/../db/banco.sqlite'); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexao ao banco de dados realizada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit;
}

?>