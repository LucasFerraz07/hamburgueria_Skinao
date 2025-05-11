<?php 
include('config/conexao.php');
include('config/protect.php');

$sql = "
    SELECT p.id AS pedido_id, p.nome, p.telefone, p.valor_total, p.data_pedido,
           p.status, p.observacao_pagamento, p.observacao_produto,
           f.nome AS forma_pagamento,
           e.rua, e.numero, e.bairro, c.nome AS cidade
    FROM pedidos p
    JOIN forma_pagamento f ON p.forma_pagamento_id = f.id
    JOIN endereco e ON p.endereco_id = e.id
    JOIN cidade c ON e.cidade_id = c.id
    ORDER BY p.data_pedido ASC
";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/headerFooterAdmin.css">
    <link rel="stylesheet" href="assets/pedidosAdmin.css">
    <link rel="stylesheet" href="assets/pedidosAdmin.css">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <title>Skinão Burger</title>
</head>
<body>
<?php include('includes/headerAdmin.php') ?>

<main class="container-pedidos">
    <h1>Pedidos Realizados</h1>

    <?php while ($pedido = $result->fetch_assoc()): ?>
        <div class="pedido-card">
            <h2>Pedido #<?= $pedido['pedido_id'] ?> - <?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></h2>
            <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido['nome']) ?> - <?= htmlspecialchars($pedido['telefone']) ?></p>
            <p><strong>Endereço:</strong> Rua <?= $pedido['rua'] ?>, <?= $pedido['numero'] ?>, <?= $pedido['bairro'] ?> - <?= $pedido['cidade'] ?></p>
            <p><strong>Pagamento:</strong> <?= $pedido['forma_pagamento'] ?></p>
            <p><strong>Observação Pagamento:</strong> <?= $pedido['observacao_pagamento'] ?: 'Nenhuma' ?></p>
            <p><strong>Observação Produto:</strong> <?= $pedido['observacao_produto'] ?: 'Nenhuma' ?></p>
            <p><strong>Status:</strong> <?= $pedido['status'] ?></p>

            <h3>Itens do Pedido:</h3>
            <ul>
                <?php
                    $id_pedido = $pedido['pedido_id'];
                    $sql_prod = "
                        SELECT ph.quantidade, ph.preco_unitario, pr.nome
                        FROM pedidos_has_produtos ph
                        JOIN produtos pr ON ph.produtos_id = pr.id
                        WHERE ph.pedidos_id = $id_pedido
                    ";

                    $produtos = $mysqli->query($sql_prod);
                    while ($item = $produtos->fetch_assoc()):
                ?>
                    <li><?= $item['quantidade'] ?>x <?= $item['nome'] ?> - R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></li>
                <?php endwhile; ?>
            </ul>

            <p><strong>Total:</strong> R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></p>
        </div>
    <?php endwhile; ?>
</main>
<br><br><br>
<?php include('includes/footerAdmin.php') ?>
</body>
</html>
