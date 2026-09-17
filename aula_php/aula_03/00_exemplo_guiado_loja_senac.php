php<?php

// EXEMPLO GUIADO — LOJA SENAC TECH

$codigoCompra = rand(1000, 9999);
$dataCompra = date("d/m/Y"); 

$cliente = readline("Informe o nome do cliente: ");
$produto = readline("Informe o nome do produto: ");
$valorUnitario = (float) readline("Informe o valor unitário: R$ ");
$quantidade = (int) readline("Informe a quantidade: ");
$formaPagamento = readline("Forma de pagamento [pix/cartao/dinheiro]: ");

//Se valor unitario for menor ou igual a 0 OU quantidade menor ou igual a zero
if ($valorUnitario <= 0 || $quantidade <= 0) {

    echo PHP_EOL;
    echo "ERRO: valor e quantidade devem ser maiores que zero." . PHP_EOL;

} else {

    $subtotal = $valorUnitario * $quantidade;
    $percentualDesconto = 0;
    // Se valor da compra for maior ou igual a 1000 -> Desconto de 15%
    if ($subtotal >= 1000) {
        $percentualDesconto = 15;
    } elseif ($subtotal >= 500) {
        // Se valor da compra for maior ou igual a 500 e menor do que 1000 -> Desconto de 10%
        $percentualDesconto = 10;
    } elseif ($subtotal >= 200) {
        // Se valor da compra for maior ou igual a 200 e menor que 500 -> Desconto de 5%
        $percentualDesconto = 5;
    }

    //Se for PIX ganha +2% de desconto
    if ($formaPagamento === "pix") {
        $percentualDesconto = $percentualDesconto + 2;
    }

    $valorDesconto = $subtotal * ($percentualDesconto / 100);
    $totalFinal = $subtotal - $valorDesconto;

    echo PHP_EOL;
    echo "========================================" . PHP_EOL;
    echo "           RESUMO DA COMPRA" . PHP_EOL;
    echo "========================================" . PHP_EOL;
    echo "Código: {$codigoCompra}" . PHP_EOL;
    echo "Data: {$dataCompra}" . PHP_EOL;
    echo "Cliente: {$cliente}" . PHP_EOL;
    echo "Produto: {$produto}" . PHP_EOL;
    echo "Quantidade: {$quantidade}" . PHP_EOL;
    echo "Subtotal: R$ " . number_format($subtotal, 2, ",", ".") . PHP_EOL;
    echo "Pagamento: {$formaPagamento}" . PHP_EOL;
    echo "Desconto: {$percentualDesconto}%" . PHP_EOL;
    echo "Valor do desconto: R$ " . number_format($valorDesconto, 2, ",", ".") . PHP_EOL;
    echo "TOTAL: R$ " . number_format($totalFinal, 2, ",", ".") . PHP_EOL;
    echo "========================================" . PHP_EOL;
}
