<?php

include('config/conexao.php');
session_start();
$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/carrinho.css">
    <link rel="stylesheet" href="assets/headerFooter.css">
    <title>Skinão Burger</title>
</head>
<body>
<?php include('includes/header.php'); ?>

<section class="carrinho-container">
    <h1>Seu Carrinho</h1>

    <?php if (count($carrinho) > 0): ?>
        <table class="tabela-carrinho">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrinho as $index => $item): 
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nome']) ?></td>
                        <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                        <td><?= $item['quantidade'] ?></td>
                        <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                        <td>
                            <form method="POST" action="remover_carrinho.php">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <button type="submit">Remover</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Total Geral: R$ <?= number_format($total, 2, ',', '.') ?></h2>

    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>
</section>

<form action="finalizar_pedido.php" method="POST" class="form-finalizar">
    <h2>Dados para Entrega</h2>
    <input type="text" name="nome" placeholder="Seu nome e Sobrenome" required>
    <input type="text" name="telefone" placeholder="Telefone" required required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
    <input type="text" name="rua" placeholder="Rua" required>
    <input type="text" name="numero" placeholder="Número" required required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
    <input type="text" name="bairro" placeholder="Bairro" required>
    <input type="text" name="complemento" placeholder="Complemento">

     <label for="cidade">Cidade: </label>
    <select name="cidade" required>
        <?php
        $cities = $mysqli->query("SELECT id, nome FROM esboco_hamburgueria.cidade");
        while ($c = $cities->fetch_assoc()):
        ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
        <?php endwhile; ?>
    </select>

    <input type="text" name="cep" placeholder="CEP" required required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
    <input type="hidden" name="total" value="<?= number_format($total, 2, ',', '.') ?>">

    <label for="forma_pagamento">Forma de Pagamento:</label>
    <select name="forma_pagamento" required>
        <?php
        $formas = $mysqli->query("SELECT id, nome FROM forma_pagamento");
        while ($f = $formas->fetch_assoc()):
        ?>
            <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nome']) ?></option>
        <?php endwhile; ?>
    </select>

    <input type="text" name="observacao" placeholder="Observação Pagamento">
    <input type="text" name="observacao_pedido" placeholder="Observação do Pedido">

    <button type="submit">Finalizar Pedido</button>
</form>

<br><br><br><br>
<?php include('includes/footer.php'); ?>
<script src="assets/carrinho.js"></script>
</body>
</html>
