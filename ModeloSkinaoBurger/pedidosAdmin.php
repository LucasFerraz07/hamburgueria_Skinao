<?php 
include('config/conexao.php');
include('config/protect.php');

// Atualiza status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id'], $_POST['status'])) {
    $pedido_id = intval($_POST['pedido_id']);
    $status = $_POST['status'];

    $status_validos = ['nao_iniciado', 'em_preparo', 'finalizado', 'entregue'];
    if (in_array($status, $status_validos)) {
        $stmt = $mysqli->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $pedido_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Busca pedidos
$sql = "
   SELECT p.id AS pedido_id, p.nome, p.telefone, p.valor_total, p.data_pedido,
       p.status, p.observacao_pagamento, p.observacao_produto,
       f.nome AS forma_pagamento,
       e.rua, e.numero, b.nome AS bairro, c.nome AS cidade
   FROM pedidos p
   JOIN forma_pagamento f ON p.forma_pagamento_id = f.id
   JOIN endereco e ON p.endereco_id = e.id
   JOIN bairro b ON e.bairro_id = b.id
   JOIN cidade c ON b.cidade_id = c.id
   ORDER BY p.data_pedido ASC
";
$result = $mysqli->query($sql);

// Organiza por status
$pedidos_nao_iniciado = [];
$pedidos_em_preparo = [];
$pedidos_finalizado = [];

while ($pedido = $result->fetch_assoc()) {
    if ($pedido['status'] === 'entregue') continue;

    switch ($pedido['status']) {
        case 'nao_iniciado':
            $pedidos_nao_iniciado[] = $pedido;
            break;
        case 'em_preparo':
            $pedidos_em_preparo[] = $pedido;
            break;
        case 'finalizado':
            $pedidos_finalizado[] = $pedido;
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinão Burger - Pedidos</title>
    <link rel="stylesheet" href="assets/headerFooterAdmin.css">
    <link rel="stylesheet" href="assets/pedidosAdmin.css">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
</head>
<body>
<?php include('includes/headerAdmin.php') ?>

<main class="container-pedidos">
    <h2>Pedidos Realizados</h2>

    <div class="colunas-container">
        <!-- Coluna 1: Não iniciado -->
        <div class="coluna">
            <h3>📦 Não iniciado</h3>
            <?php foreach ($pedidos_nao_iniciado as $pedido): ?>
                <?php include 'includes/cardPedido.php'; ?>
            <?php endforeach; ?>
        </div>

        <!-- Coluna 3: Em preparo -->
        <div class="coluna">
            <h3>🍳 Em preparo</h3>
            <?php foreach ($pedidos_em_preparo as $pedido): ?>
                <?php include 'includes/cardPedido.php'; ?>
            <?php endforeach; ?>
        </div>

        <!-- Coluna 3: Finalizado -->
        <div class="coluna">
            <h3>✅ Finalizado</h3>
            <?php foreach ($pedidos_finalizado as $pedido): ?>
                <?php include 'includes/cardPedido.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <br><br><br>
</main>
<?php include('includes/footerAdmin.php') ?>
</body>
</html>
