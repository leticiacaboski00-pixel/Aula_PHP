<?php
// Função para cadastrar os 5 alunos
function cadastrarAlunos(): array {
    $alunos = [];

    for ($i = 1; $i <= 5; $i++) {
        echo "--- Cadastro do Aluno $i ---" . PHP_EOL;

        echo "Nome: ";
        $nome = readline();

        echo "Nota: ";
        $nota = (float) readline();

        $alunos[] = [
            "nome" => $nome,
            "nota" => $nota
        ];
        echo PHP_EOL;
    }

    return $alunos;
}

// Função para verificar se um único aluno foi aprovado ou reprovado
function verificarSituacao(float $nota): string {
    return ($nota >= 7.0) ? "APROVADO" : "REPROVADO";
}

// Função para listar os alunos com nome, nota e situação
function listarAlunos(array $alunos): void {
    echo "===== RELATÓRIO =====" . PHP_EOL;

    foreach ($alunos as $aluno) {
        $situacao = verificarSituacao($aluno['nota']);
        $notaFormatada = number_format($aluno['nota'], 1, '.', '');

        echo "{$aluno['nome']} - {$notaFormatada} - {$situacao}" . PHP_EOL;
    }
    echo "=====================" . PHP_EOL . PHP_EOL;
}

// Função para calcular a média geral da turma
function calcularMedia(array $alunos): float {
    $totalAlunos = count($alunos);
    if ($totalAlunos === 0) {
        return 0.0;
    }

    $somaNotas = 0.0;
    foreach ($alunos as $aluno) {
        $somaNotas += $aluno['nota'];
    }

    return $somaNotas / $totalAlunos;
}

// Função para contar a quantidade de alunos aprovados (nota >= 7.0)
function contarAprovados(array $alunos): int {
    $aprovados = 0;
    foreach ($alunos as $aluno) {
        if ($aluno['nota'] >= 7.0) {
            $aprovados++;
        }
    }
    return $aprovados;
}

// Função para contar a quantidade de alunos reprovados (nota < 7.0)
function contarReprovados(array $alunos): int {
    $reprovados = 0;
    foreach ($alunos as $aluno) {
        if ($aluno['nota'] < 7.0) {
            $reprovados++;
        }
    }
    return $reprovados;
}

// Função para exibir o resumo dos indicadores
function mostrarResumo(array $alunos, float $media, int $aprovados, int $reprovados): void {
    $totalAlunos = count($alunos);
    $mediaFormatada = number_format($media, 2, ',', '.');

    echo "===== RESUMO DA TURMA =====" . PHP_EOL;
    echo "Quantidade de alunos : {$totalAlunos}" . PHP_EOL;
    echo "Aprovados            : {$aprovados}" . PHP_EOL;
    echo "Reprovados           : {$reprovados}" . PHP_EOL;
    echo "Média da turma       : {$mediaFormatada}" . PHP_EOL;
    echo "===========================" . PHP_EOL;
}

// --- PROGRAMA PRINCIPAL ---

$alunos = cadastrarAlunos();
listarAlunos($alunos);

$media = calcularMedia($alunos);
$aprovados = contarAprovados($alunos);
$reprovados = contarReprovados($alunos);

mostrarResumo($alunos, $media, $aprovados, $reprovados);
?>