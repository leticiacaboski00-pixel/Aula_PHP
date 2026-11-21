<?php

// Inicia uma nova sessão
// ou recupera uma sessão existente.
//
// session_start() deve acontecer
// antes de qualquer saída HTML.
session_start();

// Criamos informações dentro da sessão.
//
// $_SESSION funciona como
// um array associativo.
$_SESSION["usuario"] = "Lucas";

$_SESSION["curso"] = "ADS";

// Mostramos uma mensagem.
echo "Informações armazenadas na sessão. <br>";


?>