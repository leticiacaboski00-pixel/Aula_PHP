<?php
// Entrada de dados
echo "Informe um número inteiro positivo: ";
$numero = (int) readline();

// Validação de entrada
if ($numero <= 0) {
    echo "Erro: O número informado deve ser maior que zero." . PHP_EOL;
} else {
    // Variável acumuladora
    $soma = 0;

    // Estrutura de repetição para somar os valores de 1 até N
    for ($i = 1; $i <= $numero; $i++) {
        $soma = $soma + $i; // ou $soma += $i;
    }

    // Exibição do resultado final
    echo "A soma de 1 até $numero é $soma." . PHP_EOL;
}
?>