<?php
include('config/conexao.php');
session_start();
$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;

// Cálculo do total dos produtos
foreach ($carrinho as $item) {
    $subtotal = $item['preco'] * $item['quantidade'];
    $total += $subtotal;
}

// Cálculo do frete (inicialmente 0)
$frete = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bairro'])) {
    $bairro_id = intval($_POST['bairro']);
    $result = $mysqli->query("SELECT frete FROM bairro WHERE id = $bairro_id");
    if ($row = $result->fetch_assoc()) {
        $frete = floatval($row['frete']);
        $total += $frete;
    }
}
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

        <h2>Total dos Produtos: R$ <?= number_format($total - $frete, 2, ',', '.') ?></h2>

    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>
</section>

<form action="finalizar_pedido.php" method="POST" class="form-finalizar">
    <h2>Dados para Entrega</h2>
    <input type="text" name="nome" placeholder="Seu nome e Sobrenome" required>
    <input type="text" name="telefone" placeholder="Telefone" required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
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
    <input type="text" name="numero" placeholder="Número" required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
    <input type="text" name="complemento" placeholder="Complemento">

    <input type="hidden" name="total" value="<?= number_format($total, 2, '.', '') ?>">

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

    <button type="button" onclick="abrirResumo()">Finalizar Pedido</button>
</form>

<script>
function abrirResumo() {
    const bairroId = document.getElementById('bairro').value;
    const valorProdutos = <?= number_format($total, 2, '.', '') ?>;

    if (!bairroId) {
        alert('Selecione um bairro para calcular o frete.');
        return;
    }

    fetch('buscar_frete.php?bairro_id=' + bairroId)
        .then(response => response.text())
        .then(frete => {
            const valorFrete = parseFloat(frete);
            const totalFinal = valorProdutos + valorFrete;

            document.getElementById('resumoProdutos').textContent = valorProdutos.toFixed(2).replace('.', ',');
            document.getElementById('resumoFrete').textContent = valorFrete.toFixed(2).replace('.', ',');
            document.getElementById('resumoTotal').textContent = totalFinal.toFixed(2).replace('.', ',');

            // Atualiza o input hidden com o total
            document.querySelector('input[name="total"]').value = totalFinal.toFixed(2);

            // Abre o pop-up
            document.getElementById('popupResumo').style.display = 'flex';
        })
        .catch(() => {
            alert('Erro ao buscar frete.');
        });
}

function fecharResumo() {
    document.getElementById('popupResumo').style.display = 'none';
}
</script>


<!-- Modal de Confirmação -->
<div id="popupResumo" style="display: none;" class="popup-overlay">
    <div class="popup-content">
        <h2>Resumo do Pedido</h2>
        <p><strong>Produtos:</strong> R$ <span id="resumoProdutos"></span></p>
        <p><strong>Frete:</strong> R$ <span id="resumoFrete"></span></p>
        <p><strong>Total:</strong> R$ <span id="resumoTotal"></span></p>
        <button onclick="document.querySelector('.form-finalizar').submit()">Confirmar Pedido</button>
        <button onclick="fecharResumo()">Cancelar</button>
    </div>
</div>

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

            document.getElementById('rua').value = data.logradouro;

            const cidadeSelect = document.getElementById('cidade');
            const cidadeViaCEP = data.localidade.trim().toLowerCase();
            for (let option of cidadeSelect.options) {
                if (option.dataset.nome?.trim().toLowerCase() === cidadeViaCEP) {
                    option.selected = true;
                    break;
                }
            }

            const bairroSelect = document.getElementById('bairro');
            const bairroViaCEP = data.bairro.trim().toLowerCase();
            for (let option of bairroSelect.options) {
                if (option.dataset.nome?.trim().toLowerCase() === bairroViaCEP) {
                    option.selected = true;
                    break;
                }
            }
        })
        .catch(() => alert('Erro ao buscar o CEP.'));
});

function abrirConfirmacao() {
    const form = document.querySelector('.form-finalizar');
    const nome = form.nome.value;
    const telefone = form.telefone.value;
    const rua = form.rua.value;
    const numero = form.numero.value;
    const bairro = form.bairro.options[form.bairro.selectedIndex].text;
    const cidade = form.cidade.options[form.cidade.selectedIndex].text;
    const pagamento = form.forma_pagamento.options[form.forma_pagamento.selectedIndex].text;
    const total = <?= json_encode(number_format($total, 2, ',', '.')) ?>;

    const resumo = `
        Nome: ${nome}<br>
        Telefone: ${telefone}<br>
        Endereço: ${rua}, ${numero}, ${bairro} - ${cidade}<br>
        Forma de pagamento: ${pagamento}<br>
        Total com frete: R$ ${total}
    `;

    document.getElementById('resumoPedido').innerHTML = resumo;
    document.getElementById('modalConfirmacao').style.display = 'flex';
}

document.getElementById('confirmarEnvio').onclick = function () {
    document.querySelector('.form-finalizar').submit();
};

document.querySelector('.modal .close').onclick = function () {
    document.getElementById('modalConfirmacao').style.display = 'none';
};
</script>

<style>
.modal {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center;
    z-index: 9999;
}
.modal-content {
    background: white; padding: 2rem; border-radius: 10px;
    max-width: 500px; width: 90%; position: relative;
}
.modal-content h2 { margin-top: 0; }
.modal-content .close {
    position: absolute; top: 10px; right: 20px; font-size: 28px;
    cursor: pointer;
}
</style>

</body>
<br><br>
</html>
