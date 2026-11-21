<?php

// Carregamos nosso arquivo
// que contém funções.
//
// require_once garante que
// esse arquivo seja carregado
// apenas uma vez.
require_once "11_funcoes.php";

// Recebemos o e-mail.
$email = "aluno@senac.br";

// Chamamos nossa função.
if (validarEmail($email)) {

    echo "E-mail válido.";

} else {

    echo "E-mail inválido.";
}

?>