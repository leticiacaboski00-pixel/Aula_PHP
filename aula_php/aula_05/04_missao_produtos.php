<?php
// Função responsável por cadastrar os 5 produtos no array
function cadastrarProdutos(): array {
    $produtos = [];

    for ($i = 1; $i <= 5; $i++) {
        echo "--- Cadastro do Produto $i ---" . PHP_EOL;

        echo "Nome: ";
        $nome = readline();

        echo "Preço (R$): ";
        $preco = (float) readline();

        // Estrutura do array associativo individual
        $produto = [
            "nome" => $nome,
            "preco" => $preco
        ];

        // Adiciona o produto ao array principal
        $produtos[] = $produto;
        echo PHP_EOL;
    }

    return $produtos;
}

// Função responsável por listar todos os produtos
function listarProdutos(array $produtos): void {
    echo "==========================================" . PHP_EOL;
    echo "          CATÁLOGO DE PRODUTOS            " . PHP_EOL;
    echo "==========================================" . PHP_EOL;

    foreach ($produtos as $index => $produto) {
        $num = $index + 1;
        $precoFormatado = number_format($produto['preco'], 2, ',', '.');
        echo "Item $num: {$produto['nome']} - R$ $precoFormatado" . PHP_EOL;
    }
}

// Função responsável por calcular a soma total dos preços usando foreach
function calcularTotal(array $produtos): float {
    $soma = 0.0;
    foreach ($produtos as $produto) {
        $soma += $produto['preco'];
    }
    return $soma;
}

// Função responsável por calcular o preço médio dos produtos
function calcularMedia(array $produtos): float {
    $quantidade = count($produtos);
    if ($quantidade === 0) {
        return 0.0;
    }
    $total = calcularTotal($produtos);
    return $total / $quantidade;
}

// Função responsável por listar apenas os produtos que custam R$ 100 ou mais usando foreach
function listarProdutosCaros(array $produtos): void {
    echo "------------------------------------------" . PHP_EOL;
    echo "  PRODUTOS DE R$ 100,00 OU MAIS (VIP)     " . PHP_EOL;
    echo "------------------------------------------" . PHP_EOL;

    $encontrou = false;
    foreach ($produtos as $produto) {
        if ($produto['preco'] >= 100.0) {
            $precoFormatado = number_format($produto['preco'], 2, ',', '.');
            echo "• {$produto['nome']} - R$ $precoFormatado" . PHP_EOL;
            $encontrou = true;
        }
    }

    if (!$encontrou) {
        echo "Nenhum produto cadastrado possui valor maior ou igual a R$ 100,00." . PHP_EOL;
    }
}

// --- EXECUÇÃO DO PROGRAMA ---

// 1. Cadastrar produtos
$produtos = cadastrarProdutos();

// 2. Listar catálogo
listarProdutos($produtos);

// 3. Processar métricas financeiras
$quantidadeTotal = count($produtos);
$somaTotal = calcularTotal($produtos);
$precoMedio = calcularMedia($produtos);

// 4. Exibir dados estatísticos
echo "------------------------------------------" . PHP_EOL;
echo "Quantidade de produtos: $quantidadeTotal" . PHP_EOL;
echo "Soma dos preços       : R$ " . number_format($somaTotal, 2, ',', '.') . PHP_EOL;
echo "Preço médio           : R$ " . number_format($precoMedio, 2, ',', '.') . PHP_EOL;

// 5. Listar os produtos com preço igual ou superior a R$ 100
listarProdutosCaros($produtos);
echo "==========================================" . PHP_EOL;
?>