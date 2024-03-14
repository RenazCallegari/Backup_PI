<?php
//Inclui todas as funções e script do arquivo connect.
include "banco/connect.php";

//seleciona tudo da tabela estoque.
$sql = "SELECT * FROM estoque";
//executa o comando acima atribuindo a variável resul
$resul = $conn->query($sql);

//Inicia um contador de quantos produtos tem no banco de dados.
$countQuant = 0;
//Compara se o número de tuplas (linhas de dados) for maior que 0
if ($resul->num_rows > 0) {
    //Enquanto tiver linhas diferentes adicione mais um no contador de quantidade de produtos.
    while ($row = $resul->fetch_assoc()) {
        $countQuant = $countQuant + 1;
    }
}

//Define que o timezone ou melhor que o horário padrão do sistema deve ser o horário de são Paulo
date_default_timezone_set('America/Sao_Paulo');
//Define as regras e símbolos que formatam as informações de tempo e da data e adicionam a linguagem como português/br
setlocale(LC_TIME, 'pt_BR', 'ptb');


$sql = "SELECT id_estoque FROM estoque WHERE quant_atual = quant_min";
$resul = $conn->query($sql);

$countQuantEstoqueMin = 0;
if ($resul->num_rows > 0) {
    while ($row = $resul->fetch_assoc()) {
        $countQuantEstoqueMin = $countQuantEstoqueMin + 1;
    }
}
//Inicia uma variável que receberá o retorno da função vencimentoEm com seus respectivos parâmetros.
$countNoventa = vencimentoEm(90, $conn);
$countTrinta = vencimentoEm(30, $conn);
$quantEstoqueCrit = estoqueCritico($conn);
$count = 0;

$tipo = "ASC";
$menosUsado = countUsos($tipo,$conn);

$tipo = "DESC";
$maisUsado = countUsos($tipo,$conn);

VerificaUser();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            background-color: white;
        }
    </style>
</head>
<body>

    <!-- Janela modal de LOGOFF -->
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
                <a href="cadastro.php" target="_self">
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

    <!-- Header  -->
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

        <div class="container-controle-prod">

            <div class="container-label-dados">
                <h3>Dados Gerais:</h3>
            </div>

                <div class="container-inner">
                    <div class="container-total-min">
                        <p>Total de produtos com estoque crítico:</p>
                            <p id="dados-inicio">
                            <?php
                            foreach($quantEstoqueCrit as $quantCrit){
                                if ($quantCrit['quant_min'] + 3 >= $quantCrit['quant_atual']){
                                    $count++;
                                }
                            }
                            echo $count;
                                ?>
                            </p>
                    </div>

                    <div class="container-total-90">
                        <p>Total de produtos com 90 dias até o vencimento:</p>
                            <p id="dados-inicio">
                            <?php echo $countNoventa ?>
                            </p>
                        </div>

                    <div class="container-total-30">
                        <p>Total de produtos com 30 dias até o vencimento:</p>
                            <p id="dados-inicio">
                            <?php echo $countTrinta ?>
                            </p>
                    </div>
                </div>

                <div class="container-inner">

                    <div class="container-util">
                    <p>O produto mais utilizado foi: </p>
                        <p>
                        <?php 
                        echo $maisUsado[1] ."<br>";
                        ?>
                        </p>
                        <p>Com </p>
                        <p>
                        <?php
                        echo $maisUsado[0];
                        ?>
                        <p> usos.</P>
                        </p>
                    </div>
                    <div class="container-util">
                        <p id="dados-inicio">
                        <!-- adicionar aqui a parte do php ;) -->
                        </p>
                    </div>
                    <div class="container-util">
                    <p>O produto menos utilizado foi: </p>
                        <p>
                        <?php 
                        echo $menosUsado[1] ."<br>";
                        ?>
                        </p>
                        <p>Com </p>
                        <p>
                        <?php
                        echo $menosUsado[0];
                        ?>
                        <p> usos.</P>
                        </p>
                        </p>
                    </div>
                </div>

        </div>
    <?php
    
    //Se for acionado algum gatilho de alerta vinculado a sessão atual, o sistema irá apresentar um erro/alerta
    //desvinculará o erro/alerta do usuário.
    if (isset($_SESSION['texto_alerta'])){
        echo '<div class="erro-box-home" id="erro-box-home">' . $_SESSION['texto_alerta'] . '</div>';
        echo '<a class="btn" id="fechar" onclick="fecharErro()">X</a>';
        unset($_SESSION['texto_alerta']);
    }

    ?>
    <footer>
        <div class="container-footer">
            <a>Todos os direitos reservados &copy; Can Say | 2024 - &infin;</a>
        </div>
    </footer>
  
<script src="https://unpkg.com/scrollreveal"></script>

<script src="js/script.js"></script>

</body>
</html>