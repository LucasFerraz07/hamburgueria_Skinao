<?php 

include('config/conexao.php');
$produtos = $mysqli->query("SELECT * FROM esboco_hamburgueria.produtos");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/headerFooterAdmin.css">
    <link rel="stylesheet" href="assets/cardapioAdmin.css">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <title>Skinão Burger</title>
</head>
<body>
    <?php include('includes/headerAdmin.php') ?>

    <h1>Produtos</h1>
    <div class="produtos">
        <?php while ($p = $produtos->fetch_assoc()): ?>
            <div class="produto">
                <h3><?= $p['nome'] ?></h3>
                <p><?= $p['descricao'] ?></p>
                <p>R$ <?= $p['preco'] ?></p>
            </div>
        <?php endwhile; ?>
    </div>
    <br><br><br>
    <?php include('includes/footerAdmin.php') ?>
</body>
</html>