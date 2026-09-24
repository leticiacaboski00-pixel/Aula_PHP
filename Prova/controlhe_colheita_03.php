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

echo "Quantas culturas serão registradas? ";
$qtdCulturas = (int) readline();

$culturasValidas = [];
$totalKgAcumulado = 0.0;
$valorTotalAcumulado = 0.0;

// Laço para entrada e validação de cada cultura
for ($i = 1; $i <= $qtdCulturas; $i++) {
    echo PHP_EOL . "--- Cultura $i de $qtdCulturas ---" . PHP_EOL;
    
    echo "Nome da cultura: ";
    $nomeCultura = trim(readline());
    
    echo "Quantidade produzida (em kg): ";
    $qtdKg = (float) readline();
    
    echo "Valor estimado por kg (R$): ";
    $valorKg = (float) readline();
    
    // Validação: Quantidade e Valor por kg devem ser maiores que zero
    if ($qtdKg > 0 && $valorKg > 0) {
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
    } else {
        // Registro inválido: notifica e continua o cadastro sem interromper
        echo "-> ERRO: Registro inválido! Quantidade e Valor por kg devem ser maiores que 0." . PHP_EOL;
        echo "   A cultura '$nomeCultura' foi ignorada nos cálculos." . PHP_EOL;
    }
}

// -----------------------------------------------------------------------------
// EXIBIÇÃO DO RELATÓRIO FINAL
// -----------------------------------------------------------------------------

echo PHP_EOL . "==========================================" . PHP_EOL;
echo "            RELATÓRIO FINAL               " . PHP_EOL;
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