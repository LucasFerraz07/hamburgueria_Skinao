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

// Inserção de novo bairro
if (isset($_POST['bairro_nome'], $_POST['bairro_frete'], $_POST['cidade_id'])) {
    $bairro_nome = $mysqli->real_escape_string($_POST['bairro_nome']);
    $bairro_frete = floatval($_POST['bairro_frete']);
    $cidade_id = intval($_POST['cidade_id']);

    $sql_bairro = "INSERT INTO esboco_hamburgueria.bairro (nome, frete, cidade_id) VALUES ('$bairro_nome', $bairro_frete, $cidade_id)";
    if ($mysqli->query($sql_bairro)) {
        echo '<script>alert("Bairro cadastrado com sucesso!");</script>';
    } else {
        echo "Erro ao cadastrar bairro: " . $mysqli->error;
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

// Exclusão de bairro
if (isset($_POST['delete_bairro_id'])) {
    $delete_bairro_id = intval($_POST['delete_bairro_id']);
    $mysqli->query("DELETE FROM esboco_hamburgueria.bairro WHERE id = $delete_bairro_id");
}


// Consulta bairros com nome da cidade
$sql_bairros = "
    SELECT b.id, b.nome AS bairro_nome, b.frete, c.nome AS cidade_nome
    FROM esboco_hamburgueria.bairro b
    JOIN esboco_hamburgueria.cidade c ON b.cidade_id = c.id
    ORDER BY c.nome, b.nome
";
$result_bairros = $mysqli->query($sql_bairros);

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
            <button type="submit">CADASTRAR CIDADE</button>
        </form>
    </div>

    <div class="container">
        <h2>Cadastro de Bairro:</h2>
        <form method="post">
            <label for="bairro_nome">Nome do bairro:</label>
            <input type="text" name="bairro_nome" id="bairro_nome" required>

            <label for="bairro_frete">Frete de entrega (R$):</label>
            <input type="number" step="0.01" name="bairro_frete" id="bairro_frete" required>

            <label for="cidade_id">Cidade:</label>
            <select name="cidade_id" id="cidade_id" required>
                <option value="" disabled selected>Selecione uma cidade</option>
                <?php 
                if ($result_cidades && $result_cidades->num_rows > 0): 
                    mysqli_data_seek($result_cidades, 0); // Reposiciona o ponteiro do resultado
                    while ($cidade = $result_cidades->fetch_assoc()): ?>
                        <option value="<?= $cidade['id'] ?>"><?= htmlspecialchars($cidade['nome']) ?></option>
                    <?php endwhile;
                else: ?>
                    <option disabled>Nenhuma cidade disponível</option>
                <?php endif; ?>
            </select>

            <button type="submit">CADASTRAR BAIRRO</button>
        </form>
    </div>

    <div class="container">
        <h2>Cidades Cadastradas:</h2>
        <?php if ($result_cidades && $result_cidades->num_rows > 0): ?>
            <ul class="lista-cidades">
                <?php 
                mysqli_data_seek($result_cidades, 0);
                while ($cidade = $result_cidades->fetch_assoc()): ?>
                    <li>
                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($cidade['nome']) ?>
                        <form method="post" class="form-excluir">
                            <input type="hidden" name="delete_id" value="<?= $cidade['id'] ?>">
                            <button type="submit" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir esta cidade?')">Excluir</button>
                        </form>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Nenhuma cidade cadastrada ainda.</p>
        <?php endif; ?>
    </div>

    <div class="container">
        <h2>Bairros Cadastrados:</h2>
        <?php if ($result_bairros && $result_bairros->num_rows > 0): ?>
            <ul class="lista-cidades">
                <?php while ($bairro = $result_bairros->fetch_assoc()): ?>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <strong><?= htmlspecialchars($bairro['bairro_nome']) ?></strong> - 
                        <?= htmlspecialchars($bairro['cidade_nome']) ?> 
                        (R$ <?= number_format($bairro['frete'], 2, ',', '.') ?>)

                        <form method="post" class="form-excluir" style="display:inline;">
                            <input type="hidden" name="delete_bairro_id" value="<?= $bairro['id'] ?>">
                            <button type="submit" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este bairro?')">
                                Excluir
                            </button>
                        </form>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Nenhum bairro cadastrado ainda.</p>
        <?php endif; ?>
    </div>



    <br><br><br>
    <?php include('includes/footerAdmin.php') ?>
</body>
</html>

