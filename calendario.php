<?php
include "banco/connect.php";

$sql = "SELECT id_produto, nome_produto, base, marca, tipo, validade, estado FROM produto,validade WHERE id_produto = id_produto_fk AND validade BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL 90 DAY) ORDER BY validade ASC";
$resul = $conn->query($sql);

$produtosBD = array();
if ($resul->num_rows > 0) {
    while ($row = $resul->fetch_assoc()) {
        $produtosBD[] = $row;
    }
}

VerificaUser();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vencimentos</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            background-color: white;
        }
    </style>
</head>
<body>

    <div class="container-modal" id="janela-modal">
        <div class="janela-modal">
            <p>Deseja Realmente sair?</p>
            <div class="container-btn">
                <button class="btn" id="fechar" onclick="fecharPopup()">Voltar</button>
                <form action="logout.php" method="get">
                    <input type="hidden" name="sair" value="sair">
                    <button type="submit" class="btn" id="logoff">Sair</button>
                </form>
            </div>
        </div>
    </div>

    <nav class="sidebar">
       
        <div class="btn-expandir">
            <i class='bx bx-menu' id="btn-exp"></i>
        </div>

        <ul>
            <li class="item-menu">
                <a href="home.php">
                    <span class="icon"><i class='bx bx-home-alt' ></i></span>
                    <span class="txt-link">Inicio</span>
                </a>
            </li>
            <li class="item-menu">
                <a href="cadastro.php">
                    <span class="icon"><i class='bx bx-log-in-circle'></i></span>
                    <span class="txt-link">Cadastro</span>
                </a>
            </li>
            <li class="item-menu">
                <a href="estoque.php">
                    <span class="icon"><i class='bx bx-cube-alt'></i></span>
                    <span class="txt-link">Estoque</span>
                </a>
            </li>
            <li class="item-menu">
                <a href="calendario.php">
                    <span class="icon"><i class='bx bx-calendar'></i></span>
                    <span class="txt-link">Vencimentos</span>
                </a>
            </li>
            <li class="item-menu">
                <a href="cadastro-de-usuario.php">
                    <span class="icon"><i class='bx bx-user-plus bx-flip-horizontal' ></i></span>
                    <span class="txt-link">Cadastro de Usuario</span>
                </a>
            </li>
        </ul>
    
    </nav>

    <!-- HEADER -->
    <header>
        <div class="container-header">
            <div class="container-user-box">
                <i class='bx bx-user-circle' id="btn-usuario" onclick="abrirPopup()"></i>
            </div>
        </div>
        <div class="container-logoff" id="janela-popup">
            <i class='bx bxs-up-arrow'></i>
            <div class="container-box-logoff">
                <a href="#" class="btn-sair" onclick="abrirModal()">Sair</a>
            </div>
        </div>
    </header>

    <div class="container-estoque">
        <div class="estoque-label">
            <p>Vencimentos:</p>
        </div>

        <table>
                <tr>
                    <th>Código</th>
                    <th style="width: 20%;">Produto</th>
                    <th>Marca</th>
                    <th>Tipo</th>
                    <th>Validade</th>
                    <th>Estado</th>
                </tr>
                <?php 
                foreach($produtosBD as $produto){
                    echo "<tr>";
                    echo "<td>" . $produto['id_produto'] . "</td>";
                    echo "<td>" . $produto['nome_produto'] . "</td>";
                    echo "<td>" . $produto['marca'] . "</td>";
                    echo "<td>" . $produto['tipo'] . "</td>";
                    echo "<td>" . $produto['validade'] . "</td>";
                    echo "<td>" . $produto['estado'] . "</td>";
                    echo "</tr>";
                }
                ?>
                
            </table>

    </div>

    <footer>
        <div class="container-footer">
            <a>Todos os direitos reservados &copy; Can Say | 2024 - &infin;</a>
        </div>
    </footer>

<script src="https://unpkg.com/scrollreveal"></script>

<script src="js/script.js"></script>

</body>
</html>