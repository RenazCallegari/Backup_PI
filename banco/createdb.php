<?php
 
//Variaveis para acessar o SGBD.
$host = "localhost";
//Host ≠ LocalHost. Host e todo e qualquer dispositivo conectado a uma rede, um host nada mais e do que um provedor de servicos.
//LocalHost e um conjunto de faixa de ip (127.0.0.0) cuja funcao e permitir que o computador possa conversar consigo mesmo, isso e disponibilizar servicos para si.
 
$user = "root";
//Root vem de raiz, e o termo adotado pelas S.O linux para definir um administrador, neste contexto o user seria o usuario que tem acesso ao SGBD.
 
$password = "";
//Uma senha vazia.
 
$bd = "id21965817_db_estetcontrol";
 
$conn = new mysqli($host, $user, $password);
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
} else {
    echo "Parabens voce acessou o seu $bd <br>";
    //Mostra a mensagem se vc conseguiu conectar
}
 
//Cria um comando em sql para ser atribuido a uma variavel chamada $sql.
$sql = "CREATE DATABASE IF NOT EXISTS $bd";
 
//Executa o comando criado recentemente.
if($conn->query($sql)){
    //-> = insercao ou execute.
    //query requisicao.
    echo "Deu certo ᕙ(`▿´)ᕗ você criou o banco de dados! <br>";
} else {
    echo "Não deu certo ಥ_ಥ você não criou o banco de dados! <br>";
}
 
//cria uma execucao utilizando a funcao select_db (use do php).
$conn->select_db($bd);
//use em php e uma funcao cuja finalidade e servir para outro proposito.
//para que nao crie um conflito foi criado a funcao select_db cuja finalidade e servir como uma traducao do USE de SQL.
 
//Gera o código sql de criação de um banco de dados.
$sql = "CREATE TABLE IF NOT EXISTS usuario(
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    curso VARCHAR(255) NOT NULL,
    estado VARCHAR(255) NOT NULL
)";
 
//Executa o comando criado recentemente.
if($conn->query($sql)){
    echo "Deu certo ᕙ(`▿´)ᕗ você criou a tabela usuario! <br>";
} else {
    echo "Não deu certo ಥ_ಥ você não criou a tabela usuario! <br>";
}

//Faz o mesmo processo dos dois conjuntos acima apenas mudando os valores.
$sql = "CREATE TABLE IF NOT EXISTS produto(
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(255) NOT NULL,
    marca VARCHAR(255),
    base VARCHAR(255),
    tipo VARCHAR(255)
)";
 
if($conn->query($sql)){
    echo "Deu certo ᕙ(`▿´)ᕗ você criou a tabela produto! <br>";
} else {
    echo "Não deu certo ಥ_ಥ você não criou a tabela produto! <br>";
}

//Faz o mesmo processo dos dois conjuntos acima apenas mudando os valores.
$sql = "CREATE TABLE IF NOT EXISTS validade(
    id_validade INT AUTO_INCREMENT PRIMARY KEY,
    id_produto_fk INT NOT NULL,
    validade DATE NOT NULL,
    estado VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_produto_fk) REFERENCES produto(id_produto)
)";

if($conn->query($sql)){
    echo "Deu certo ᕙ(`▿´)ᕗ você criou a tabela validade! <br>";
} else {
    echo "Não deu certo ಥ_ಥ você não criou a tabela validade! <br>";
}

//Faz o mesmo processo dos dois conjuntos acima apenas mudando os valores.
$sql = "CREATE TABLE IF NOT EXISTS email(
    id_email INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario_fk INT NOT NULL,
    email varchar(255) NOT NULL,
    token varchar(255) NOT NULL,
    validade date NOT NULL,
    FOREIGN KEY (id_usuario_fk) REFERENCES usuario(id_usuario)
)";
 
if($conn->query($sql)){
    echo "Deu certo ᕙ(`▿´)ᕗ você criou a tabela email! <br>";
} else {
    echo "Não deu certo ಥ_ಥ você não criou a tabela email! <br>";
}
 
//Faz o mesmo processo dos dois conjuntos acima apenas mudando os valores.
$sql = "CREATE TABLE IF NOT EXISTS estoque(
    id_estoque INT AUTO_INCREMENT PRIMARY KEY,
    id_produto_fk INT NOT NULL,
    id_usuario_fk INT NOT NULL,
    quant_min INT NOT NULL,
    quant_atual INT NOT NULL,
    quant_ideal INT NOT NULL,
    usos INT NOT NULL,
    FOREIGN KEY (id_produto_fk) REFERENCES produto(id_produto),
    FOREIGN KEY (id_usuario_fk) REFERENCES usuario(id_usuario)
)";
 
if($conn->query($sql)){
    echo "Deu certo ᕙ(`▿´)ᕗ você criou a tabela estoque! <br>";
} else {
    echo "Não deu certo ಥ_ಥ você não criou a tabela estoque! <br>";
}

//Encerra a conexao.
$conn->close();
 
?>