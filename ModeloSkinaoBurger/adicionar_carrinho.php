<?php
session_start();
//unset($_SESSION['carrinho']);

date_default_timezone_set('America/Sao_Paulo');

$horaAtual = date('H:i');
$horaAbertura = '19:30';
$horaFechamento = '23:30';

if ($horaAtual < $horaAbertura || $horaAtual >= $horaFechamento) {
    die("Não é possível adicionar produtos fora do horário de funcionamento (19:30 - 23:30).");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = floatval($_POST['preco'] ?? 0);
    $quantidade = intval($_POST['quantidade'] ?? 1);

    if ($nome && $preco > 0 && $quantidade > 0) {
        $item = [
            'nome' => $nome,
            'preco' => $preco,
            'quantidade' => $quantidade
        ];

        // Inicializa corretamente como array se não estiver
        if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        $encontrado = false;
        foreach ($_SESSION['carrinho'] as &$produto) {
            if ($produto['nome'] === $nome) {
                $produto['quantidade'] += $quantidade;
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            $_SESSION['carrinho'][] = $item;
        }
    }
}

header('Location: index.php');
exit;

