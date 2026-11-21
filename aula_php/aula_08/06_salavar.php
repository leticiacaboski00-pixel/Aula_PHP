<?php

// Iniciamos a sessão.
session_start();

// Criamos uma mensagem
// dentro da sessão.
$_SESSION["mensagem"] =
    "Cadastro realizado com sucesso!";

// Redirecionamos o usuário
// para outra página.
header(
    "Location: 07_resultado.php"
);

// Finalizamos este script.
//
// Isso evita que o restante
// do arquivo continue sendo executado.
exit;

?>