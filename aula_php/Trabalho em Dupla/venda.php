<?php

/**
 * Aplicação de Ponto de Venda (PDV) - SENAC Market
 * Execução via Terminal (CLI)
 */

date_default_timezone_set('America/Sao_Paulo');

// ==========================================
// 1. FUNÇÕES AUXILIARES E LEITURA DE ENTRADAS
// ==========================================

function lerTexto(string $mensagem): string {
    echo $mensagem;
    return trim(fgets(STDIN));
}

function converterEValidarNumero(string $entrada): ?float {
    $limpo = str_replace(',', '.', $entrada);
    if (is_numeric($limpo)) {
        return (float) $limpo;
    }
    return null;
}

function lerInteiroValido(string $mensagem): int {
    while (true) {
        $input = lerTexto($mensagem);
        if (ctype_digit($input) && (int)$input > 0) {
            return (int)$input;
        }
        echo "   [!] Entrada inválida. Digite um número inteiro maior que zero.\n";
    }
}

// ==========================================
// 2. FUNÇÕES DE CADASTRO E ENTRADA DE DADOS
// ==========================================

function gerarIdVenda(): string {
    return "VND-" . date('YmdHis') . "-" . rand(100, 999);
}

function obterDataHoraAtual(): string {
    return date('d/m/Y H:i:s');
}

function cadastrarCliente(): array {
    echo "\n=== CADASTRO DE CLIENTE ===\n";
    $nome = lerTexto("Nome do cliente: ");
    $idade = lerInteiroValido("Idade do cliente: ");

    while (true) {
        $tipoStr = strtolower(lerTexto("Tipo de cliente (1 - Comum / 2 - Premium): "));
        if ($tipoStr === '1' || $tipoStr === 'comum') {
            $tipo = 'comum';
            break;
        } elseif ($tipoStr === '2' || $tipoStr === 'premium') {
            $tipo = 'premium';
            break;
        }
        echo "   [!] Opção inválida. Digite 1 (Comum) ou 2 (Premium).\n";
    }

    return [
        'nome' => $nome,
        'idade' => $idade,
        'tipo' => $tipo
    ];
}

function validarProduto(float $preco, float $quantidade): bool {
    return ($preco > 0 && $quantidade > 0);
}

function cadastrarProdutos(): array {
    echo "\n=== CADASTRO DE PRODUTOS ===\n";
    
    // Pergunta a quantidade de produtos a cadastrar
    $qtdProdutos = lerInteiroValido("Quantos produtos deseja cadastrar nesta venda? ");
    echo "\n";

    $produtos = [];

    for ($i = 1; $i <= $qtdProdutos; $i++) {
        echo "--- Produto #{$i} de {$qtdProdutos} ---\n";
        $nome = lerTexto("Nome do produto: ");

        if (empty($nome)) {
            echo "   [!] Nome do produto não pode ser vazio. Registro desconsiderado.\n\n";
            continue;
        }

        $categoria = lerTexto("Categoria: ");

        $precoInput = lerTexto("Preço unitário (R$): ");
        $preco = converterEValidarNumero($precoInput) ?? 0.0;

        $qtdInput = lerTexto("Quantidade: ");
        $quantidade = converterEValidarNumero($qtdInput) ?? 0.0;

        // Validação dos valores
        if (!validarProduto($preco, $quantidade)) {
            echo "   [!] ERRO: Preço ou quantidade inválidos. Produto desconsiderado.\n\n";
            continue;
        }

        $produtos[] = [
            'nome' => $nome,
            'categoria' => $categoria,
            'preco_unitario' => $preco,
            'quantidade' => $quantidade,
            'subtotal' => calcularSubtotalItem($preco, $quantidade)
        ];

        echo "   [V] Produto registrado com sucesso!\n\n";
    }

    return $produtos;
}

function selecionarFormaPagamento(): array {
    echo "\n=== FORMA DE PAGAMENTO ===\n";
    echo "1. PIX\n2. Cartão\n3. Dinheiro\n";
    
    while (true) {
        $opcao = strtolower(lerTexto("Escolha a opção (1-3 ou nome): "));

        if ($opcao === '1' || $opcao === 'pix') {
            return ['tipo' => 'pix', 'parcelas' => 1];
        } elseif ($opcao === '2' || $opcao === 'cartao' || $opcao === 'cartão') {
            while (true) {
                $parcelas = lerInteiroValido("Quantidade de parcelas (1 a 6): ");
                if ($parcelas >= 1 && $parcelas <= 6) {
                    return ['tipo' => 'cartao', 'parcelas' => $parcelas];
                }
                echo "   [!] O número de parcelas deve ser entre 1 e 6.\n";
            }
        } elseif ($opcao === '3' || $opcao === 'dinheiro') {
            return ['tipo' => 'dinheiro', 'parcelas' => 1];
        }
        echo "   [!] Opção inválida. Escolha pix, cartao ou dinheiro.\n";
    }
}

// ==========================================
// 3. FUNÇÕES DE CÁLCULO E REGRAS DE NEGÓCIO
// ==========================================

function calcularSubtotalItem(float $preco, float $quantidade): float {
    return $preco * $quantidade;
}

function analisarProdutos(array $produtos): array {
    if (empty($produtos)) {
        return [
            'total_diferentes' => 0,
            'total_unidades' => 0,
            'valor_bruto' => 0.0,
            'mais_caro' => null,
            'mais_barato' => null
        ];
    }

    $totalUnidades = 0;
    $valorBruto = 0.0;
    $maisCaro = $produtos[0];
    $maisBarato = $produtos[0];

    foreach ($produtos as $p) {
        $totalUnidades += $p['quantidade'];
        $valorBruto += $p['subtotal'];

        if ($p['preco_unitario'] > $maisCaro['preco_unitario']) {
            $maisCaro = $p;
        }

        if ($p['preco_unitario'] < $maisBarato['preco_unitario']) {
            $maisBarato = $p;
        }
    }

    return [
        'total_diferentes' => count($produtos),
        'total_unidades' => $totalUnidades,
        'valor_bruto' => $valorBruto,
        'mais_caro' => $maisCaro,
        'mais_barato' => $maisBarato
    ];
}

function calcularDescontoValorBruto(float $valorBruto): float {
    if ($valorBruto >= 1000.00) return 15.0;
    if ($valorBruto >= 500.00) return 10.0;
    if ($valorBruto >= 200.00) return 5.0;
    return 0.0;
}

function calcularPercentualDescontoTotal(float $valorBruto, array $cliente, string $formaPagamento): float {
    $percentual = calcularDescontoValorBruto($valorBruto);

    if ($cliente['tipo'] === 'premium') {
        $percentual += 3.0;
    }

    if ($formaPagamento === 'pix') {
        $percentual += 2.0;
    }

    if ($cliente['idade'] >= 60) {
        $percentual += 2.0;
    }

    return $percentual;
}

function classificarVenda(float $valorFinal): string {
    if ($valorFinal < 300.00) {
        return "VENDA PEQUENA";
    } elseif ($valorFinal < 1000.00) {
        return "VENDA MÉDIA";
    }
    return "VENDA DE ALTO VALOR";
}

// ==========================================
// 4. FUNÇÕES DE SAÍDA E EXIBIÇÃO
// ==========================================

function formatarMoeda(float $valor): string {
    return "R$ " . number_format($valor, 2, ',', '.');
}

function simularParcelasCartao(float $valorFinal): void {
    echo "\n--- Simulação de Parcelamento (Cartão) ---\n";
    for ($i = 1; $i <= 6; $i++) {
        $valorParcela = $valorFinal / $i;
        printf(" %dx de %s (Total: %s)\n", $i, formatarMoeda($valorParcela), formatarMoeda($valorFinal));
    }
    echo "------------------------------------------\n";
}

function exibirComprovante(array $venda, array $cliente, array $produtos, array $totais): void {
    echo "\n==========================================================\n";
    echo "                     SENAC MARKET                         \n";
    echo "                 COMPROVANTE DE VENDA                     \n";
    echo "==========================================================\n";
    echo "ID Venda : {$venda['id']}\n";
    echo "Data/Hora: {$venda['data']}\n";
    echo "----------------------------------------------------------\n";
    echo "CLIENTE: {$cliente['nome']} | Idade: {$cliente['idade']} | Tipo: " . ucfirst($cliente['tipo']) . "\n";
    echo "----------------------------------------------------------\n";
    echo sprintf("%-20s %-12s %-10s %-6s %-10s\n", "PRODUTO", "CATEGORIA", "PREÇO", "QTD", "SUBTOTAL");
    echo "----------------------------------------------------------\n";

    foreach ($produtos as $p) {
        printf(
            "%-20s %-12s %-10s %-6.2f %-10s\n",
            substr($p['nome'], 0, 19),
            substr($p['categoria'], 0, 11),
            formatarMoeda($p['preco_unitario']),
            $p['quantidade'],
            formatarMoeda($p['subtotal'])
        );
    }

    echo "----------------------------------------------------------\n";
    printf("Forma de Pagamento: %s (%dx)\n", strtoupper($venda['pagamento']['tipo']), $venda['pagamento']['parcelas']);
    printf("Valor Bruto       : %s\n", formatarMoeda($totais['valor_bruto']));
    printf("Desconto (%g%%)   : %s\n", $venda['percentual_desconto'], formatarMoeda($venda['valor_desconto']));
    printf("VALOR FINAL       : %s\n", formatarMoeda($venda['valor_final']));
    echo "==========================================================\n";
}

function exibirRelatorioGerencial(array $totais, array $venda): void {
    echo "\n==========================================================\n";
    echo "                   RELATÓRIO GERENCIAL                    \n";
    echo "==========================================================\n";
    echo "Produtos Diferentes     : {$totais['total_diferentes']}\n";
    printf("Total de Unidades       : %.2f\n", $totais['total_unidades']);
    echo "Produto Mais Caro       : " . ($totais['mais_caro'] ? $totais['mais_caro']['nome'] . " (" . formatarMoeda($totais['mais_caro']['preco_unitario']) . ")" : 'N/A') . "\n";
    echo "Produto Mais Barato     : " . ($totais['mais_barato'] ? $totais['mais_barato']['nome'] . " (" . formatarMoeda($totais['mais_barato']['preco_unitario']) . ")" : 'N/A') . "\n";
    printf("Valor Bruto             : %s\n", formatarMoeda($totais['valor_bruto']));
    printf("Percentual de Desconto  : %g%%\n", $venda['percentual_desconto']);
    printf("Valor do Desconto       : %s\n", formatarMoeda($venda['valor_desconto']));
    printf("Valor Final Recebido    : %s\n", formatarMoeda($venda['valor_final']));
    echo "Classificação da Venda  : " . classificarVenda($venda['valor_final']) . "\n";
    echo "==========================================================\n\n";
}

// ==========================================
// 5. ORQUESTRAÇÃO E EXECUÇÃO
// ==========================================

function executarVenda(): void {
    echo "==========================================================\n";
    echo "            SISTEMA DE VENDAS - SENAC MARKET              \n";
    echo "==========================================================\n";

    $idVenda = gerarIdVenda();
    $dataAtual = obterDataHoraAtual();
    $cliente = cadastrarCliente();
    $produtos = cadastrarProdutos();

    if (empty($produtos)) {
        echo "\n[!] Nenhum produto válido foi cadastrado. A venda foi cancelada.\n";
        return;
    }

    $totais = analisarProdutos($produtos);
    $pagamento = selecionarFormaPagamento();

    $percentualDesconto = calcularPercentualDescontoTotal($totais['valor_bruto'], $cliente, $pagamento['tipo']);
    $valorDesconto = $totais['valor_bruto'] * ($percentualDesconto / 100);
    $valorFinal = $totais['valor_bruto'] - $valorDesconto;

    $venda = [
        'id' => $idVenda,
        'data' => $dataAtual,
        'pagamento' => $pagamento,
        'percentual_desconto' => $percentualDesconto,
        'valor_desconto' => $valorDesconto,
        'valor_final' => $valorFinal
    ];

    if ($pagamento['tipo'] === 'cartao') {
        simularParcelasCartao($valorFinal);
    }

    exibirComprovante($venda, $cliente, $produtos, $totais);
    exibirRelatorioGerencial($totais, $venda);
}

function iniciarSistema(): void {
    while (true) {
        executarVenda();
        $opcao = strtolower(lerTexto("Deseja registrar outra venda? (S/N): "));
        if ($opcao !== 's' && $opcao !== 'sim') {
            echo "\nEncerrando o sistema SENAC Market. Até logo!\n";
            break;
        }
        echo "\n\n";
    }
}

// Inicializa a aplicação
iniciarSistema();