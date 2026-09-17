<?php
// Função responsável por solicitar e cadastrar 5 funcionários no array
function cadastrarFuncionarios(): array {
    $funcionarios = [];

    for ($i = 1; $i <= 5; $i++) {
        echo "Digite o nome do funcionário $i: ";
        $nome = readline();
        $funcionarios[] = $nome; // Adiciona o nome ao final do array
    }

    return $funcionarios;
}

// Função responsável por percorrer e exibir todos os funcionários cadastrados
function listarFuncionarios(array $lista): void {
    echo PHP_EOL . "--- LISTA DE FUNCIONÁRIOS ---" . PHP_EOL;
    
    foreach ($lista as $index => $nome) {
        $numero = $index + 1;
        echo "$numero. $nome" . PHP_EOL;
    }
}

// Função responsável por retornar a quantidade total de cadastros
function contarFuncionarios(array $lista): int {
    return count($lista);
}

// --- EXECUÇÃO DO PROGRAMA ---

// 1. Chamada da função para realizar o cadastro
$funcionarios = cadastrarFuncionarios();

// 2. Exibição da lista de funcionários
listarFuncionarios($funcionarios);

// 3. Exibição do total cadastrado
$total = contarFuncionarios($funcionarios);
echo "------------------------------" . PHP_EOL;
echo "Total de funcionários cadastrados: $total" . PHP_EOL;
?>
