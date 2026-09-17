<?php

function verificarSituacao(float $nota): string {
    return ($nota >= 7.0) ? "APROVADO" : "REPROVADO";
}

function exibirAluno(array $aluno): void {
    $situacao = verificarSituacao($aluno['nota']);
    $notaFormatada = number_format($aluno['nota'], 1, ',', '.');

    echo "Nome : " . $aluno['nome'] . PHP_EOL;
    echo "Idade : " . $aluno['idade'] . PHP_EOL;
    echo "Curso : " . $aluno['curso'] . PHP_EOL;
    echo "Nota : " . $notaFormatada . PHP_EOL;
    echo "Situação : " . $situacao . PHP_EOL;
    echo "--------------------------" . PHP_EOL;
}

function listarAlunos(array $alunos): void {
    foreach ($alunos as $aluno) {
        exibirAluno($aluno);
    }
}

$alunos = [
    [
        "nome" => "Miriam",
        "idade" => 15,
        "curso" => "ADS",
        "nota" => 8.5
    ],
    [
        "nome" => "Adson",
        "idade" => 18,
        "curso" => "ADS",
        "nota" => 6.5
    ]
];

// Chamada da função para exibir a lista
listarAlunos($alunos);

?>