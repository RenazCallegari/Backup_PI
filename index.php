<?php
//Inclui o arquivo connect e tudo o que estiver nele.
include "banco/connect.php";

$msg = "";

//Verifica se foi enviado algum formulário com o método POST e se foi atribui variáveis com os os valores de name de cada campo input.
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //Um if ternário que verifica se foi enviado algum valor do campo input e se não foi atribui o valor vazio a variável.
    $userDigitado = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    $passwordDigitado = isset($_POST["senha"]) ? $_POST["senha"] : "";
    isset($_POST["ManterLogado"]) ? $_SESSION["manterLogin"] = $_POST["ManterLogado"] :"";

    //Verifica se o usuario digitado é diferente de vazio e se for executa os comandos dentro do if.
    if($userDigitado != "" && $passwordDigitado != ""){
        //Seleciona todos os registros da tabela usuario onde o login e a senha encriptografada coincidirem.
        $sql = "SELECT * FROM usuario WHERE usuario = '$userDigitado' AND password = PASSWORD('$passwordDigitado')";
        //Executa o comando acima já atribuindo a uma variável.
        $result = $conn->query($sql);

            //Verifica se a variável result foi executada e verifica se tem mais de uma linha de retorno.
            if($result && $result->num_rows > 0){
            //Pega o valor de fetch_assoc que retorna uma matriz associativa (array) representando a próxima linha no conjunto de dados do banco de dados.
            $row = $result->fetch_assoc();
            $_SESSION["id_usuario"] = $row["id_usuario"];
            $_SESSION["usuario_autenticado"] = $row["usuario"];
            //Muda a url para a home
            header("Location: home.php");
            //encerra a leitura do script atual.
            exit();
        //Caso a senha esteja errada ou vazia emite um alerta.
        } else {
            $msg = "<div class='erro-box' role='alert'>Usuário ou senha incorretos.</div>";
        }
    }
}
//Mantêm o login ativo.
if(isset($_SESSION["manterLogin"])){
    header("Location: home.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

   
    <div class="container-inicio">
        <div class="container-simbolo">
            <img src="imagens/simbolo.png" alt="Logo da estética com flores na parte inferior." class="estetica-logo">
            <h1 class="estetica-texto">ESTÉTICA</h1>
        </div>

        <div class="container-login-area">
            <?php
            echo $msg;

            if (isset($_SESSION['texto_alerta'])){
                echo '<div class="erro-box">' . $_SESSION['texto_alerta'] . '</div>';
                unset($_SESSION['texto_alerta']);
            }
            ?>
            <div class="container-login">   
                <h2 class="login-text">Login</h2>
                <form action="index.php" method="post">
                    <input type="text" name="usuario" id="usuario" placeholder="Usuário..." class="inputUser" required>
                        <div class="box-user-ico">
                            <i class='bx bx-user' id="user-icon"></i>
                        </div>
                    <label for="senha"> <i class='bx bx-show'id="MostrarSenha" onclick="MostrarSenha()"></i></label>
                    <input type="password" name="senha" id="senha" placeholder="Senha..." required>
                        <div class="box-lock-ico">
                            <i class='bx bx-lock-alt'></i>
                        </div>
                    <div class="container-manter-logado">
                        <input type="checkbox" name="ManterLogado" id="ManterLogado" style="width: 2rem; height: 1.5rem;">
                        <label for="ManterLogado" class="manterLogadoLabel">Manter-se logado?</label>
                    </div>
                    <input type="submit" value="Entrar" id="logar">
                </form>
                <div class="div-line"></div>
                <h4 class="prod-by">Uma produção Can Say</h4>

            </div>
        </div>
    
    </div>
    <script src="https://unpkg.com/scrollreveal"></script>

    <script src="js/script.js"></script>
</body>
</html>