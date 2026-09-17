<?php
// Geração automática do código e data do pedido
$codigoPedido = rand(100000, 999999);
$dataPedido = date("d/m/Y H:i");

// Entrada de dados
echo "Digite o nome do cliente: ";
$cliente = readline();

echo "Digite o nome do produto: ";
$produto = readline();

echo "Digite o valor unitário (R$): ";
$valorUnitario = (float) readline();

echo "Digite a quantidade: ";
$quantidade = (int) readline();

echo "Digite a forma de pagamento (pix, cartao, dinheiro): ";
$formaPagamentoInput = readline();
$formaPagamento = strtolower(trim($formaPagamentoInput)); // Normaliza o texto digitado

echo "Digite a distância da entrega em km: ";
$distancia = (float) readline();

// Validações dos dados de entrada
if ($valorUnitario <= 0) {
    echo PHP_EOL . "Erro: O valor unitário deve ser maior que zero." . PHP_EOL;
} elseif ($quantidade <= 0) {
    echo PHP_EOL . "Erro: A quantidade deve ser maior que zero." . PHP_EOL;
} elseif ($distancia < 0) {
    echo PHP_EOL . "Erro: A distância de entrega não pode ser negativa." . PHP_EOL;
} else {
    // Cálculo do subtotal
    $subtotal = $valorUnitario * $quantidade;

    // Cálculo da taxa de frete por faixa de distância
    $frete = 0.0;
    if ($distancia <= 3) {
        $frete = 5.00;
    } elseif ($distancia <= 8) {
        $frete = 10.00;
    } else {
        $frete = 18.00;
    }

    // Regra de desconto por subtotal
    $percentualDesconto = 0;
    if ($subtotal >= 200.00) {
        $percentualDesconto = 10;
    } elseif ($subtotal >= 100.00) {
        $percentualDesconto = 5;
    } // Subtotal abaixo de 100.00 permanece em 0%

    // Regra adicional para PIX (uso de comparação estrita ===)
    if ($formaPagamento === "pix") {
        $percentualDesconto += 2; // Acrescenta mais 2% ao desconto obtido
    }

    // Cálculo final dos valores financeiros
    $valorDesconto = $subtotal * ($percentualDesconto / 100);
    $totalPedido = ($subtotal - $valorDesconto) + $frete;

    // Exibição do comprovante final formatado no padrão brasileiro
    echo PHP_EOL;
    echo "==========================================" . PHP_EOL;
    echo "         COMPROVANTE DE DELIVERY          " . PHP_EOL;
    echo "==========================================" . PHP_EOL;
    echo "Código Pedido   : #$codigoPedido" . PHP_EOL;
    echo "Data            : $dataPedido" . PHP_EOL;
    echo "Cliente         : $cliente" . PHP_EOL;
    echo "Produto         : $produto" . PHP_EOL;
    echo "Quantidade      : $quantidade" . PHP_EOL;
    echo "Valor Unitário  : R$ " . number_format($valorUnitario, 2, ',', '.') . PHP_EOL;
    echo "Subtotal        : R$ " . number_format($subtotal, 2, ',', '.') . PHP_EOL;
    echo "------------------------------------------" . PHP_EOL;
    echo "Distância       : " . number_format($distancia, 1, ',', '.') . " km" . PHP_EOL;
    echo "Frete           : R$ " . number_format($frete, 2, ',', '.') . PHP_EOL;
    echo "Forma Pagamento : " . strtoupper($formaPagamento) . PHP_EOL;
    echo "Desconto Total  : $percentualDesconto% (R$ " . number_format($valorDesconto, 2, ',', '.') . ")" . PHP_EOL;
    echo "TOTAL DO PEDIDO : R$ " . number_format($totalPedido, 2, ',', '.') . PHP_EOL;
    echo "==========================================" . PHP_EOL;
}
?>