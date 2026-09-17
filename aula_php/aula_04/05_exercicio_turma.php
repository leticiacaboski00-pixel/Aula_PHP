<?php
// Entrada do número de alunos
echo "Quantidade de alunos: ";
$qtdAlunos = (int) readline();

// Validação da quantidade de alunos
if ($qtdAlunos <= 0) {
    echo "Erro: A quantidade de alunos deve ser maior que zero." . PHP_EOL;
} else {
    // Variáveis acumuladoras e contadoras
    $somaNotas = 0.0;
    $aprovados = 0;
    $reprovados = 0;

    // Variáveis para armazenar a maior e a menor nota
    $maiorNota = 0.0;
    $menorNota = 0.0;

    // Leitura e análise dos dados de cada aluno
    for ($i = 1; $i <= $qtdAlunos; $i++) {
        echo PHP_EOL . "--- Aluno $i ---" . PHP_EOL;
        
        echo "Nome: ";
        $nome = readline();

        echo "Nota: ";
        $nota = (float) readline();

        // Acumula a nota para a média
        $somaNotas += $nota;

        // Contagem de aprovados e reprovados
        if ($nota >= 7.0) {
            $aprovados++;
        } else {
            $reprovados++;
        }

        // Lógica para identificar a maior e a menor nota
        if ($i === 1) {
            // Na primeira repetição, a nota do primeiro aluno é a maior e a menor por padrão
            $maiorNota = $nota;
            $menorNota = $nota;
        } else {
            if ($nota > $maiorNota) {
                $maiorNota = $nota;
            }
            if ($nota < $menorNota) {
                $menorNota = $nota;
            }
        }
    }

    // Cálculo da média geral da turma
    $mediaTurma = $somaNotas / $qtdAlunos;

    // Exibição do relatório final
    echo PHP_EOL . "==========================================" . PHP_EOL;
    echo "         RELATÓRIO FINAL DA TURMA         " . PHP_EOL;
    echo "==========================================" . PHP_EOL;
    echo "Média da turma : " . number_format($mediaTurma, 2, ',', '.') . PHP_EOL;
    echo "Maior nota     : " . number_format($maiorNota, 2, ',', '.') . PHP_EOL;
    echo "Menor nota     : " . number_format($menorNota, 2, ',', '.') . PHP_EOL;
    echo "Aprovados      : $aprovados" . PHP_EOL;
    echo "Reprovados     : $reprovados" . PHP_EOL;
    echo "==========================================" . PHP_EOL;
}
?>