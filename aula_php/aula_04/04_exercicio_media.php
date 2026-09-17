<?php
// Inicialização de variáveis
$quantidade = 0; // Contador
$soma = 0.0;     // Acumulador

// Primeira leitura antes do loop
echo "Informe um número (ou 0 para encerrar): ";
$numero = (float) readline();

// Repetição até o usuário digitar 0
while ($numero != 0) {
    $soma += $numero;       // Acumula o valor digitado
    $quantidade++;          // Incrementa a quantidade de números válidos

    // Leitura do próximo número
    echo "Informe um número (ou 0 para encerrar): ";
    $numero = (float) readline();
}

echo PHP_EOL . "--- RESULTADO FINAL ---" . PHP_EOL;

// Validação: calcula a média apenas se algum valor válido tiver sido digitado
if ($quantidade > 0) {
    $media = $soma / $quantidade;

    echo "Quantidade de valores: $quantidade" . PHP_EOL;
    echo "Soma: " . number_format($soma, 2, ',', '.') . PHP_EOL;
    echo "Média: " . number_format($media, 2, ',', '.') . PHP_EOL;
} else {
    echo "Nenhum número válido foi informado." . PHP_EOL;
}
?>