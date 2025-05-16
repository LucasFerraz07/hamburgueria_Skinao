<?php 

include('config/conexao.php');

session_start();

$quantidade_total = 0;

if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $quantidade_total += $item['quantidade'];
    }
}


$sql = "
    SELECT 
        tp.id AS tipo_id, 
        tp.nome AS tipo_nome,
        p.id AS produto_id, 
        p.nome AS produto_nome, 
        p.descricao, 
        p.preco,
        p.imagem
    FROM esboco_hamburgueria.tipo_produto tp
    LEFT JOIN esboco_hamburgueria.produtos p 
        ON p.tipo_produto_id = tp.id 
        AND p.disponibilidade = 1
    ORDER BY tp.nome, p.nome
";

$result = $mysqli->query($sql);

$produtos_por_tipo = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tipo_id = $row['tipo_id'];
        $tipo_nome = $row['tipo_nome'];

        if (!isset($produtos_por_tipo[$tipo_id])) {
            $produtos_por_tipo[$tipo_id] = [
                'nome' => $tipo_nome,
                'produtos' => []
            ];
        }

        if ($row['produto_id']) {
            $produtos_por_tipo[$tipo_id]['produtos'][] = [
                'nome' => $row['produto_nome'],
                'descricao' => $row['descricao'],
                'preco' => $row['preco'],
                'imagem' => $row['imagem']
            ];
        }
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
    <link rel="stylesheet" href="assets/catalogoCliente.css">
    <link rel="stylesheet" href="assets/headerFooter.css">
    <title>Skinão Burger</title>
</head>
<body>
    <main>
    <?php include('includes/header.php'); ?>

    
    <section class="catalogo">
        
    <div class="topo">

    

</div>
            <br>
        <?php foreach ($produtos_por_tipo as $tipo): ?>
            <div class="tipo-produto">
                <div class="tipo-header" onclick="toggleProdutos(this)">
                    <?= htmlspecialchars($tipo['nome']) ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="produtos">
                    <?php if (count($tipo['produtos']) > 0): ?>
                        <?php foreach ($tipo['produtos'] as $produto): ?>
                            <div class="produto">
                        <div class="produto-info">
                            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                            <p><?= htmlspecialchars($produto['descricao']) ?></p>
                            <p><strong>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></strong></p>

                            <form action="adicionar_carrinho.php" method="POST">
                                <input type="hidden" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>">
                                <input type="hidden" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>">
                                <div class="quantidade-wrapper">
                                <div class="grupo-quantidade">
                                    <button type="button" class="botao-menor">−</button>
                                    <input type="number" name="quantidade" value="1" min="1" required>
                                    <button type="button" class="botao-maior">+</button>
                                </div>
                                    <button class="botao-adicionar" type="submit">Adicionar</button>
                                </div>
                            </form>
                        </div>
                        <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="Imagem de <?= htmlspecialchars($produto['nome']) ?>" class="produto-imagem">
                    </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum produto disponível neste tipo.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

 <br><br><br>

 <div class="botao-carrinho-fixo">
    <a href="carrinho.php" class="carrinho-fixo">
        <i class="fas fa-shopping-cart"></i>
        Carrinho
        <?php if ($quantidade_total > 0): ?>
            <span class="contador-carrinho-fixo"><?= $quantidade_total ?></span>
        <?php endif; ?>
    </a>
</div>
</main>
<br><br><br>
    <?php include('includes/footer.php'); ?>

    <script>
    // Alterna a visibilidade dos produtos por tipo
    function toggleProdutos(element) {
        const produtosDiv = element.nextElementSibling;
        produtosDiv.style.display = (produtosDiv.style.display === "block") ? "none" : "block";

        const icon = element.querySelector('i');
        icon.classList.toggle('fa-chevron-down');
        icon.classList.toggle('fa-chevron-up');
    }

    // Lógica para botões de quantidade (+ e -)
    document.addEventListener("DOMContentLoaded", function () {
        const wrappers = document.querySelectorAll('.quantidade-wrapper');

        wrappers.forEach(wrapper => {
            const input = wrapper.querySelector('input[name="quantidade"]');
            const botaoMais = wrapper.querySelector('.botao-maior');
            const botaoMenor = wrapper.querySelector('.botao-menor');

            botaoMais.addEventListener('click', () => {
                input.value = parseInt(input.value) + 1;
            });

            botaoMenor.addEventListener('click', () => {
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });
    });
</script>

</body>
</html>