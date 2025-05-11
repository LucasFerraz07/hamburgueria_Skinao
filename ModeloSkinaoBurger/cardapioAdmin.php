<?php 

include('config/conexao.php');
include('config/protect.php');

if (isset($_GET['del'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM esboco_hamburgueria.produtos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Erro ao excluir o produto!";
    }
}
if (isset($_POST['edit'])) { // Editar produto
     $id = $_GET['id'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $imagem = $_POST ['imagem'];
        $tipo = $_POST['tipo_produto_id'];
        $disponibilidade = $_POST['disponibilidade'];


        $query = "UPDATE esboco_hamburgueria.produtos SET nome= ?, descricao = ?, preco = ?, imagem = ?, tipo_produto_id = ?, disponibilidade = ? WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ssdssii", $nome, $descricao, $preco, $imagem, $tipo, $disponibilidade, $id);
        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $msg = 'Erro ao atualizar o produto!';
        }        
        $stmt->close();
}

if (isset($_GET['edit']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $mysqli->prepare("SELECT * FROM esboco_hamburgueria.produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produtoEditar = $result->fetch_assoc();
}

$produtos = $mysqli->query("SELECT * FROM esboco_hamburgueria.produtos");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/cardapioAdmin.css">
    <link rel="stylesheet" href="assets/headerFooterAdmin.css">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <title>Skinão Burger</title>
</head>
<body>
    <?php include('includes/headerAdmin.php') ?>

    <h1>Produtos</h1>
    <div class="produtos">
        <?php while ($p = $produtos->fetch_assoc()): ?>
            <div class="produto <?= $p['disponibilidade'] == 0 ? 'indisponivel' : '' ?>">
                <h3><?= $p['nome'] ?></h3>
                <p><?= $p['descricao'] ?></p>
                <p>R$ <?= $p['preco'] ?></p>
                <a href="?del=1&id=<?= $p['id'] ?>" class="btn-excluir">Excluir</a>
                <a href="?edit=1&id=<?= $p['id'] ?>" class="btn-editar">Editar</a>
            </div>
        <?php endwhile; ?>
    </div>

    <?php if (isset($produtoEditar)): ?>
    <div id="modal-editar" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form method="POST" class="form-editar">
                <input type="hidden" name="id" value="<?= $produtoEditar['id'] ?>">

                <label for="nome">Nome: </label>
                <input type="text" name="nome" value="<?= $produtoEditar['nome'] ?>">

                <label for="descricao">Descrição: </label>
                <input type="text" name="descricao" value="<?= $produtoEditar['descricao'] ?>">

                <label for="preco">Preço: </label>
                <input type="number" step="0.01" name="preco" value="<?= $produtoEditar['preco'] ?>">

                <label for="imagem">Imagem: </label>
                <input type="text" name="imagem" value="<?= $produtoEditar['imagem'] ?>">

                <input type="hidden" name="tipo_produto_id" value="<?= $produtoEditar['tipo_produto_id'] ?>">

                <label>Disponibilidade:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="disponibilidade" value="1" <?= $produtoEditar['disponibilidade'] == 1 ? 'checked' : '' ?>> Disponível
                    </label>
                    <label>
                        <input type="radio" name="disponibilidade" value="0" <?= $produtoEditar['disponibilidade'] == 0 ? 'checked' : '' ?>> Indisponível
                    </label>
                </div>

                <button type="submit" name="edit">Salvar Alterações</button>
            </form>
        </div>
    </div>
<?php endif; ?>

    <br><br><br><br>
    <?php include('includes/footerAdmin.php') ?>

    <script>
    // Quando o modal estiver aberto, permitir fechar ao clicar no X
    document.querySelectorAll('.close').forEach(btn => {
        btn.onclick = () => {
            document.getElementById('modal-editar').style.display = 'none';
            window.location.href = window.location.pathname; // remove os parâmetros da URL
        };
    });

    // Fechar modal ao clicar fora da área do conteúdo
    window.onclick = function(event) {
        const modal = document.getElementById('modal-editar');
        if (event.target === modal) {
            modal.style.display = "none";
            window.location.href = window.location.pathname;
        }
    };
    </script>
</body>
</html>
