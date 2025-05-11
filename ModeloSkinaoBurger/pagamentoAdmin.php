<?php 
include('config/conexao.php');
include('config/protect.php');

// Cadastrar novo método
if (isset($_POST['pay'])) {
    $pay = $mysqli->real_escape_string($_POST['pay']);
    $sql_insert = "INSERT INTO forma_pagamento (nome) VALUES ('$pay')";
    if ($mysqli->query($sql_insert)) {
        echo '<script>alert("Cadastro realizado com sucesso!");</script>';
    } else {
        echo "Erro ao cadastrar: " . $mysqli->error;
    }
}

// Excluir método
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $mysqli->query("DELETE FROM forma_pagamento WHERE id = $delete_id");
}

// Buscar métodos
$pagamentos = $mysqli->query("SELECT id, nome FROM forma_pagamento ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/pagamentoAdmin.css">
    <link rel="stylesheet" href="assets/headerFooterAdmin.css">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <title>Skinão Burger</title>
</head>
<body>
    <?php include('includes/headerAdmin.php') ?>

    <div class="container">
        <form method="post">
            <label for="pay"><h2>Novo método de pagamento:</h2></label>
            <input type="text" name="pay" id="pay" required>
            <button type="submit">CADASTRAR</button>
        </form>

        <hr><br>

        <h2>Métodos Cadastrados</h2>
        <table class="tabela-pagamentos">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($pagamentos && $pagamentos->num_rows > 0): ?>
                    <?php while($row = $pagamentos->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nome']) ?></td>
                            <td>
                                <form method="post" onsubmit="return confirm('Tem certeza que deseja excluir este método?');">
                                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn-excluir">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3">Nenhum método cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<br><br><br>
    <?php include('includes/footerAdmin.php') ?>
</body>
</html>
