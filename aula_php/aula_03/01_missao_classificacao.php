<?php
// Entrada de dados
echo "Digite o nome da pessoa: ";
$nome = readline();

echo "Digite a idade: ";
$idade = (int) readline();

// Variável para armazenar a classificação
$classificacao = "";

// Avaliação das condições na ordem correta
if ($idade <= 0) {
    $classificacao = "IDADE INVÁLIDA";
} elseif ($idade < 12) {
    $classificacao = "CRIANÇA";
} elseif ($idade <= 17) {
    $classificacao = "ADOLESCENTE";
} elseif ($idade <= 59) {
    $classificacao = "ADULTO";
} else {
    $classificacao = "IDOSO";
}

// Exibição dos resultados
echo PHP_EOL;
echo "--- RESULTADO DA CLASSIFICAÇÃO ---" . PHP_EOL;
echo "Nome: $nome" . PHP_EOL;
echo "Idade: $idade" . PHP_EOL;
echo "Classificação: $classificacao" . PHP_EOL;
?>