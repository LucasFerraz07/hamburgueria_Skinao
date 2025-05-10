<?php 

include('config/conexao.php');
include('config/protect.php');

// Inserção de nova cidade
if (isset($_POST['city'])) {
    $city = $mysqli->real_escape_string($_POST['city']);
    $sql_insert = "INSERT INTO esboco_hamburgueria.cidade (nome) VALUES ('$city')";
    if ($mysqli->query($sql_insert)) {
        echo '<script>alert("Cadastro da Cidade realizado com sucesso!");</script>';
    } else {
        echo "Erro ao cadastrar cidade: " . $mysqli->error;
    }
}

// Exclusão de cidade
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $mysqli->query("DELETE FROM esboco_hamburgueria.cidade WHERE id = $delete_id");
}

// Consulta cidades cadastradas
$sql_cidades = "SELECT id, nome FROM esboco_hamburgueria.cidade ORDER BY nome ASC";
$result_cidades = $mysqli->query($sql_cidades);

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/enderecoAdmin.css">
    <link rel="stylesheet" href="assets/headerFooterAdmin.css">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <title>Skinão Burger</title>
</head>
<body>
    <?php include('includes/headerAdmin.php') ?>

    <div class="container">
        <form method="post">
            <label for="city"><h2>Nova cidade para entrega:</h2></label>
            <input type="text" name="city" id="city" required>
            <button type="submit">CADASTRAR NOVA CIDADE</button>
        </form>
    </div>

    <div class="container">
    <h2>Cidades Cadastradas:</h2>
    <?php if ($result_cidades && $result_cidades->num_rows > 0): ?>
        <ul class="lista-cidades">
            <?php while ($cidade = $result_cidades->fetch_assoc()): ?>
                <li>
                    <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($cidade['nome']) ?>
                    <form method="post" class="form-excluir">
                        <input type="hidden" name="delete_id" value="<?= $cidade['id'] ?>">
                        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esta cidade?')">
                            Excluir
                        </button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Nenhuma cidade cadastrada ainda.</p>
    <?php endif; ?>
    </div>


    <?php include('includes/footerAdmin.php') ?>
</body>
</html>
