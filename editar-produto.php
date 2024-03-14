<?php

include "banco/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
        $idProduto = $_GET['id'];

        $sql = "SELECT * FROM produto, estoque WHERE id_produto = $idProduto AND id_produto_fk = $idProduto";
        $resul = $conn->query($sql);
        $produtoModifica = array();
        if ($resul->num_rows >0) {
            while ($row = $resul->fetch_assoc()) {
                $produtoModifica[] = $row;
            }
            foreach ($produtoModifica as $produto){
                $nomeMudar = $produto['nome_produto'];
                $marcaMudar = $produto['marca'];
                $baseMudar = $produto['base'];
                $tipoMudar = $produto['tipo'];
                $quantMinMudar = $produto['quant_min'];
                $quantAtuMudar = $produto['quant_atual'];
                $quantMaxMudar = $produto['quant_ideal'];
            }
        } else {
            header("Location: estoque.php");
            exit();
        }
    }

    $sql = "SELECT * FROM produto, validade WHERE id_produto = $idProduto AND id_produto_fk = $idProduto";
    $resul = $conn->query($sql);
    $produtoModifica = array();
    if ($resul->num_rows >0) {
        while ($row = $resul->fetch_assoc()) {
            $produtoModifica[] = $row;
        }
        foreach ($produtoModifica as $produto){
            $validadeMudar = $produto['validade'];
            $estadoMudar = $produto['marca'];
        }

    } else {
        header("Location: estoque.php");
        exit();
    }
}
        
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idProduto = $_POST['id'];
    $nomeProduto = isset($_POST["nome-prod"]) ? $_POST["nome-prod"] : "";
    $marcaProduto = isset($_POST["marca-prod"]) ? $_POST["marca-prod"] : "";
    $baseProduto = isset($_POST["base-prod"]) ? $_POST["base-prod"] : "";
    $tipoProduto = isset($_POST["tipo-prod"]) ? $_POST["tipo-prod"] : "";
    $validadeProduto = isset($_POST["validade-prod"]) ? $_POST["validade-prod"] : "";
    $estadoProduto = isset($_POST["estado-prod"]) ? $_POST["estado-prod"] : "";
    $quantMin = isset($_POST["quantidade-prod-min"]) ? $_POST["quantidade-prod-min"] : "";
    $quantAtu = isset($_POST["quantidade-prod-atu"]) ? $_POST["quantidade-prod-atu"] : "";
    $quantMax = isset($_POST["quantidade-prod-max"]) ? $_POST["quantidade-prod-max"] : "";
        
    $sql = "UPDATE produto SET nome_produto='$nomeProduto', marca='$marcaProduto', base='$baseProduto', tipo='$tipoProduto' WHERE id_produto=$idProduto";
    $resul = $conn->query($sql);
            
    $sql = "UPDATE estoque SET quant_min='$quantMin', quant_atual='$quantAtu', quant_ideal ='$quantMax' WHERE id_produto_fk=$idProduto";
    $resul = $conn->query($sql);

    $sql = "UPDATE validade SET validade='$validadeProduto', estado='$estadoProduto' WHERE id_produto_fk=$idProduto";
    $resul = $conn->query($sql);

    if($estadoProduto == "vazio"){
        $sql = $sql = "SELECT estado FROM validade WHERE id_produto_fk=$idProduto AND estado='Vazio'";
        $resul = $conn->query($sql);
        $produtoModifica = array();
        $cont = 0;
        if ($resul->num_rows >0) {
            while ($row = $resul->fetch_assoc()) {
                $produtoModifica[] = $row;
                $cont = $cont + 1;
            }
            foreach ($produtoModifica as $produto){
                $sql = "UPDATE estoque SET usos='$cont' WHERE id_produto_fk=$idProduto";
                $resul = $conn->query($sql);
            }
    }
    }

    if($resul){
        $msg = "Alteração realizada com sucesso!";
        $_SESSION["texto_sucesso"] = $msg;
        header("Location: estoque.php");
        exit();
    }
}    

$nome = procuraProduto('nome',$conn);
$marca = procuraProduto('marca',$conn);
$base = procuraProduto('base',$conn);
$tipo = procuraProduto('tipo',$conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produtos</title>
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

    <!-- Barra de navegação lateral -->
    <nav class="sidebar">
       
        <div class="btn-expandir">
            <i class='bx bx-menu' id="btn-exp"></i>
        </div>

        <!-- lista de itens dentro da barra lateral -->
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

    <!-- Header -->
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


    <div class="container-form-cadastro">
        
        <div class="label-cadastro">
            <p>Cadastro:</p>
        </div>

        <form action="editar-produto.php" method="post">
            <div class="container-input">
                <label for="nome-prod">Nome:<input list="nomes" id="nome-prod" name="nome-prod" value="<?php echo $nomeMudar?>">
                    <datalist id="nomes">
                            <?php
                            foreach ($nome as $n){
                                echo "<option value='".$n['nome_produto']."'></option>";
                            }
                            ?>
                    </datalist>    
                </label>
                <label for="marca-prod">Marca:<input list="marcas" id="marca-prod" name="marca-prod" value="<?php echo $marcaMudar?>">
                    <datalist id="marcas">
                            <?php
                            foreach ($marca as $m){
                                echo "<option value='".$m['marca']."'></option>";
                            }
                            ?>
                    </datalist>    
                </label>
            </div>
            <div class="pausa"></div>
            <div class="container-input">
                 <label for="base-prod">Base:<input list="bases" id="base-prod" name="base-prod" value="<?php echo $baseMudar?>">
                     <datalist id="bases">
                            <?php
                            foreach ($base as $b){
                                echo "<option value='".$b['base']."'></option>";
                            }
                            ?>
                        </datalist>    
                    </label>
                    <label for="tipo-prod">Tipo:<select id="tipo-prod" name="tipo-prod" value="<?php echo $tipoMudar?>">
                             <?php
                            foreach ($tipo as $t){
                                echo "<option value='".$t['tipo']."'>".$t['tipo']."</option>";
                            }
                            ?>
                        </select>
                    </label>
                <label for="estado-prod" style="transform: translateX(3rem);">Estado:<select id="estado-prod" name="estado-prod" value="<?php echo $estadoMudar?>">
                        <option value="lacrado">Lacrado</option>
                        <option value="aberto">Aberto</option>
                        <option value="Vazio">Vazio</option>
                    </select>
                </label>
                <label for="validade-prod">Validade:<input type="date" id="validade-prod" name="validade-prod" value="<?php echo $validadeMudar?>"></label>
            </div>
            <div class="pausa"></div>
            <div class="" id="container-input">
                <label for="quantidade-prod">quantidade mínima:<input type="number" id="quantidade-prod" name="quantidade-prod-min" style="width: 23%;" min="0" value="<?php echo $quantMinMudar?>"></label>
                <label for="quantidade-prod">quantidade atual:<input type="number" id="quantidade-prod" name="quantidade-prod-atu" style="width: 23%;" min="0" value="<?php echo $quantAtuMudar?>"></label>
                <label for="quantidade-prod">quantidade ideal:<input type="number" id="quantidade-prod" name="quantidade-prod-max" style="width: 23%;" min="0" value="<?php echo $quantMaxMudar?>"></label>
                <input type="hidden" name="id" value="<?php echo $idProduto ?>">
            </div>
            <div class="pausa"></div>
            <div class="container-input">
                <input type="submit" id="cadastro-enviar">
            </div>
        </form>
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