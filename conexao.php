<?php

$servidor = "db.fr-pari1.bengt.wasmernet.com:10272";
$Nomebd = "cdfDoFut";
$usuario = "94c58df3737c80000a8e1976e5d0";
$senha = "069194c5-8df3-7550-8000-74f0e658215d";

/*
$servidor = "localhost:3306";
$Nomebd = "cdfDoFut";
$usuario = "root";
$senha = "";*/

$conexao = mysqli_connect($servidor,$usuario,$senha,$Nomebd);

if(!$conexao){
    die("A conexão falhou: " . mysqli_connect_error());
}

mysqli_query($conexao, "SET time_zone = '-3:00';");
?>
