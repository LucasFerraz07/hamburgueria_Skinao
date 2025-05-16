<?php
include('config/conexao.php');

if (!isset($_GET['bairro_id'])) {
    echo '0.00';
    exit;
}

$bairro_id = intval($_GET['bairro_id']);
$result = $mysqli->query("SELECT frete FROM bairro WHERE id = $bairro_id");

if ($row = $result->fetch_assoc()) {
    echo number_format($row['frete'], 2, '.', '');
} else {
    echo '0.00';
}
?>
