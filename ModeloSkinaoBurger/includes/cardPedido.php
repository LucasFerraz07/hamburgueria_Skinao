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

    <form method="post" style="margin-top: 10px;">
        <input type="hidden" name="pedido_id" value="<?= $pedido['pedido_id'] ?>">
        <label><input type="radio" name="status" value="nao_iniciado" <?= $pedido['status'] === 'nao_iniciado' ? 'checked' : '' ?>> Não iniciado</label>
        <label><input type="radio" name="status" value="em_preparo" <?= $pedido['status'] === 'em_preparo' ? 'checked' : '' ?>> Em preparo</label>
        <label><input type="radio" name="status" value="finalizado" <?= $pedido['status'] === 'finalizado' ? 'checked' : '' ?>> Finalizado</label>
        <label><input type="radio" name="status" value="entregue" <?= $pedido['status'] === 'entregue' ? 'checked' : '' ?>> Entregue</label>
        <button type="submit" style="margin-left: 10px;">Atualizar Status</button>
    </form>
</div>
