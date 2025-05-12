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
    <input type="text" id="cep" name="cep" placeholder="CEP" required oninput="this.value=this.value.replace(/[^0-9]/g,'')">

    <select name="cidade" id="cidade" required>
        <?php
        $cities = $mysqli->query("SELECT id, nome FROM esboco_hamburgueria.cidade");
        while ($c = $cities->fetch_assoc()):
        ?>
            <option value="<?= $c['id'] ?>" data-nome="<?= htmlspecialchars($c['nome']) ?>">
                <?= htmlspecialchars($c['nome']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <select name="bairro" id="bairro" required>
        <option value="" disabled selected>Selecione o bairro</option>
        <?php
        $bairros = $mysqli->query("SELECT id, nome FROM bairro ORDER BY nome");
        while ($b = $bairros->fetch_assoc()):
        ?>
            <option value="<?= $b['id'] ?>" data-nome="<?= htmlspecialchars($b['nome']) ?>">
                <?= htmlspecialchars($b['nome']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="text" id="rua" name="rua" placeholder="Rua" required>

    <input type="text" name="numero" placeholder="Número" required required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
    <input type="text" name="complemento" placeholder="Complemento">
    
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
<script>
document.getElementById('cep').addEventListener('blur', function () {
    const cep = this.value.replace(/\D/g, '');

    if (cep.length !== 8) return;

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                alert('CEP não encontrado!');
                return;
            }

            // Rua (campo de texto)
            document.getElementById('rua').value = data.logradouro;

            // --- CIDADE (select) ---
            const cidadeSelect = document.getElementById('cidade');
            const cidadeViaCEP = data.localidade.trim().toLowerCase();
            let cidadeEncontrada = false;

            for (let option of cidadeSelect.options) {
                const nomeOption = option.dataset.nome?.trim().toLowerCase();
                if (nomeOption === cidadeViaCEP) {
                    option.selected = true;
                    cidadeEncontrada = true;
                    break;
                }
            }

            if (!cidadeEncontrada) {
                alert('Cidade "' + data.localidade + '" não está cadastrada.');
            }

            // --- BAIRRO (select) ---
            const bairroSelect = document.getElementById('bairro');
            const bairroViaCEP = data.bairro.trim().toLowerCase();
            let bairroEncontrado = false;

            for (let option of bairroSelect.options) {
                const nomeOption = option.dataset.nome?.trim().toLowerCase();
                if (nomeOption === bairroViaCEP) {
                    option.selected = true;
                    bairroEncontrado = true;
                    break;
                }
            }

            if (!bairroEncontrado) {
                alert('Bairro "' + data.bairro + '" não está cadastrado.');
            }
        })
        .catch(() => {
            alert('Erro ao buscar o CEP.');
        });
});
</script>


</body>
</html>
