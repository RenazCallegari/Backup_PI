<?php
 
//Variaveis para acessar o SGBD.
$host = "localhost";
//Host ≠ LocalHost. Host e todo e qualquer dispositivo conectado a uma rede, um host nada mais e do que um provedor de servicos.
//LocalHost e um conjunto de faixa de ip (127.0.0.0) cuja funcao e permitir que o computador possa conversar consigo mesmo, isso e disponibilizar servicos para si.
 
$user = "id21965817_root";
//Root vem de raiz, e o termo adotado pelas S.O linux para definir um administrador, neste contexto o user seria o usuario que tem acesso ao SGBD.
 
$password = "@Senac2010";
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

//cria uma execucao utilizando a funcao select_db (use do php).
$conn->select_db($bd);
//use em php e uma funcao cuja finalidade e servir para outro proposito.
//para que nao crie um conflito foi criado a funcao select_db cuja finalidade e servir como uma traducao do USE de SQL.
 
//Cria o nosso usuário admin
$sql = "INSERT INTO usuario (usuario, password, curso, estado) VALUES ('Admin', PASSWORD('159753'), 'T.I', 'Ativo')";
 
//Executa o comando criado recentemente.
if($conn->query($sql)){
    //-> = insercao ou execute.
    //query = requisicao.
    echo "Deu certo ᕙ(`▿´)ᕗ<br>O Administrador está ON! <br>";
} else {
    echo "Não deu certo ಥ_ಥ<br>O Admin ainda não veio! <br>";
    exit();
}
 
//Inicia um contador que irá se aproximar até a quantidade final de tuplas do excel fornecido pela estética
$row = 0;
//Uma condicional que contém a atribuição de uma variável cujo valor é a abertura de um arquivo csv no modo leitura.
if (($estoque = fopen("estoque_produto.csv", "r")) !== FALSE) {
    //Cria uma ocorrencia em forma de array para cada grupo de dados separados por ; dentro de estoque com a quantidade max de 1000 caracteres.
    while (($dados = fgetcsv($estoque, 1000, ";")) !== FALSE) {
        //pula para a próxima linha.
        $row++;
        //inicia um contator de valor 1 cuja função é únicamente executar a atribuição dos valores do array da linha row em um comando sql e os executa.
        for ($c=0; $c < 1; $c++) {
            $sql = "INSERT INTO produto (nome_produto, base, marca, tipo) VALUES ('$dados[0]','$dados[1]','$dados[2]','$dados[3]')";
            $resul = $conn->query($sql);
        }
    }
    //fecha o arquivo que estava aberto anteriormente.
    fclose($estoque);
    //reinicia a variável que conta as linhas.
    $row = 0;
}
 
//Repete o mesmo processo acima mudando apenas o arquivo, porém agora, o comando compara os dados do arquivo com os dados do banco da dados e insere apenas as datas na tabela
//validade já considerando e realizando a relação com a tabela produtos.
if (($estoque = fopen("estoque_2024.csv", "r")) !== FALSE) {
    while (($dados = fgetcsv($estoque, 2000, ";")) !== FALSE) {
        $row++;
        for ($c=0; $c < 1; $c++) {
            $sql = "SELECT id_produto FROM produto WHERE nome_produto = '$dados[0]' AND base = '$dados[1]' AND marca = '$dados[2]' AND tipo = '$dados[3]'";
            $resul = $conn->query($sql);
            $validadeDB = array();
            if ($resul->num_rows > 0) {
                while ($row = $resul->fetch_assoc()) {
                $validadeDB[] = $row;
                }
                foreach($validadeDB as $validade){
                    $sql = "INSERT INTO validade (id_produto_fk, validade, estado) VALUES (".$validade['id_produto'].",'$dados[4]','Lacrado')";
                    $resul = $conn->query($sql);
                }
            }
        }
    }
    fclose($estoque);
    $row = 0;
    unset($validadeDB);
}
 
//Repete o mesmo processo acima mudando apenas o arquivo.
if (($estoque = fopen("estoque_2025.csv", "r")) !== FALSE) {
    while (($dados = fgetcsv($estoque, 2000, ";")) !== FALSE) {
        $row++;
        for ($c=0; $c < 1; $c++) {
            $sql = "SELECT id_produto FROM produto WHERE nome_produto = '$dados[0]' AND base = '$dados[1]' AND marca = '$dados[2]' AND tipo = '$dados[3]'";
            $resul = $conn->query($sql);
            $validadeDB = array();
            if ($resul->num_rows > 0) {
                while ($row = $resul->fetch_assoc()) {
                $validadeDB[] = $row;
                }
                foreach($validadeDB as $validade){
                    $sql = "INSERT INTO validade (id_produto_fk, validade, estado) VALUES (".$validade['id_produto'].",'$dados[4]','Lacrado')";
                    $resul = $conn->query($sql);
                }
            }
        }
    }
    fclose($estoque);
    $row = 0;
    unset($validadeDB);
}
 
//Repete o mesmo processo acima mudando apenas o arquivo
if (($estoque = fopen("estoque_2026.csv", "r")) !== FALSE) {
    while (($dados = fgetcsv($estoque, 2000, ";")) !== FALSE) {
        $row++;
        for ($c=0; $c < 1; $c++) {
            $sql = "SELECT id_produto FROM produto WHERE nome_produto = '$dados[0]' AND base = '$dados[1]' AND marca = '$dados[2]' AND tipo = '$dados[3]'";
            $resul = $conn->query($sql);
            $validadeDB = array();
            if ($resul->num_rows > 0) {
                while ($row = $resul->fetch_assoc()) {
                $validadeDB[] = $row;
                }
                foreach($validadeDB as $validade){
                    $sql = "INSERT INTO validade (id_produto_fk, validade, estado) VALUES (".$validade['id_produto'].",'$dados[4]','Lacrado')";
                    $resul = $conn->query($sql);
                }
            }
        }
    }
    fclose($estoque);
    $row = 0;
    unset($validadeDB);
}
 
//Repete o mesmo processo acima mudando apenas o arquivo
if (($estoque = fopen("estoque_2027.csv", "r")) !== FALSE) {
    while (($dados = fgetcsv($estoque, 2000, ";")) !== FALSE) {
        $row++;
        for ($c=0; $c < 1; $c++) {
            $sql = "SELECT id_produto FROM produto WHERE nome_produto = '$dados[0]' AND base = '$dados[1]' AND marca = '$dados[2]' AND tipo = '$dados[3]'";
            $resul = $conn->query($sql);
            $validadeDB = array();
            if ($resul->num_rows > 0) {
                while ($row = $resul->fetch_assoc()) {
                $validadeDB[] = $row;
                }
                foreach($validadeDB as $validade){
                    $sql = "INSERT INTO validade (id_produto_fk, validade, estado) VALUES (".$validade['id_produto'].",'$dados[4]','Lacrado')";
                    $resul = $conn->query($sql);
                }
            }
        }
    }
    fclose($estoque);
    $row = 0;
    unset($validadeDB);
}
//Após criar todos os dados presentes nas tabela produto, insere um valor inicial na tabela estoque já vinculando o produto com um estoque padrão (min = 0, atual = 5 e ideal = 10).
$sql = "SELECT * FROM produto";
$resul = $conn->query($sql);
 
$estoqueBD = array();
if ($resul->num_rows > 0) {
    while ($row = $resul->fetch_assoc()) {
        $estoqueBD[] = $row;
    }
   
    foreach($estoqueBD as $estoque){
        $sql = "INSERT INTO estoque (id_produto_fk, id_usuario_fk, quant_min, quant_atual, quant_ideal, usos) VALUES (".$estoque['id_produto'].",'1','0','5','10', '0')";
        $resul = $conn->query($sql);
    }
}
 
//Criação de uma função cuja ideia seja contar quantos casos temos de produtos diferentes no arquivo responsável pela criação da tabela produtos.
function contarLinhasArquivo($arquivo){
    $linhas = 0;
    $linhas += count( file($arquivo) );
    return $linhas;
}
 
$sql = "SELECT * FROM produto";
$resul = $conn->query($sql);
 
$row = 0;
if ($resul->num_rows > 0) {
    while ($row < contarLinhasArquivo("estoque_produto.csv")) {
        $row++;
        $sql = "UPDATE estoque SET quant_atual = (SELECT count(*) FROM validade, produto WHERE id_produto = $row AND id_produto_fk = $row) WHERE id_estoque = $row";
        $resul = $conn->query($sql);
    }
}
//Após criar todos os dados presentes nas tabelas exclui a si mesmo (arquivo).
//unlink('createdatasdb.php');
//Encerra a conexao.
$conn->close();
 
?>