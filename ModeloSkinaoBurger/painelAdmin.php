<?php 

include('config/conexao.php');
include('config/protect.php');

$sql_tipos = "SELECT id, nome FROM esboco_hamburgueria.tipo_produto";
$result_tipos = $mysqli->query($sql_tipos);
$tipos_produto = array();
if ($result_tipos->num_rows > 0) {
    while($row = $result_tipos->fetch_assoc()) {
        $tipos_produto[] = $row;
    }
}  

if(isset($_POST['nome']) && isset($_POST['preco']) && isset($_POST['descricao']) && isset($_POST['tproduto'])){
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $preco = $mysqli->real_escape_string($_POST['preco']);
    $descricao = $mysqli->real_escape_string($_POST['descricao']);
    $tproduto = $mysqli->real_escape_string($_POST['tproduto']);


            $sql_insert = "INSERT INTO esboco_hamburgueria.produtos (nome, preco, descricao, imagem, tipo_produto_id, disponibilidade) VALUES ('$nome', '$preco', '$descricao', '', '$tproduto', '1')";
            if ($mysqli->query($sql_insert)) {
                echo '<script>alert("Cadastro do Produto realizado com sucesso!");</script>';

            } else {
                echo "Erro ao cadastrar Produto: " . $mysqli->error;
            }
}

if(isset($_POST['tipo'])){
    $tipo = $mysqli->real_escape_string($_POST['tipo']);

            $sql_insert = "INSERT INTO esboco_hamburgueria.tipo_produto (nome) VALUES ('$tipo')";
            if ($mysqli->query($sql_insert)) {
                echo '<script>alert("Cadastro do Tipo de Produto realizado com sucesso!");</script>';

            } else {
                echo "Erro ao cadastrar Tipo de Produto: " . $mysqli->error;
            }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/headerFooterAdmin.css">
    <link rel="stylesheet" href="assets/painelAdmin.css">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <title>Skinão Burger</title>
</head>
<body>
    <?php include('includes/headerAdmin.php'); ?>

    <div class="container box">
        <div class="container-t">
            <h2>CADASTRAR TIPO DE PRODUTO</h2>
            <form action="" method="POST">

                <label for="tipo">Nome: </label>
                <input type="text" name="tipo" id="tipo">

                <button type="submit">CADASTRAR</button>
            </form>
        </div>

        <div class="container">
            <h2>CADASTRAR PRODUTO</h2>
            <form action="" method="POST">
                <label for="nome">Nome: </label>
                <input type="text" name="nome" id="nome" required>

                <label for="preco">Preço: </label>
                <input type="number" step="0.01" name="preco" id="preco" required>

                <label for="descricao">Descrição: </label>
                <textarea name="descricao" id="descricao"></textarea>

                <label for="tproduto">Tipo do Produto: </label>
                <select name="tproduto" id="tproduto" required>
                <option value="">Selecione um tipo</option>
                <?php foreach($tipos_produto as $tipo): ?>
                    <option value="<?php echo $tipo['id']; ?>"><?php echo htmlspecialchars($tipo['nome']); ?>
                </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">CADASTRAR PRODUTO</button>
            </form>
        </div>
    </div>
    <br><br><br>
    <?php include('includes/footerAdmin.php'); ?>
</body>
</html>