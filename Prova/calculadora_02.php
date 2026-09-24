<?php
// Entrada do primeiro número
echo "Informe o primeiro número: ";
$numero1 = (float) readline();

// Entrada do segundo número
echo "Informe o segundo número: ";
$numero2 = (float) readline();

// Escolha da operação
echo "Informe a operação (+, -, *, /): ";
$operacao = trim(readline());

echo PHP_EOL;

// Estrutura condicional para calcular o resultado
switch ($operacao) {
    case '+':
        $resultado = $numero1 + $numero2;
        echo "Resultado: $numero1 + $numero2 = $resultado" . PHP_EOL;
        break;

    case '-':
        $resultado = $numero1 - $numero2;
        echo "Resultado: $numero1 - $numero2 = $resultado" . PHP_EOL;
        break;

    case '*':
        $resultado = $numero1 * $numero2;
        echo "Resultado: $numero1 * $numero2 = $resultado" . PHP_EOL;
        break;

    case '/':
        // Validação para evitar divisão por zero
        if ($numero2 == 0) {
            echo "OPERAÇÃO NÃO PODE SER REALIZADA (Divisão por zero)" . PHP_EOL;
        } else {
            $resultado = $numero1 / $numero2;
            echo "Resultado: $numero1 / $numero2 = $resultado" . PHP_EOL;
        }
        break;

    default:
        echo "OPERAÇÃO NÃO PODE SER REALIZADA" . PHP_EOL;
        break;
}
?>