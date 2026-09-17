<?php
// Função para cadastrar os 5 produtos na estrutura de array associativo
function cadastrarProdutos(): array {
    $produtos = [];

    for ($i = 1; $i <= 5; $i++) {
        echo "--- Cadastro do Produto $i ---" . PHP_EOL;

        echo "Nome: ";
        $nome = readline();

        echo "Preço (R$): ";
        $preco = (float) readline();

        echo "Quantidade em estoque: ";
        $quantidade = (int) readline();

        $produtos[] = [
            "nome" => $nome,
            "preco" => $preco,
            "quantidade" => $quantidade
        ];
        echo PHP_EOL;
    }

    return $produtos;
}

// Função para calcular o total de unidades físicas no estoque
function calcularTotalUnidades(array $produtos): int {
    $totalUnidades = 0;
    foreach ($produtos as $produto) {
        $totalUnidades += $produto['quantidade'];
    }
    return $totalUnidades;
}

// Função para calcular o valor financeiro total acumulado no estoque
function calcularValorTotalEstoque(array $produtos): float {
    $valorTotal = 0.0;
    foreach ($produtos as $produto) {
        $valorTotal += ($produto['preco'] * $produto['quantidade']);
    }
    return $valorTotal;
}

// Função para identificar o produto com o maior preço unitário
function buscarProdutoMaisCaro(array $produtos): array {
    $maisCaro = $produtos[0];
    foreach ($produtos as $produto) {
        if ($produto['preco'] > $maisCaro['preco']) {
            $maisCaro = $produto;
        }
    }
    return $maisCaro;
}

// Função para filtrar e retornar apenas os produtos com estoque crítico (abaixo de 5 unidades)
function buscarEstoqueBaixo(array $produtos): array {
    $estoqueBaixo = [];
    foreach ($produtos as $produto) {
        if ($produto['quantidade'] < 5) {
            $estoqueBaixo[] = $produto;
        }
    }
    return $estoqueBaixo;
}

// Função para filtrar e retornar apenas os produtos que custam mais de R$ 100,00
function buscarProdutosCaros(array $produtos): array {
    $produtosCaros = [];
    foreach ($produtos as $produto) {
        if ($produto['preco'] > 100.00) {
            $produtosCaros[] = $produto;
        }
    }
    return $produtosCaros;
}

// Função para listar os itens e os indicadores formatados
function gerarRelatorio(
    array $produtos, 
    int $totalUnidades, 
    float $valorTotalEstoque, 
    array $maisCaro, 
    array $estoqueBaixo, 
    array $produtosCaros
): void {
    echo "========= LOJA SENAC =========" . PHP_EOL;
    echo "PRODUTOS" . PHP_EOL;

    foreach ($produtos as $produto) {
        $precoFormatado = number_format($produto['preco'], 2, ',', '.');
        echo "{$produto['nome']} Preço: R$ {$precoFormatado} Estoque: {$produto['quantidade']}" . PHP_EOL;
    }

    echo "==============================" . PHP_EOL;
    echo "Produtos cadastrados: " . count($produtos) . PHP_EOL;
    echo "Unidades em estoque: {$totalUnidades}" . PHP_EOL;
    echo "Valor do estoque: R$ " . number_format($valorTotalEstoque, 2, ',', '.') . PHP_EOL;
    echo "Produto mais caro: {$maisCaro['nome']} (R$ " . number_format($maisCaro['preco'], 2, ',', '.') . ")" . PHP_EOL;

    echo PHP_EOL . "PRODUTOS COM ESTOQUE BAIXO (< 5 UN)" . PHP_EOL;
    if (!empty($estoqueBaixo)) {
        foreach ($estoqueBaixo as $item) {
            echo "• {$item['nome']} ({$item['quantidade']} UN)" . PHP_EOL;
        }
    } else {
        echo "Nenhum produto com estoque baixo." . PHP_EOL;
    }

    echo PHP_EOL . "PRODUTOS ACIMA DE R$ 100,00" . PHP_EOL;
    if (!empty($produtosCaros)) {
        foreach ($produtosCaros as $item) {
            echo "• {$item['nome']} (R$ " . number_format($item['preco'], 2, ',', '.') . ")" . PHP_EOL;
        }
    } else {
        echo "Nenhum produto acima de R$ 100,00." . PHP_EOL;
    }

    echo "==============================" . PHP_EOL;
}

// --- PROGRAMA PRINCIPAL ---

$produtos = cadastrarProdutos();

$totalUnidades = calcularTotalUnidades($produtos);
$valorTotalEstoque = calcularValorTotalEstoque($produtos);
$maisCaro = buscarProdutoMaisCaro($produtos);
$estoqueBaixo = buscarEstoqueBaixo($produtos);
$produtosCaros = buscarProdutosCaros($produtos);

gerarRelatorio(
    $produtos, 
    $totalUnidades, 
    $valorTotalEstoque, 
    $maisCaro, 
    $estoqueBaixo, 
    $produtosCaros
);
?>