<?php
// Função responsável por cadastrar as movimentações bancárias
function cadastrarMovimentacoes(): array {
    $movimentacoes = [];

    echo "Quantas movimentações deseja registrar? ";
    $qtd = (int) readline();

    for ($i = 1; $i <= $qtd; $i++) {
        echo PHP_EOL . "--- Movimentação $i ---" . PHP_EOL;

        echo "Digite o tipo (deposito ou saque): ";
        $tipoInput = readline();
        $tipo = strtolower(trim($tipoInput));

        // Validação simples do tipo de movimentação
        if ($tipo !== "deposito" && $tipo !== "saque") {
            echo "Tipo inválido! Considerando como 'deposito'." . PHP_EOL;
            $tipo = "deposito";
        }

        echo "Digite o valor (R$): ";
        $valor = (float) readline();

        if ($valor <= 0) {
            echo "Valor deve ser maior que zero. Operação desconsiderada." . PHP_EOL;
            continue;
        }

        $movimentacoes[] = [
            "tipo" => $tipo,
            "valor" => $valor
        ];
    }

    return $movimentacoes;
}

// Função responsável por calcular o total acumulado de depósitos usando foreach
function calcularDepositos(array $movimentacoes): float {
    $totalDepositos = 0.0;
    foreach ($movimentacoes as $mov) {
        if ($mov['tipo'] === 'deposito') {
            $totalDepositos += $mov['valor'];
        }
    }
    return $totalDepositos;
}

// Função responsável por calcular o total acumulado de saques usando foreach
function calcularSaques(array $movimentacoes): float {
    $totalSaques = 0.0;
    foreach ($movimentacoes as $mov) {
        if ($mov['tipo'] === 'saque') {
            $totalSaques += $mov['valor'];
        }
    }
    return $totalSaques;
}

// Função responsável por calcular o saldo final (Depósitos - Saques)
function calcularSaldo(array $movimentacoes): float {
    return calcularDepositos($movimentacoes) - calcularSaques($movimentacoes);
}

// Função responsável por exibir o extrato bancário completo
function listarExtrato(array $movimentacoes): void {
    echo "==========================================" . PHP_EOL;
    echo "             EXTRATO BANCÁRIO             " . PHP_EOL;
    echo "==========================================" . PHP_EOL;

    foreach ($movimentacoes as $index => $mov) {
        $num = $index + 1;
        $tipoFormatado = strtoupper($mov['tipo']);
        $valorFormatado = number_format($mov['valor'], 2, ',', '.');
        
        $sinal = ($mov['tipo'] === 'deposito') ? "(+)" : "(-)";
        echo "Item $num: [$tipoFormatado] $sinal R$ $valorFormatado" . PHP_EOL;
    }

    $totalDepositos = calcularDepositos($movimentacoes);
    $totalSaques = calcularSaques($movimentacoes);
    $saldoFinal = calcularSaldo($movimentacoes);

    echo "------------------------------------------" . PHP_EOL;
    echo "Total Depositado : R$ " . number_format($totalDepositos, 2, ',', '.') . PHP_EOL;
    echo "Total Sacado     : R$ " . number_format($totalSaques, 2, ',', '.') . PHP_EOL;
    echo "------------------------------------------" . PHP_EOL;
    echo "SALDO FINAL      : R$ " . number_format($saldoFinal, 2, ',', '.') . PHP_EOL;
    echo "==========================================" . PHP_EOL;
}

// --- EXECUÇÃO DO PROGRAMA ---

// 1. Cadastrar movimentações
$movimentacoes = cadastrarMovimentacoes();

// 2. Exibir o extrato detalhado e totais se houver movimentações
if (!empty($movimentacoes)) {
    echo PHP_EOL;
    listarExtrato($movimentacoes);
} else {
    echo PHP_EOL . "Nenhuma movimentação foi registrada." . PHP_EOL;
}
?>