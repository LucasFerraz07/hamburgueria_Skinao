<?php 

include('config/conexao.php');

if (isset($_POST['email']) && isset($_POST['senha'])) {

    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = $_POST['senha']; 


    $sql_code = "SELECT * FROM esboco_hamburgueria.usuarios WHERE email = '$email'";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do SQL: " . $mysqli->error);

    if ($sql_query->num_rows == 1) {
        $usuario = $sql_query->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['permissao'] = $usuario['permissoes_id'];

            if($usuario['permissoes_id'] == 2){
                echo '<script>alert("Este usuário NÃO tem permissão para efetuar Login!");</script>';
            } else{
                header("Location: painelAdmin.php");
            }

            
        } else {
            echo "Usuário ou Senha incorretos.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/login.css">
    <link rel="stylesheet" href="assets/headerFooter.css">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <title>Skinão Burger</title>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <h2>Acesse sua Conta</h2>
        <form action="" method="POST">
            <label for="email">Email: </label>
            <input type="email" name="email" id="email" required>

            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" required>

            <button type="submit" name="login">ENTRAR</button>
        </form>
    </div>

    

    <?php include('includes/footer.php'); ?>
</body>
</html>