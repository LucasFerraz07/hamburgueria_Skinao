<?php
include('config/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $preco = floatval($_POST['preco']);
    $quantidade = intval($_POST['quantidade']);

    if ($quantidade > 0) {
        $stmt = $mysqli->prepare("INSERT INTO pedidos (produto_nome, quantidade, preco, status) VALUES (?, ?, ?, 'pendente')");
        $stmt->bind_param("sii", $nome, $quantidade, $preco);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: index.php");
exit;
