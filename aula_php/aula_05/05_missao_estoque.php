<?php
// Função responsável por cadastrar os 5 produtos no array com nome, preço e quantidade
function cadastrarProdutos(): array {
    $produtos = [];

    for ($i = 1; $i <= 5; $i++) {
        echo "--- Cadastro do Produto $i ---" . PHP_EOL;

        echo "Nome: ";
        $nome = readline();

        echo "Preço (R$): ";
        $preco = (float) readline();

        echo "Quantidade: ";
        $quantidade = (int) readline();

        // Estrutura do array associativo individual
        $produto = [
            "nome" => $nome,
            "preco" => $preco,
            "quantidade" => $quantidade
        ];

        // Adiciona o produto ao array principal
        $produtos[] = $produto;
        echo PHP_EOL;
    }

    return $produtos;
}

// Função responsável por calcular o valor individual do estoque de um único produto (Preço × Quantidade)
function calcularValorProduto(array $produto): float {
    return $produto['preco'] * $produto['quantidade'];
}

// Função responsável por calcular o valor financeiro total de todo o estoque acumulado
function calcularValorEstoque(array $produtos): float {
    $totalEstoque = 0.0;
    foreach ($produtos as $produto) {
        $totalEstoque += calcularValorProduto($produto);
    }
    return $totalEstoque;
}

// Função responsável por percorrer os produtos e exibir a listagem do estoque com os valores
function listarEstoque(array $produtos): void {
    echo "==========================================" . PHP_EOL;
    echo "          RELATÓRIO DE ESTOQUE            " . PHP_EOL;
    echo "==========================================" . PHP_EOL;

    foreach ($produtos as $produto) {
        $valorProduto = calcularValorProduto($produto);

        echo "Produto: {$produto['nome']}" . PHP_EOL;
        echo "Preço: R$ " . number_format($produto['preco'], 2, ',', '.') . PHP_EOL;
        echo "Quantidade: {$produto['quantidade']}" . PHP_EOL;
        echo "Valor em estoque: R$ " . number_format($valorProduto, 2, ',', '.') . PHP_EOL;
        echo "------------------------------------------" . PHP_EOL;
    }

    $totalGeral = calcularValorEstoque($produtos);
    echo "VALOR TOTAL DO ESTOQUE: R$ " . number_format($totalGeral, 2, ',', '.') . PHP_EOL;
    echo "==========================================" . PHP_EOL;
}

// --- EXECUÇÃO DO PROGRAMA ---

// 1. Cadastrar os produtos
$produtos = cadastrarProdutos();

// 2. Exibir o relatório completo do estoque e o totalizador geral
listarEstoque($produtos);
?>