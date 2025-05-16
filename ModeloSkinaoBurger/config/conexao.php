<?php

$host = "localhost";
$usuario = "root";
$senha = "&tec77@info!";
//$senha = "root";
//$senha = "";
$database = "esboco_hamburgueria";


$mysqli = new mysqli($host, $usuario, $senha, $database);

if ($mysqli->connect_error) {
    die("ERRO NA CONEXÃO: " . $mysqli->connect_error);
}

?>