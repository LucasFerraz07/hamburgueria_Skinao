<?php
include('config/conexao.php');

if (isset($_GET['finalizar_id'])) {
    $pedido_id = $_GET['finalizar_id'];
    $sql = "UPDATE pedidos SET status = 'finalizado' WHERE id = $pedido_id";
    $mysqli->query($sql);
    header("Location: carrinho.php"); // Redireciona para a página
}

// Função para apagar
if (isset($_GET['apagar_id'])) {
    $pedido_id = $_GET['apagar_id'];
    $sql = "DELETE FROM pedidos WHERE id = $pedido_id";
    $mysqli->query($sql);
    header("Location: carrinho.php"); // Redireciona
}

// Consulta
$sql = "SELECT id, produto_nome, quantidade, preco, status FROM pedidos ORDER BY id DESC";
$result = $mysqli->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/carrin.css">
    <link rel="stylesheet" href="assets/headerFooter.css">
    <link rel="stylesheet" href="assets/carrin.css">
    <title>Pedidos - Skinão Burger</title>
</head>
<?php include('includes/header.php'); ?>
<body>
    <h1>Pedidos do Cliente</h1>

    <table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Preço</th>
        <th>Total</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>
</thead>
<tbody>
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['produto_nome']) ?></td>
        <td><?= $row['quantidade'] ?></td>
        <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
        <td>R$ <?= number_format($row['preco'] * $row['quantidade'], 2, ',', '.') ?></td>
        <td><?= ucfirst($row['status']) ?></td>
        <td>
            <?php if ($row['status'] == 'pendente'): ?>
                <a href="?finalizar_id=<?= $row['id'] ?>" class="btn-finalizar">Finalizar</a>
            <?php endif; ?>
            <a href="?apagar_id=<?= $row['id'] ?>" class="btn-apagar">Apagar</a>
        </td>
    </tr>
<?php endwhile; ?>
</tbody>

    </table>

    <br><br><br>

    <?php include('includes/footer.php'); ?>
</body>
</html>
