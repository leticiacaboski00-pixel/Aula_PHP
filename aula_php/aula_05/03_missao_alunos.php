<?php
// Função responsável por cadastrar os 4 alunos utilizando arrays associativos
function cadastrarAlunos(): array {
    $alunos = [];

    for ($i = 1; $i <= 4; $i++) {
        echo "--- Cadastro do Aluno $i ---" . PHP_EOL;

        echo "Nome: ";
        $nome = readline();

        echo "Idade: ";
        $idade = (int) readline();

        echo "Nota: ";
        $nota = (float) readline();

        // Estrutura do array associativo individual
        $aluno = [
            "nome" => $nome,
            "idade" => $idade,
            "nota" => $nota
        ];

        // Adiciona o aluno no array principal
        $alunos[] = $aluno;
        echo PHP_EOL;
    }

    return $alunos;
}

// Função responsável por retornar a situação do aluno com base na nota
function verificarSituacao(float $nota): string {
    if ($nota >= 7.0) {
        return "APROVADO";
    }
    return "REPROVADO";
}

// Função responsável por percorrer e listar o relatório completo dos alunos
function listarAlunos(array $alunos): void {
    echo "==========================================" . PHP_EOL;
    echo "          RELATÓRIO DOS ALUNOS            " . PHP_EOL;
    echo "==========================================" . PHP_EOL;

    foreach ($alunos as $aluno) {
        $situacao = verificarSituacao($aluno['nota']);
        $notaFormatada = number_format($aluno['nota'], 1, ',', '.');

        echo "Nome: {$aluno['nome']}" . PHP_EOL;
        echo "Idade: {$aluno['idade']} anos" . PHP_EOL;
        echo "Nota: $notaFormatada" . PHP_EOL;
        echo "Situação: $situacao" . PHP_EOL;
        echo "------------------------------------------" . PHP_EOL;
    }
}

// --- EXECUÇÃO DO PROGRAMA ---

// 1. Cadastrar os alunos
$alunos = cadastrarAlunos();

// 2. Exibir a listagem dos alunos com suas situações
listarAlunos($alunos);
?>