<?php

// Configura o fuso horário padrão para obter a data correta
date_default_timezone_set('America_Sao_Paulo');

function formatarMoeda(float $valor): string {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

function lerEntrada(string $mensagem): string {
    echo $mensagem;
    return trim(fgets(STDIN));
}

// RF01 — Identificação do orçamento
$numeroOrcamento = str_pad((string)rand(1, 9999), 4, '0', STR_PAD_LEFT);
$dataAtual = date('d/m/Y');

echo "==================================================\n";
echo "   AUTOTECH SERVIÇOS AUTOMOTIVOS - NOVO ORÇAMENTO   \n";
echo "==================================================\n\n";

// RF02 — Dados do cliente
echo "--- DADOS DO CLIENTE ---\n";
$nomeCliente = lerEntrada("Nome do cliente: ");
$telefoneCliente = lerEntrada("Telefone: ");

// RF03 — Dados do veículo
echo "\n--- DADOS DO VEÍCULO ---\n";
$marcaVeiculo = lerEntrada("Marca do veículo: ");
$modeloVeiculo = lerEntrada("Modelo do veículo: ");
$anoVeiculo = lerEntrada("Ano: ");
$placaVeiculo = lerEntrada("Placa: ");
$kmVeiculo = lerEntrada("Quilometragem atual: ");

// RF04 — Serviço
echo "\n--- DADOS DO SERVIÇO ---\n";
$descricaoServico = lerEntrada("Descrição do serviço: ");
$valorHora = (float) lerEntrada("Valor da hora de mão de obra (R$): ");
$qtdHoras = (float) lerEntrada("Quantidade de horas previstas: ");

// RF05 — Peças
echo "\n--- DADOS DA PEÇA ---\n";
$nomePeca = lerEntrada("Nome da peça: ");
$valorUnitarioPeca = (float) lerEntrada("Valor unitário da peça (R$): ");
$qtdPecas = (int) lerEntrada("Quantidade necessária: ");

// RF06 — Materiais adicionais
echo "\n--- MATERIAIS ADICIONAIS ---\n";
$materiaisAdicionais = (float) lerEntrada("Estimativa para materiais adicionais (R$): ");

// --- CÁLCULOS PRINCIPAIS ---
$totalMaoDeObra = $valorHora * $qtdHoras;
$totalPecas = $valorUnitarioPeca * $qtdPecas;
$valorTotal = $totalMaoDeObra + $totalPecas + $materiaisAdicionais;

// --- OPÇÃO DE PARCELAMENTO ---
echo "\n--- PAGAMENTO ---\n";
$desejaParcelar = strtolower(lerEntrada("Deseja parcelar o valor? (s/n): "));

$qtdParcelas = 1;
$valorParcela = $valorTotal;

if ($desejaParcelar === 's' || $desejaParcelar === 'sim') {
    $qtdParcelas = (int) lerEntrada("Em quantas parcelas deseja dividir? (Ex: 3): ");
    if ($qtdParcelas < 1) {
        $qtdParcelas = 1;
    }
    $valorParcela = $valorTotal / $qtdParcelas;
}

// RF08 — Comprovante
echo "\n\n";
echo "==================================================\n";
echo "           COMPROVANTE DE ORÇAMENTO               \n";
echo "         AUTOTECH SERVIÇOS AUTOMOTIVOS            \n";
echo "==================================================\n";
echo "Orçamento Nº: {$numeroOrcamento}   | Data: {$dataAtual}\n";
echo "--------------------------------------------------\n";
echo "CLIENTE\n";
echo "Nome: {$nomeCliente}\n";
echo "Telefone: {$telefoneCliente}\n";
echo "--------------------------------------------------\n";
echo "VEÍCULO\n";
echo "Veículo: {$marcaVeiculo} {$modeloVeiculo} | Ano: {$anoVeiculo}\n";
echo "Placa: {$placaVeiculo} | KM: {$kmVeiculo}\n";
echo "--------------------------------------------------\n";
echo "SERVIÇO & CUSTOS\n";
echo "Descrição: {$descricaoServico}\n";
echo "Mão de Obra ({$qtdHoras}h x " . formatarMoeda($valorHora) . "): " . formatarMoeda($totalMaoDeObra) . "\n";
echo "Peça ({$nomePeca} - {$qtdPecas}x " . formatarMoeda($valorUnitarioPeca) . "): " . formatarMoeda($totalPecas) . "\n";
echo "Materiais Adicionais: " . formatarMoeda($materiaisAdicionais) . "\n";
echo "--------------------------------------------------\n";
echo "RESUMO FINANCEIRO\n";
echo "VALOR TOTAL ESTIMADO: " . formatarMoeda($valorTotal) . "\n";

if ($qtdParcelas > 1) {
    echo "FORMA DE PAGAMENTO: Parcelado em {$qtdParcelas}x de " . formatarMoeda($valorParcela) . "\n";
} else {
    echo "FORMA DE PAGAMENTO: À vista (" . formatarMoeda($valorTotal) . ")\n";
}

echo "==================================================\n";