<?php 

    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['id']) || $_SESSION['permissao'] != 1){
        die("Você não pode acessar esta página! Faça o login antes. <p><a href=\"index.php\">Entrar</a></p>");
    }

?>