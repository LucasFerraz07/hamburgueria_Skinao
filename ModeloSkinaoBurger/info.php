<?php
include('config/conexao.php'); // certifique-se de que o caminho esteja correto

// Consulta SQL para buscar os bairros
$sql = "SELECT id, nome, frete FROM esboco_hamburgueria.bairro ORDER BY nome";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/information.css">
    <link rel="stylesheet" href="assets/headerFooter.css">
    <title>Skinão Burguer</title>
    <style>
        .btn-toggle {
            background-color: #1C1C1C;
            color: #fff;
            padding: 14px 24px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px auto;
        }

        .btn-toggle:hover {
            background-color: #333;
        }

        #icone-seta {
            transition: transform 0.3s ease;
        }

        .tabela-bairros {
            display: none;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<section class="informacoes-hamburgueria">
    <div class="container-info">
        <h2>Sobre: </h2>
        <p><strong>Horário de funcionamento:</strong> Segunda a Domingo, das 19:30 às 23:30</p>
        <p><strong>Telefone para contato:</strong> (12) 982184626</p>
        <p><strong>Endereço:</strong> Rua Maria Antunes Gonçalves, Vila Bionde - Cruzeiro-SP</p>
        <div class="loginAdm">
            <a href="loginAdmin.php"><p>Área Restrita</p> <i class="fa-solid fa-user"></i></a>
        </div>
    </div>
</section>

<!-- Botão para abrir/fechar a tabela -->
<div style="text-align: center;">
    <button id="toggleTabelaBtn" class="btn-toggle">
        Ver bairros atendidos e frete
        <i class="fa-solid fa-chevron-down" id="icone-seta"></i>
    </button>
</div>

<!-- Tabela oculta inicialmente -->
<section class="tabela-bairros" id="tabelaBairros">
    <h2>Bairros atendidos e frete</h2>
    <table>
        <thead>
            <tr>
                <th>Bairro</th>
                <th>Frete (R$)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                    echo "<td>" . number_format($row['frete'], 2, ',', '.') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Nenhum bairro cadastrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<br><br><br><br><br><br>
<?php include('includes/footer.php'); ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("toggleTabelaBtn");
    const tabela = document.getElementById("tabelaBairros");
    const icone = document.getElementById("icone-seta");

    btn.addEventListener("click", function () {
        const visivel = tabela.style.display === "block";

        tabela.style.display = visivel ? "none" : "block";
        icone.style.transform = visivel ? "rotate(0deg)" : "rotate(180deg)";
    });
});
</script>

</body>
</html>