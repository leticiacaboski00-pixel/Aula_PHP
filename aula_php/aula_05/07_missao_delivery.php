<?php
// Função responsável por calcular o subtotal de um único item (Preço x Quantidade)
function calcularSubtotal(array $item): float {
    return $item['preco'] * $item['quantidade'];
}

// Função responsável por calcular a soma de todos os subtotais do pedido usando foreach
function calcularTotal(array $pedido): float {
    $total = 0.0;
    foreach ($pedido as $item) {
        $total += calcularSubtotal($item);
    }
    return $total;
}

// Função responsável por aplicar a regra de negócio de desconto (10% para compras a partir de R$ 100)
function calcularDesconto(float $total): float {
    if ($total >= 100.0) {
        return $total * 0.10; // 10% de desconto
    }
    return 0.0;
}

// Função responsável por listar os itens do pedido no formato solicitado
function listarPedido(array $pedido): void {
    echo "===== PEDIDO =====" . PHP_EOL;

    foreach ($pedido as $item) {
        $subtotal = calcularSubtotal($item);
        $precoFormatado = number_format($item['preco'], 2, ',', '.');
        $subtotalFormatado = number_format($subtotal, 2, ',', '.');

        echo "{$item['produto']} {$item['quantidade']} x R$ $precoFormatado" . PHP_EOL;
        echo "Subtotal: R$ $subtotalFormatado" . PHP_EOL;
        echo "-------------------" . PHP_EOL;
    }
}

// Função responsável por exibir o resumo final com totais e descontos
function mostrarResumo(array $pedido): void {
    listarPedido($pedido);

    $totalSemDesconto = calcularTotal($pedido);
    $valorDesconto = calcularDesconto($totalSemDesconto);
    $totalFinal = $totalSemDesconto - $valorDesconto;

    echo PHP_EOL . "===== RESUMO =====" . PHP_EOL;
    echo "Total dos Produtos: R$ " . number_format($totalSemDesconto, 2, ',', '.') . PHP_EOL;

    if ($valorDesconto > 0) {
        echo "Desconto (10%)    : R$ " . number_format($valorDesconto, 2, ',', '.') . PHP_EOL;
    } else {
        echo "Desconto          : Sem desconto (Compras abaixo de R$ 100,00)" . PHP_EOL;
    }

    echo "TOTAL A PAGAR     : R$ " . number_format($totalFinal, 2, ',', '.') . PHP_EOL;
    echo "==================" . PHP_EOL;
}

// --- EXECUÇÃO DO PROGRAMA ---

// Cadastro interativo do pedido
$pedido = [];

echo "Quantos itens deseja adicionar ao pedido? ";
$qtdItens = (int) readline();

for ($i = 1; $i <= $qtdItens; $i++) {
    echo PHP_EOL . "--- Item $i ---" . PHP_EOL;

    echo "Nome do produto: ";
    $produto = readline();

    echo "Preço (R$): ";
    $preco = (float) readline();

    echo "Quantidade: ";
    $quantidade = (int) readline();

    $pedido[] = [
        "produto" => $produto,
        "preco" => $preco,
        "quantidade" => $quantidade
    ];
}

// Exibe a listagem e o resumo do pedido
if (!empty($pedido)) {
    echo PHP_EOL;
    mostrarResumo($pedido);
} else {
    echo PHP_EOL . "Nenhum item foi adicionado ao pedido." . PHP_EOL;
}
?>
