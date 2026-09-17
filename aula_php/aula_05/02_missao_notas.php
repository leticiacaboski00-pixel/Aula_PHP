<?php
// Função responsável por cadastrar 5 notas no array
function cadastrarNotas(): array {
    $notas = [];
    
    for ($i = 1; $i <= 5; $i++) {
        echo "Digite a $iª nota: ";
        $nota = (float) readline();
        $notas[] = $nota;
    }
    
    return $notas;
}

// Função responsável por listar todas as notas informadas
function listarNotas(array $notas): void {
    echo PHP_EOL . "--- NOTAS CADASTRADAS ---" . PHP_EOL;
    
    foreach ($notas as $index => $nota) {
        $num = $index + 1;
        echo "Nota $num: " . number_format($nota, 2, ',', '.') . PHP_EOL;
    }
}

// Função que calcula a soma e a média utilizando foreach
function calcularMedia(array $notas): array {
    $soma = 0.0;
    
    // Percorre o array de notas usando foreach para calcular o total acumulado
    foreach ($notas as $nota) {
        $soma += $nota;
    }
    
    $quantidade = count($notas);
    $media = $quantidade > 0 ? $soma / $quantidade : 0.0;

    return [
        'soma' => $soma,
        'media' => $media,
        'quantidade' => $quantidade
    ];
}

// Função responsável por retornar a situação geral da turma
function mostrarSituacao(float $media): string {
    if ($media >= 7.0) {
        return "Bom desempenho";
    }
    return "Turma precisa melhorar";
}

// --- EXECUÇÃO DO PROGRAMA ---

// 1. Cadastrar as notas
$notas = cadastrarNotas();

// 2. Listar todas as notas cadastradas
listarNotas($notas);

// 3. Processar cálculos (Soma, Média e Quantidade)
$dadosNotas = calcularMedia($notas);

// 4. Determinar a situação da turma
$situacao = mostrarSituacao($dadosNotas['media']);

// Exibição do relatório final
echo "------------------------------" . PHP_EOL;
echo "Quantidade de notas : " . $dadosNotas['quantidade'] . PHP_EOL;
echo "Soma das notas      : " . number_format($dadosNotas['soma'], 2, ',', '.') . PHP_EOL;
echo "Média da turma      : " . number_format($dadosNotas['media'], 2, ',', '.') . PHP_EOL;
echo "Situação geral      : $situacao" . PHP_EOL;
echo "------------------------------" . PHP_EOL;
?>