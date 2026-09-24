<?php
// Entrada de dados
echo "Informe um número para a tabuada: ";
$numero = (int) readline();

echo PHP_EOL . "--- TABUADA DO $numero ---" . PHP_EOL;

// Estrutura de repetição 'for' de 1 até 10
for ($i = 1; $i <= 10; $i++) {
    $resultado = $numero * $i;
    echo "$numero x $i = $resultado" . PHP_EOL;
}
?>