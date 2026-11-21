<?php

/*
    Classe responsável por fazer a conexão com o banco de dados
    
    host:    localhost
    banco:   TECNOLOGIAS_PARA_INTERNET
    usuario: root
    senha:   root

*/ 

$host    = "localhost";
$banco   = "TECNOLOGIAS_PARA_INTERNET";
$usuario = "root";
$senha   = "root";

try {
    
    //Cria a conexão utilizando PDO
    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;port=3306", 
        $usuario, 
        $senha
    );

    //Configura o PDO para lançar excessões em caso de erro 
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    //Configura o PDO para utilizar prepared , e inibir SQL Injection
    $pdo->setAttribute(
        PDO::ATTR_EMULATE_PREPARES,
        false
    );


} catch (PDOException $erro ) {
    die("Não foi possível conectar ao banco de dados");
}



?>