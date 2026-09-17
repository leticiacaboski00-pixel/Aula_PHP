<?php
// Geração automática de dados
$atendimento = rand(1000, 9999); // Número de atendimento de 4 dígitos
$dataAtual = date("d/m/Y H:i"); // Data e hora atual no formato dia/mês/ano hora:minuto

// Entrada de dados
echo "Digite o nome do cliente: ";
$cliente = readline();

echo "Digite a placa do veículo: ";
$placa = readline();

echo "Digite o tipo do veículo (moto, carro ou suv): ";
// strtolower garante que digitem MOTO, Moto ou moto e funcione do mesmo jeito
$tipoVeiculoInput = readline();
$tipoVeiculo = strtolower(trim($tipoVeiculoInput)); 

echo "Digite a quantidade de horas estacionadas: ";
$horas = (int) readline();

// Validação dos dados
if ($horas <= 0) {
    echo PHP_EOL . "Erro: A quantidade de horas deve ser maior que zero." . PHP_EOL;
} elseif ($tipoVeiculo !== "moto" && $tipoVeiculo !== "carro" && $tipoVeiculo !== "suv") {
    echo PHP_EOL . "Erro: Tipo de veículo inválido! Escolha entre 'moto', 'carro' ou 'suv'." . PHP_EOL;
} else {
    // Definição do valor por hora usando estruturas condicionais
    $valorHora = 0.0;

    if ($tipoVeiculo === "moto") {
        $valorHora = 5.00;
    } elseif ($tipoVeiculo === "carro") {
        $valorHora = 8.00;
    } elseif ($tipoVeiculo === "suv") {
        $valorHora = 12.00;
    }

    // Cálculos financeiros
    $subtotal = $horas * $valorHora;
    $percentualDesconto = 0;
    $valorDesconto = 0.0;

    // Aplicação do desconto para mais de 8 horas
    if ($horas > 8) {
        $percentualDesconto = 10;
        $valorDesconto = $subtotal * 0.10;
    }

    $totalFinal = $subtotal - $valorDesconto;

    // Exibição do comprovante/recibo formatado
    echo PHP_EOL;
    echo "========================================" . PHP_EOL;
    echo "       COMPROVANTE DE ESTACIONAMENTO    " . PHP_EOL;
    echo "========================================" . PHP_EOL;
    echo "Atendimento : #$atendimento" . PHP_EOL;
    echo "Data        : $dataAtual" . PHP_EOL;
    echo "Cliente     : $cliente" . PHP_EOL;
    echo "Placa       : $placa" . PHP_EOL;
    echo "Tipo Veículo: " . strtoupper($tipoVeiculo) . PHP_EOL;
    echo "Permanência : $horas hora(s)" . PHP_EOL;
    echo "Valor/Hora  : R$ " . number_format($valorHora, 2, ',', '.') . PHP_EOL;
    echo "----------------------------------------" . PHP_EOL;
    echo "Subtotal    : R$ " . number_format($subtotal, 2, ',', '.') . PHP_EOL;
    echo "Desconto    : $percentualDesconto% (R$ " . number_format($valorDesconto, 2, ',', '.') . ")" . PHP_EOL;
    echo "TOTAL FINAL : R$ " . number_format($totalFinal, 2, ',', '.') . PHP_EOL;
    echo "========================================" . PHP_EOL;
}
?>