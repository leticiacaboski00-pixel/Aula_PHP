<?php
// Entrada de dados
echo "Digite o nome do aluno: ";
$nome = readline();

echo "Digite a primeira nota (0 a 10): ";
$nota1 = (float) readline();

echo "Digite a segunda nota (0 a 10): ";
$nota2 = (float) readline();

echo "Digite a frequência em % (0 a 100): ";
$frequencia = (float) readline();

// Validação dos dados de entrada
if ($nota1 < 0 || $nota1 > 10 || $nota2 < 0 || $nota2 > 10) {
    echo PHP_EOL . "Erro: As notas devem estar entre 0 e 10." . PHP_EOL;
} elseif ($frequencia < 0 || $frequencia > 100) {
    echo PHP_EOL . "Erro: A frequência deve estar entre 0 e 100%." . PHP_EOL;
} else {
    // Cálculo da média
    $media = ($nota1 + $nota2) / 2;
    $mediaFormatada = number_format($media, 2, ',', '.');
    
    // Definição da situação acadêmica
    // A frequência tem prioridade máxima nas regras
    if ($frequencia < 75) {
        $situacao = "REPROVADO POR FREQUÊNCIA";
    } elseif ($media >= 7) {
        $situacao = "APROVADO";
    } elseif ($media >= 4) {
        $situacao = "RECUPERAÇÃO";
    } else {
        $situacao = "REPROVADO POR NOTA";
    }

    // Exibição dos resultados formatados
    echo PHP_EOL;
    echo "--- BOLETIM ACADÊMICO ---" . PHP_EOL;
    echo "Aluno: $nome" . PHP_EOL;
    echo "Nota 1: " . number_format($nota1, 2, ',', '.') . PHP_EOL;
    echo "Nota 2: " . number_format($nota2, 2, ',', '.') . PHP_EOL;
    echo "Média: $mediaFormatada" . PHP_EOL;
    echo "Frequência: " . number_format($frequencia, 1, ',', '.') . "%" . PHP_EOL;
    echo "Situação: $situacao" . PHP_EOL;
}
?>
