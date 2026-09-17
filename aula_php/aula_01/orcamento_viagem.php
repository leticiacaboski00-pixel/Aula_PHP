<?php

// --- ENTRADA DE DADOS ---

echo "==========================================" . PHP_EOL;
echo "               SENAC TOUR                 " . PHP_EOL;
echo "     SISTEMA DE ORÇAMENTO DE VIAGEM       " . PHP_EOL;
echo "==========================================" . PHP_EOL . PHP_EOL;

echo "Nome do Cliente: ";
$cliente = readline();

echo "Cidade de Origem: ";
$origem = readline();

echo "Cidade de Destino: ";
$destino = readline();

echo "Quantidade de viajantes: ";
$qtdViajantes = (int) readline();

echo "Quantidade de dias da viagem: ";
$qtdDias = (int) readline();

echo PHP_EOL . "--- VALORES DA VIAGEM ---" . PHP_EOL;

echo "Valor da passagem por pessoa (R$): ";
$valorPassagem = (float) readline();

echo "Valor da diária de hospedagem (R$): ";
$valorDiaria = (float) readline();

echo "Estimativa diária de alimentação POR pessoa (R$): ";
$valorAlimentacaoDia = (float) readline();

echo "Estimativa diária de transporte local TOTAL (R$): ";
$valorTransporteDia = (float) readline();

echo "Valor do passeio turístico por pessoa (R$): ";
$valorPasseio = (float) readline();


// --- PROCESSAMENTO (CÁLCULOS) ---

$totalPassagens   = $valorPassagem * $qtdViajantes;
$totalHospedagem  = $valorDiaria * $qtdDias;
$totalAlimentacao = $valorAlimentacaoDia * $qtdDias * $qtdViajantes;
$totalTransporte  = $valorTransporteDia * $qtdDias;
$totalPasseios    = $valorPasseio * $qtdViajantes;

$totalViagem      = $totalPassagens + $totalHospedagem + $totalAlimentacao + $totalTransporte + $totalPasseios;
$valorPorViajante = $qtdViajantes > 0 ? ($totalViagem / $qtdViajantes) : 0;

$numOrcamento     = rand(1000, 9999);
$dataAtual        = date('d/m/Y');


// --- SAÍDA DE DADOS (ORÇAMENTO FORMATADO) ---

echo PHP_EOL;
echo "==========================================" . PHP_EOL;
echo "            ORÇAMENTO DE VIAGEM           " . PHP_EOL;
echo "               SENAC TOUR                 " . PHP_EOL;
echo "==========================================" . PHP_EOL;
echo "Número do Orçamento : #{$numOrcamento}" . PHP_EOL;
echo "Data de Emissão     : {$dataAtual}" . PHP_EOL;
echo "------------------------------------------" . PHP_EOL;
echo "CLIENTE / TRAJETO:" . PHP_EOL;
echo "Cliente    : {$cliente}" . PHP_EOL;
echo "Trajeto    : {$origem} -> {$destino}" . PHP_EOL;
echo "Viajantes  : {$qtdViajantes} pessoa(s)" . PHP_EOL;
echo "Duração    : {$qtdDias} dia(s)" . PHP_EOL;
echo "------------------------------------------" . PHP_EOL;
echo "DETALHAMENTO DOS CUSTOS:" . PHP_EOL;
echo "• Passagens    : R$ " . number_format($totalPassagens, 2, ',', '.') . PHP_EOL;
echo "• Hospedagem   : R$ " . number_format($totalHospedagem, 2, ',', '.') . PHP_EOL;
echo "• Alimentação  : R$ " . number_format($totalAlimentacao, 2, ',', '.') . PHP_EOL;
echo "• Transporte   : R$ " . number_format($totalTransporte, 2, ',', '.') . PHP_EOL;
echo "• Passeios     : R$ " . number_format($totalPasseios, 2, ',', '.') . PHP_EOL;
echo "------------------------------------------" . PHP_EOL;
echo "TOTAL DA VIAGEM     : R$ " . number_format($totalViagem, 2, ',', '.') . PHP_EOL;
echo "VALOR POR VIAJANTE  : R$ " . number_format($valorPorViajante, 2, ',', '.') . PHP_EOL;
echo "==========================================" . PHP_EOL;

?>
