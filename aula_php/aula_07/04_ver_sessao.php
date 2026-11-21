<?php

// Recuperamos a sessão.
session_start();

// Verificamos se existe
// um usuário armazenado.
if (isset($_SESSION["usuario"])) {

    // Pegamos os valores da sessão.
    $usuario = $_SESSION["usuario"];

    $curso = $_SESSION["curso"];

    // Exibimos os valores.
    echo "Usuário: {$usuario}<br>";

    echo "Curso: {$curso}";

} else {

    // Caso a informação não exista.
    echo "Nenhuma sessão encontrada.";
}

?>