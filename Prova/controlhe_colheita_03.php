<?php

/**
 * Gera um ID único para a colheita.
 */
function gerarIdColheita(): string {
    return "COL-" . date("Ymd") . "-" . rand(100, 999);
}

/**
 * Calcula o valor estimado da produção de uma cultura.
 */
function calcularValorProducao(float $qtdKg, float $valorKg): float {
    return $qtdKg * $valorKg;
}

/**
 * Classifica a produção com base no valor total da colheita.
 */
function classificarProducao(float $valorTotal): string {
    if ($valorTotal < 5000.00) {
        return "PRODUÇÃO DE PEQUENO PORTE";
    } elseif ($valorTotal <= 19999.99) {
        return "PRODUÇÃO DE MÉDIO PORTE";
    } else {
        return "PRODUÇÃO DE GRANDE PORTE";
    }
}

/**
 * Formata um valor numérico para o padrão de moeda R$ (duas casas decimais).
 */
function formatarMoeda(float $valor): string {
    return "R$ " . number_format($valor, 2, ',', '.');
}

/**
 * Formata a quantidade em kg com duas casas decimais.
 */
function formatarKg(float $qtd): string {
    return number_format($qtd, 2, ',', '.') . " kg";
}

// -----------------------------------------------------------------------------
// EXECUÇÃO PRINCIPAL DO SISTEMA
// -----------------------------------------------------------------------------

echo "=== REGISTRO DE COLHEITA ===" . PHP_EOL . PHP_EOL;

// Dados Iniciais
$idColheita = gerarIdColheita();
$dataAtual = date("d/m/Y");

echo "ID da Colheita: $idColheita" . PHP_EOL;
echo "Data do Registro: $dataAtual" . PHP_EOL;

echo "Informe o nome do responsável pelo lançamento: ";
$responsavel = trim(readline());

// Validação para garantir que a quantidade de culturas seja maior que 0
do {
    echo "Quantas culturas serão registradas? ";
    $qtdCulturas = (int) readline();
    
    if ($qtdCulturas <= 0) {
        echo "-> ERRO: O número de culturas deve ser maior que 0." . PHP_EOL;
    }
} while ($qtdCulturas <= 0);

$culturasValidas = [];
$totalKgAcumulado = 0.0;
$valorTotalAcumulado = 0.0;

// Laço para entrada e validação de cada cultura
for ($i = 1; $i <= $qtdCulturas; $i++) {
    echo PHP_EOL . "--- Cultura $i de $qtdCulturas ---" . PHP_EOL;
    
    echo "Nome da cultura: ";
    $nomeCultura = trim(readline());
    
    // Validação da Quantidade (deve ser maior que zero)
    do {
        echo "Quantidade produzida (em kg): ";
        $qtdKg = (float) readline();
        if ($qtdKg <= 0) {
            echo "-> ERRO: A quantidade deve ser um valor positivo maior que 0." . PHP_EOL;
        }
    } while ($qtdKg <= 0);
    
    // Validação do Valor por kg (deve ser maior que zero)
    do {
        echo "Valor estimado por kg (R$): ";
        $valorKg = (float) readline();
        if ($valorKg <= 0) {
            echo "-> ERRO: O valor por kg deve ser um valor positivo maior que 0." . PHP_EOL;
        }
    } while ($valorKg <= 0);
    
    $valorProducao = calcularValorProducao($qtdKg, $valorKg);
    
    // Armazena os dados da cultura válida
    $culturasValidas[] = [
        'nome' => $nomeCultura,
        'qtd' => $qtdKg,
        'valor_kg' => $valorKg,
        'valor_total' => $valorProducao
    ];
    
    // Acumula os totais
    $totalKgAcumulado += $qtdKg;
    $valorTotalAcumulado += $valorProducao;
    
    echo "-> Cultura '$nomeCultura' cadastrada com sucesso!" . PHP_EOL;
}

// -----------------------------------------------------------------------------
// EXIBIÇÃO DO RELATÓRIO FINAL
// -----------------------------------------------------------------------------

echo PHP_EOL . "==========================================" . PHP_EOL;
echo "               RELATÓRIO FINAL               " . PHP_EOL;
echo "==========================================" . PHP_EOL;

echo "CULTURAS REGISTRADAS:" . PHP_EOL;

if (count($culturasValidas) === 0) {
    echo "Nenhuma cultura válida foi registrada." . PHP_EOL;
} else {
    foreach ($culturasValidas as $item) {
        echo sprintf(
            "- %s | Qtd: %s | Valor/kg: %s | Total: %s" . PHP_EOL,
            $item['nome'],
            formatarKg($item['qtd']),
            formatarMoeda($item['valor_kg']),
            formatarMoeda($item['valor_total'])
        );
    }
}

echo PHP_EOL . "--- RESUMO GERAL ---" . PHP_EOL;
echo "Código da Colheita: " . $idColheita . PHP_EOL;
echo "Data: " . $dataAtual . PHP_EOL;
echo "Responsável: " . $responsavel . PHP_EOL;
echo "Culturas Válidas: " . count($culturasValidas) . PHP_EOL;
echo "Quantidade Total Produzida: " . formatarKg($totalKgAcumulado) . PHP_EOL;
echo "Valor Estimado Total: " . formatarMoeda($valorTotalAcumulado) . PHP_EOL;
echo "Classificação: " . classificarProducao($valorTotalAcumulado) . PHP_EOL;
echo "==========================================" . PHP_EOL;
