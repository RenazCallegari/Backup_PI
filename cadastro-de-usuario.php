<?php
include "banco/connect.php";
 
if (isset($_SESSION["id_usuario"]) AND $_SESSION["id_usuario"] != 1){
    $msg = "Sentimos muito, mas infelizmente você não possui autorização de acesso para acessar a página usuários.";
    $_SESSION["texto_alerta"] = $msg;
    header("Location: home.php");
    exit();
}
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    $usuario = ucfirst($usuario);
    $senha = isset($_POST["senha"]) ? $_POST["senha"] : "";
    $curso = isset($_POST["curso"]) ? $_POST["curso"] : "";
    if($usuario !="" and $senha !="" and $curso !=""){
        if($usuario != "Admin" AND $usuario != "admin" AND $usuario != "ADMIN"){
            $sql = "INSERT INTO usuario (usuario, password, curso, estado) VALUES ('$usuario',password('$senha'),'$curso','Ativo')";
            $resul = $conn->query($sql);
            if($resul){
                echo "Novo usuário inserido com sucesso!";
            }
        } else {
            echo "Infelizmente o nome Admin está armazenada no sistema, por favor utilize outro.";
        }
    } else {
        echo "Erro ao inserir dados, credenciais possivelmente vazias";
    }
}
 
if($_SERVER["REQUEST_METHOD"] == "GET"){
    $alterarUsuario = isset($_GET["usuario"]) ? $_GET["usuario"] : "";
    $alterarEstado = isset($_GET["estado-usuario"]) ? $_GET["estado-usuario"] : "";

    $senha = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-/*.+@"), 5, 20);

    if($alterarEstado == "Desativado"){
        $sql = "UPDATE usuario SET estado='$alterarEstado', password=MD5('$senha') WHERE usuario = '$alterarUsuario'";
        $resul = $conn->query($sql);
    }
   
    if($alterarEstado == "Ativo"){
        $sql = "UPDATE usuario SET estado='$alterarEstado', password=password('12345') WHERE usuario ='$alterarUsuario'";
        $resul = $conn->query($sql);
    }
}

$alterarUser = alterarUser($conn);
$todosCursos = todosCursos($conn);
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de usuario</title>
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
 
    <div class="container-cadastro-usuario">
       
        <div class="label-cadastro-usuario">
            <p>Cadastro de Usuario:</p>
        </div>
 
        <div class="container-forms-cadastro-usuario">
            <form action="cadastro-de-usuario.php" method="post">
            <h2 class="login-text-2">Convidar:</h2>
               <input type="text" name="usuario" id="usuario" placeholder="Usuário..." class="inputUser" required>
               <div class="box-user-ico-2">
                    <i class='bx bx-user' id="user-icon"></i>
                </div>
               <label for="senha"> <i class='bx bx-show'id="MostrarSenha" onclick="MostrarSenha()" style="color: #8e8e8e; position:absolute; top: 32.4vh; left: 33.1vw;"></i></label>
               <input type="password" name="senha" id="senha" placeholder="Senha..." class="inputUser" required>
               <div class="box-lock-ico-2">
                    <i class='bx bx-lock'></i>
                </div>
               <input list="cursos" name="curso" id="curso" placeholder="Curso..." class="inputUser" required>
               <datalist id="cursos">
                    <?php
                    foreach($todosCursos as $curso){
                        echo "<option value='".$curso['curso']."'></option>";
                    }
                    ?>
               </datalist>
                    <div class="box-user-ico-2">
                        <i class='bx bx-envelope'></i>
                    </div>
                <input type="submit" id="email-convidado" class="cadastrar">
            </form>
            <div class="container-divisao"></div>
            <form action="cadastro-de-usuario.php" method="get">
            <h2 class="login-text-2">Alterar estado de usuario:</h2>
               <input list="usuarios" name="usuario" id="usuario" placeholder="Usuario..." class="inputUser" required>
               <datalist id="usuarios">
                    <?php
                    foreach($alterarUser as $user){
                        echo "<option value='".$user['usuario']."'></option>";
                    }
                    ?>
               </datalist>
                    <div class="box-user-ico-2">
                        <i class='bx bx-user' id="user-icon"></i>
                    </div>
                <select id="estado-usuario" name="estado-usuario">
                    <option value="Ativo">Ativo</option>
                    <option value="Desativado">Desativado</option>
                <input type="submit" value="alterar" id="alterar-usuario">
            </form>
        </div>
 
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