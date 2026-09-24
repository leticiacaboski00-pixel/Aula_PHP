<?php

// Entrada de dados como texto original
echo "Informe um número para a tabuada: ";
$entrada = trim(readline());

// Valida se a entrada é numérica e se é um número inteiro
if (!is_numeric($entrada) || (int)$entrada != $entrada) {
    echo PHP_EOL . "Erro: Entrada inválida! Por favor, informe apenas números inteiros." . PHP_EOL;
} else {
    $numero = (int) $entrada;

    echo PHP_EOL . "--- TABUADA DO $numero ---" . PHP_EOL;

    // Estrutura de repetição 'for' de 1 até 10
    for ($i = 1; $i <= 10; $i++) {
        $resultado = $numero * $i;
        echo "$numero x $i = $resultado" . PHP_EOL;
    }
}
?>
