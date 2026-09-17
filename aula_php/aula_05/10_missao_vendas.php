<?php
// Função responsável por buscar o preço unitário de um produto pelo seu nome
function buscarProduto(string $nomeProduto, array $produtos): float {
    foreach ($produtos as $p) {
        if (strcasecmp($p['nome'], $nomeProduto) === 0) {
            return $p['preco'];
        }
    }
    return 0.0; // Retorna 0 caso o produto não seja encontrado
}

// Função responsável por calcular o valor total de uma única venda (Quantidade × Preço Unitário)
function calcularVenda(array $venda, array $produtos): float {
    $precoUnitario = buscarProduto($venda['produto'], $produtos);
    return $venda['quantidade'] * $precoUnitario;
}

// Função responsável por calcular o faturamento total acumulado de todas as vendas
function calcularFaturamento(array $vendas, array $produtos): float {
    $faturamento = 0.0;
    foreach ($vendas as $venda) {
        $faturamento += calcularVenda($venda, $produtos);
    }
    return $faturamento;
}

// Função responsável por listar as vendas item por item formatadas no terminal
function listarVendas(array $vendas, array $produtos): void {
    echo "========== VENDAS ==========" . PHP_EOL;

    foreach ($vendas as $venda) {
        $precoUnitario = buscarProduto($venda['produto'], $produtos);
        $subtotal = calcularVenda($venda, $produtos);

        $precoFormatado = number_format($precoUnitario, 2, ',', '.');
        $subtotalFormatado = number_format($subtotal, 2, ',', '.');

        echo "{$venda['produto']}" . PHP_EOL;
        echo "Quantidade: {$venda['quantidade']}" . PHP_EOL;
        echo "Valor unitário: R$ {$precoFormatado}" . PHP_EOL;
        echo "Total: R$ {$subtotalFormatado}" . PHP_EOL;
        echo "----------------------------" . PHP_EOL;
    }
}

// Função responsável por consolidar e exibir o relatório completo
function mostrarRelatorio(array $vendas, array $produtos): void {
    listarVendas($vendas, $produtos);

    $faturamentoTotal = calcularFaturamento($vendas, $produtos);
    $faturamentoFormatado = number_format($faturamentoTotal, 2, ',', '.');

    echo "============================" . PHP_EOL;
    echo "Faturamento: R$ {$faturamentoFormatado}" . PHP_EOL;
    echo "============================" . PHP_EOL;
}

// --- PROGRAMA PRINCIPAL ---

// 1. Base de dados de Produtos cadastrados no sistema
$produtos = [
    ["nome" => "Notebook", "preco" => 3500.00],
    ["nome" => "Mouse",    "preco" => 80.00],
    ["nome" => "Teclado",  "preco" => 150.00]
];

// 2. Registro das vendas realizadas
$vendas = [
    ["produto" => "Notebook", "quantidade" => 2],
    ["produto" => "Mouse",    "quantidade" => 5]
];

// 3. Exibição do relatório consolidador
mostrarRelatorio($vendas, $produtos);
?>