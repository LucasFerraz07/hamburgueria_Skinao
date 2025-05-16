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
$bairro = intval($_POST['bairro'] ?? 0);
$complemento = $_POST['complemento'] ?? '';
$cidade = intval($_POST['cidade'] ?? 0);
$cep = $_POST['cep'] ?? '';
$forma_pagamento = intval($_POST['forma_pagamento'] ?? 0);
$obs_pagamento = $_POST['observacao'] ?? '';
$obs_pedido = $_POST['observacao_pedido'] ?? '';
$total = str_replace(',', '.', $_POST['total'] ?? '0');
$res_frete = $mysqli->query("SELECT frete FROM bairro WHERE id = $bairro");
if ($f = $res_frete->fetch_assoc()) {
    $frete = floatval($f['frete']);
    $total += $frete;
}

// Validação simples
if (!$nome || !$telefone || !$rua || !$numero || !$bairro || !$cidade || !$cep || !$forma_pagamento) {
    die('Alguns campos não preenchidos são obrigatórios.');
}

// Salva endereço
$stmt = $mysqli->prepare("INSERT INTO esboco_hamburgueria.endereco (rua, numero, complemento, cep, bairro_id) VALUES ('$rua', '$numero', '$complemento', '$cep', '$bairro')");
$stmt->execute();
$endereco_id = $stmt->insert_id;
$stmt->close();

// Cria pedido
$stmt = $mysqli->prepare("INSERT INTO esboco_hamburgueria.pedidos (nome, telefone, valor_total, endereco_id, forma_pagamento_id, observacao_pagamento, observacao_produto) VALUES ('$nome', '$telefone', '$total', '$endereco_id', '$forma_pagamento', '$obs_pagamento', '$obs_pedido')");
$stmt->execute();
$pedido_id = $stmt->insert_id;
$stmt->close();


// Associa produtos ao pedido
$stmt = $mysqli->prepare("SELECT id FROM esboco_hamburgueria.produtos WHERE nome = ? LIMIT 1");
$insert_item = $mysqli->prepare("INSERT INTO esboco_hamburgueria.pedidos_has_produtos (pedidos_id, produtos_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");

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



