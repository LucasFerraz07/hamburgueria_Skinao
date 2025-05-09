<?php
session_start();
include('config/conexao.php');

if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) === 0) {
    die('Carrinho vazio.');
}

$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$rua = $_POST['rua'] ?? '';
$numero = $_POST['numero'] ?? '';
$bairro = $_POST['bairro'] ?? '';
$complemento = $_POST['complemento'] ?? '';
$cidade = $_POST['cidade'] ?? '';
$estado = $_POST['estado'] ?? '';
$cep = $_POST['cep'] ?? '';
$forma_pagamento = intval($_POST['forma_pagamento'] ?? 0);
$obs_pagamento = $_POST['observacao'] ?? '';
$total = str_replace(',', '.', $_POST['total'] ?? '0');

// Validação simples
if (!$nome || !$telefone || !$rua || !$numero || !$bairro || !$cidade || !$estado || !$cep || !$forma_pagamento) {
    die('Todos os campos são obrigatórios.');
}

// Salva endereço
$stmt = $mysqli->prepare("INSERT INTO endereco (bairro, rua, numero, complemento, cep, cidade) VALUES ('$bairro', '$rua', '$numero', '$complemento', '$cep', '$cidade')");
$stmt->execute();
$endereco_id = $stmt->insert_id;
$stmt->close();

// Cria pedido
$stmt = $mysqli->prepare("INSERT INTO pedidos (nome, telefone, valor_total, endereco_id, forma_pagamento_id) VALUES ('$nome', '$telefone', '$total', '$endereco_id', '$forma_pagamento')");
$stmt->execute();
$pedido_id = $stmt->insert_id;
$stmt->close();


// Associa produtos ao pedido
$stmt = $mysqli->prepare("SELECT id FROM produtos WHERE nome = ? LIMIT 1");
$insert_item = $mysqli->prepare("INSERT INTO pedidos_has_produtos (pedidos_id, produtos_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");

foreach ($_SESSION['carrinho'] as $item) {
    $nome_produto = $item['nome'];
    $quantidade = $item['quantidade'];
    $preco = $item['preco'];

    $stmt->bind_param("s", $nome_produto);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $produto_id = $row['id'] ?? 0;

    if ($produto_id) {
        $insert_item->bind_param("iiid", $pedido_id, $produto_id, $quantidade, $preco);
        $insert_item->execute();
    }
}
$stmt->close();
$insert_item->close();

// Limpa o carrinho
unset($_SESSION['carrinho']);

// Redireciona ou mostra mensagem
echo "<script>alert('Pedido realizado com sucesso!'); window.location.href='index.php';</script>";



