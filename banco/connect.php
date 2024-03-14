<?php
//Inicia a sessão (cookies).
session_start();

//Variaveis para acessar o SGBD.
$host = "localhost";
//Host ≠ LocalHost. Host e todo e qualquer dispositivo conectado a uma rede, um host nada mais e do que um provedor de servicos.
//LocalHost e um conjunto de faixa de ip (127.0.0.0) cuja funcao e permitir que o computador possa conversar consigo mesmo, isso e disponibilizar servicos para si.
 
$user = "id21965817_root";
//Root vem de raiz, e o termo adotado pelas S.O linux para definir um administrador, neste contexto o user seria o usuario que tem acesso ao SGBD.
 
$password = "@Senac2010";
//Uma senha vazia.
 
$bd = "id21965817_db_estetcontrol";
 
$conn = new mysqli($host, $user, $password, $bd);
//conn vem de connection.
//mysqli e diferente de mysql que e diferente de sql.
//mysqli e uma melhoria que eventualmente se tornou uma biblioteca propria, i vem de improved(melhorada).
//mysql e o sistema gerenciador de banco de dados.
//sql e vem do ingles structured query language ou linguagem estruturada de consulta.

//Testa o estado da conexao.
if($conn->connect_error){
    echo "Voce nao conseguiu acessar o seu $bd" . $conn->connect_error . "<br>";
    //Ecoa uma mensagem caso nao tenha acessado, atribui um valor referente a uma variavel e apresenta o tipo de erro.
    die();
    //Encerra a execucao do programa.
}

//Inicia uma função que conta em quanto tempo um determinado produto vai vencer.
function vencimentoEm($dias, $conn){

    //Seleciona todos os produtos que irão vencer entre o dia atual e quantidade de dias inseridas pelo usuário.
    $sql = "SELECT * FROM validade WHERE validade BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL $dias DAY)";
    $resul = $conn->query($sql);
    //Inicia um contador que define quantos produtos irão vencer nesse intervalo de tempo.
    $count = 0;
    //Analisa quantas linhas serão retornadas pelo Banco de dados.
    if ($resul->num_rows > 0) {
        //Enquanto houver linhas adiciona mais 1 para o contador.
        while ($row = $resul->fetch_assoc()) {
            $count = $count + 1;
        }
    }
    //retorna o contador.
    return $count;
}

function estoqueCritico($conn){
    //Seleciona o nome, validade e estado de todos os produtos da tabela estoque onde o id do usuario for igual o id
    //armazenado pela sesão.
    $sql = "SELECT * FROM produto, estoque WHERE id_produto= id_produto_fk;";
    //Executa o comando acima
    $resul = $conn->query($sql);

    //Cria um array de produtos e para cada resultado do select adiciona os dados dentro do array.
    $produtosBD = array();
    if ($resul->num_rows > 0) {
        while ($row = $resul->fetch_assoc()) {
            $produtosBD[] = $row;
        }
    }
    return $produtosBD;
}

function alterarUser($conn){
    $sql = "SELECT id_usuario, usuario FROM usuario";
    $resul = $conn->query($sql);
 
    $usuariosBD = array();
    if ($resul->num_rows > 0) {
        while ($row = $resul->fetch_assoc()) {
            $usuariosBD[] = $row;
        }
    }
    return $usuariosBD;
}

function todosCursos($conn){
    $sql = "SELECT DISTINCT curso FROM usuario";
    $resul = $conn->query($sql);
 
    $cursosBD = array();
    if ($resul->num_rows > 0) {
        while ($row = $resul->fetch_assoc()) {
            $cursosBD[] = $row;
        }
    }
    return $cursosBD;
}

function countUsos($tipo, $conn){

    if($tipo == "ASC"){
        $sql = "SELECT * FROM estoque,produto ORDER BY 'usos' ASC LIMIT 1";
        $resul = $conn->query($sql);

        $produtoUsado = array();
        $countUsado = 0;
        if ($resul->num_rows > 0) {
            while ($row = $resul->fetch_assoc()) {
                $produtoUsado[] = $row;
                $countUsado = $countUsado + 1;
            }
            foreach ($produtoUsado as $produto){
                $nomeProduto = $produto['nome_produto'];
            }
        }
    }
    if($tipo == "DESC"){
        $sql = "SELECT * FROM estoque,produto ORDER BY 'usos' DESC LIMIT 1";
        $resul = $conn->query($sql);

        $produtoUsado = array();
        $countUsado = 0;
        if ($resul->num_rows > 0) {
            while ($row = $resul->fetch_assoc()) {
                $produtoUsado[] = $row;
                $countUsado = $countUsado + 1;
            }
            foreach ($produtoUsado as $produto){
                $nomeProduto = $produto['nome_produto'];
            }
        }
    }
    if($countUsado == 0){
        $nomeProduto = "Nenhum produto foi usado ainda";
        }

    return array($countUsado,$nomeProduto);
}

function procuraProduto($procura,$conn){

    if($procura == "nome"){
        $sql = "SELECT DISTINCT nome_produto FROM produto";
        $resul = $conn->query($sql);
        $infoProdutos = array();
        if ($resul->num_rows > 0) {
            while ($row = $resul->fetch_assoc()) {
                $infoProdutos[] = $row;
            }
        }
    }

    if($procura == "marca"){
        $sql = "SELECT DISTINCT marca FROM produto";
        $resul = $conn->query($sql);
        $infoProdutos = array();
        if ($resul->num_rows > 0) {
            while ($row = $resul->fetch_assoc()) {
                $infoProdutos[] = $row;
            }
        }
    }

    if($procura == "base"){
        $sql = "SELECT DISTINCT base FROM produto";
        $resul = $conn->query($sql);
        $infoProdutos = array();
        if ($resul->num_rows > 0) {
            while ($row = $resul->fetch_assoc()) {
                $infoProdutos[] = $row;
            }
        }
    }

    if($procura == "tipo"){
        $sql = "SELECT DISTINCT tipo FROM produto";
        $resul = $conn->query($sql);
        $infoProdutos = array();
        if ($resul->num_rows > 0) {
            while ($row = $resul->fetch_assoc()) {
                $infoProdutos[] = $row;
            }
        }
    }
    return $infoProdutos;
}

function VerificaUser(){
    if (!isset($_SESSION["id_usuario"])){
        $msg = "Antes de usar nosso serviço por gentileza se conecte normalmente.";
        $_SESSION["texto_alerta"] = $msg;
        header("Location: index.php");
        exit();
    }
}

//Inicializa uma função que não precisa de parâmetros e primeiro desvincula todos os dados dos cookies(da sessão)
//depois destroi os cookies (apaga a sessão) e redireciona o usuário a página login. 
function logout(){
    session_unset();
    session_destroy();
    
    header("Location: index.php");
    exit();
}
?>