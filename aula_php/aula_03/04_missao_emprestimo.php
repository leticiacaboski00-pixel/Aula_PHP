<?php
// Geração automática do código da simulação
$codigoSimulacao = rand(100000, 999999);

// Entrada de dados
echo "Digite o nome do cliente: ";
$cliente = readline();

echo "Digite o salário mensal (R$): ";
$salario = (float) readline();

echo "Digite o valor do empréstimo solicitado (R$): ";
$valorEmprestimo = (float) readline();

echo "Digite a quantidade de parcelas: ";
$parcelas = (int) readline();

// Validação dos dados de entrada antes de qualquer cálculo
if ($salario <= 0) {
    echo PHP_EOL . "Erro: O salário deve ser maior que zero." . PHP_EOL;
} elseif ($valorEmprestimo <= 0) {
    echo PHP_EOL . "Erro: O valor do empréstimo deve ser maior que zero." . PHP_EOL;
} elseif ($parcelas <= 0) {
    echo PHP_EOL . "Erro: A quantidade de parcelas deve ser maior que zero." . PHP_EOL;
} else {
    // Cálculos financeiros (efetuados somente após validação completa das parcelas)
    $valorParcela = $valorEmprestimo / $parcelas;
    $limiteComprometimento = $salario * 0.30; // 30% do salário mensal

    // Análise de crédito
    $resultadoAnalise = "";
    if ($valorParcela <= $limiteComprometimento) {
        $resultadoAnalise = "EMPRÉSTIMO PRÉ-APROVADO";
    } else {
        $resultadoAnalise = "EMPRÉSTIMO NÃO APROVADO";
    }

    // Exibição dos resultados formatados
    echo PHP_EOL;
    echo "==========================================" . PHP_EOL;
    echo "       ANÁLISE DE CRÉDITO - SIMULAÇÃO     " . PHP_EOL;
    echo "==========================================" . PHP_EOL;
    echo "Código Simulação: #$codigoSimulacao" . PHP_EOL;
    echo "Cliente         : $cliente" . PHP_EOL;
    echo "Salário Mensal  : R$ " . number_format($salario, 2, ',', '.') . PHP_EOL;
    echo "Valor Solicitado: R$ " . number_format($valorEmprestimo, 2, ',', '.') . PHP_EOL;
    echo "Qtd. Parcelas   : $parcelas x" . PHP_EOL;
    echo "------------------------------------------" . PHP_EOL;
    echo "Valor Parcela   : R$ " . number_format($valorParcela, 2, ',', '.') . PHP_EOL;
    echo "Limite (30%)    : R$ " . number_format($limiteComprometimento, 2, ',', '.') . PHP_EOL;
    echo "Resultado       : $resultadoAnalise" . PHP_EOL;
    echo "==========================================" . PHP_EOL;
}
?>