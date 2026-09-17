<?php
// Entrada de dados
echo "Informe um número inteiro maior que zero: ";
$numero = (int) readline();

// Validação de entrada
if ($numero <= 0) {
    echo "Erro: O número informado deve ser maior que zero." . PHP_EOL;
} else {
    // Inicialização do contador
    $contador = 1;

    // Estrutura de repetição
    while ($contador <= $numero) {
        echo $contador . PHP_EOL;
        $contador++; // Incrementa o contador para evitar loop infinito
    }
}
?>