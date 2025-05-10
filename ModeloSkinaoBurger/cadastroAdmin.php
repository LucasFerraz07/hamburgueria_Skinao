<?php 

    include('config/conexao.php');
    include('config/protect.php');

    if(isset($_POST['email']) && isset($_POST['nome']) && isset($_POST['senha']) && isset($_POST['csenha'])){
        $email = $mysqli->real_escape_string($_POST['email']);
        $nome = $mysqli->real_escape_string($_POST['nome']);
        $senha = $_POST['senha'];
        $csenha = $_POST['csenha'];

        if($senha == $csenha){
            $sql_verifica = "SELECT * FROM esboco_hamburgueria.usuarios WHERE email = '$email'";
            $query_verifica = $mysqli->query($sql_verifica) or die("Falha na Execução do código SQL: " . $mysqli->error);

            if ($query_verifica->num_rows > 0) {
                echo "Erro: Usuário já cadastrado!";
            } else {

                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
                $sql_insert = "INSERT INTO esboco_hamburgueria.usuarios (nome, senha, email, permissoes_id) VALUES ('$nome', '$senhaHash', '$email', '1')";
                if ($mysqli->query($sql_insert)) {
                    echo '<script>alert("Cadastro do Usuário ADMIN realizado com sucesso!");</script>';

                } else {
                    echo "Erro ao cadastrar: " . $mysqli->error;
                }
            }
        }else{
            echo "As senhas não coincidem";
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
    <link rel="stylesheet" href="assets/cadastro.css">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <title>Skinão Burger</title>
</head>
<body>
    <?php include('includes/headerAdmin.php') ?>
    <div class="container">
        <h2>CADASTRAR USUÁRIO ADMINISTRADOR</h2>
        <form action="" method="POST">
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" required>

            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome">

            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" minlength="8" maxlength="25" required>

            <label for="csenha">Confirmar Senha: </label>
            <input type="password" name="csenha" id="csenha" minlength="8" maxlength="25" required>

            <button type="submit">CADASTRAR</button>
        </form>
    </div>
<br><br><br>
    <?php include('includes/footerAdmin.php') ?>
  
</body>
<script src="assets/cadastroAdmin.js"></script>
</html>